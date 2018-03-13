<?php

namespace App\Storage\Logics\PurchaseOrder;

use App\Components\Models\CompanyNPWP;
use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeListTransfomer;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Storage\Jobs\NotifyRequestTracking;
use App\Storage\Models\StorageItems;
use App\Storage\Models\StoragePurchaseOrderItems;
use App\Storage\Models\StoragePurchaseOrders;
use App\Storage\Models\StorageRequisition;
use App\Storage\Transformers\StorageItemDetailTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreatePurchaseOrderLogic extends CreateUseCase
{

    use GlobalUtils;


    public function handleCreate($request)
    {

        $response = array();

        // params
        $POForm = $request->POForm;
        $POItems = $request->POItems;

        //validate forms

        if ($this->POformIsValid($POForm)) {


            // Calculate total item price
            $totalItemPrice = $this->calculateTotalItemPrice($POItems);

            // Calculate tax
            $totalTax = 0;
            if ($POForm['taxFeeAdded']) {
                $totalTax = $this->calculateTotalTax($totalItemPrice);
            }

            // Calculate shipping fee
            $totalShippingFee = 0;
            if ($POForm['shippingFeeAdded']) {
                $totalShippingFee = $POForm['shippingFee'];
            }

            // Sum total price
            $finalPrice = (int)$totalItemPrice + (int)$totalTax + (int)$totalShippingFee;

            // Generate PO Number
            $latestPurchaseOrder = StoragePurchaseOrders::select('id')->orderBy('id', 'desc')->first();
            $incrementNumber = $latestPurchaseOrder ? ($latestPurchaseOrder->id + 1) : 1;//get latest id and add by 1
            $PONumber = 'PO' . Carbon::now()->format('ymd') . $this->zeroPrefix($incrementNumber, 3); //  yyyymmdd001 format

            // Insert it to DB
            $create = StoragePurchaseOrders::create([
                'purchaseOrderNumber' => $PONumber,
                'withRequisition' => $POForm['withRequisition'],
                'requisitionId' => $POForm['requisitionId'],
                'date' => Carbon::now()->format('d/m/Y'),
                'supplierId' => $POForm['supplierId'],
                'contactPerson' => $POForm['contactPerson'],
                'contactNumber' => $POForm['contactNumber'],
                'paymentTermId' => $POForm['paymentTermId'],
                'warehouseId' => $POForm['warehouseId'],
                'recipientName' => $POForm['recipientName'],
                'recipientNumber' => $POForm['recipientNumber'],
                'deliveryTermId' => $POForm['deliveryTermId'],
                'shippingVia' => $POForm['shippingVia'],
                'shippingMark' => $POForm['shippingMark'],
                'withTaxInvoice' => $POForm['withTaxInvoice'],
                'npwpNumber' => CompanyNPWP::find(1)->npwpNo, //PT IMAM NPWP
                'taxFeeAdded' => $POForm['taxFeeAdded'],
                'taxFee' => $totalTax,
                'shippingFeeAdded' => $POForm['shippingFeeAdded'],
                'shippingFee' => $totalShippingFee,
                'total' => $finalPrice,
                'currencyFormat' => $POForm['currencyFormat'],
                'notes' => $POForm['notes'],
                'insertedAt' => Carbon::now()->format('d/m/Y H:i'),
                'insertedBy' => $this->getResultWithNullChecker1Connection(Auth::user(), 'employee', 'givenName'),
            ]);

            if ($create) {

                $insertItemError = false;

                // Insert items
                foreach ($POItems as $item) {

                    $insert = StoragePurchaseOrderItems::create([
                        'purchaseOrderId' => $create->id, //PO id
                        'withRequisitionItem' => $item['withRequisitionItem'],
                        'requisitionItemId' => $item['requisitionItemId'],
                        'itemId' => $item['itemDetail']['id'],
                        'amountPurchased' => $item['amount'],
                        'unitIdPurchased' => $item['unitId'],
                        'hasCustomUnit' => $item['hasCustomUnit'],
                        'customUnit' => $item['customUnit'],
                        'pricePurchased' => $item['price'],
                        'currencyFormat' => $item['currencyFormat'],
                    ]);

                    if ($insert) {
                        //do nothing
                    } else {
                        // set an error occurred to true
                        $insertItemError = true;
                    }
                }

                // If any error occurred delete inserted items and PO as we;;
                if ($insertItemError) { // Error response

                    // delete inserted items
                    StoragePurchaseOrderItems::where('purchaseOrderId', $create->id)->delete();

                    // delete PO
                    $create->delete();

                    $response['isFailed'] = true;
                    $response['message'] = 'An error occurred during inserting item';
                    return response()->json($response, 200);

                } else { // Success response

                    if ($create->withRequisition) { // Notify user

                        $requisition = StorageRequisition::find($create->requisitionId);
                        $requisition->approvalId = ConfigCodes::$REQUISITION_APPROVAL_STATUS['IN_PROCESS'];

                        if ($requisition->save()) {

                            //Dispatch job to notify requester their request is in process
                            NotifyRequestTracking::dispatch(
                                $requisition->id, //requisition ID
                                Auth::user(), //user sender
                                'Your request is being processed #'.$requisition->requisitionNumber, //message
                                url('storage/requisition/history') //url to click
                                )
                                                ->onConnection('database')
                                                ->onQueue('broadcaster');

                        }
                    }

                    $response['isFailed'] = false;
                    $response['message'] = 'Purchase Order has been created successfully';
                    return response()->json($response, 200);

                }

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to create purchase order';
                return response()->json($response, 200);
            }


        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Form is invalid. Unable to process';
            return response()->json($response, 200);
        }


    }

    private function POformIsValid($POForm)
    {
        $isValid = true;

        // Check requisition and its ID
        if ($POForm['withRequisition']) {
            if ($POForm['requisitionId'] == '' || $POForm['requisitionId'] == null) {
                //Invalid
                $isValid = false;
            }
        }

        // Check supplier
        if ($POForm['supplierId'] == '' || $POForm['supplierId'] == null) {
            //Invalid
            $isValid = false;
        }

        return $isValid;
    }

    private function calculateTotalItemPrice($POItems)
    {
        $total = 0;

        // Loop thru items
        foreach ($POItems as $item) {
            $total = (int)$total + ((int)$item['amount'] * (int)$item['price']);
        }

        return $total;
    }

    private function calculateTotalTax($totalItemPrice)
    {
        return (int)$totalItemPrice * 10 / 100; //10%
    }
}