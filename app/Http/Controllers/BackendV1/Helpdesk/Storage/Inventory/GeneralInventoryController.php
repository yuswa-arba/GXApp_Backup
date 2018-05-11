<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Inventory;

use App\Http\Controllers\Controller;
use App\Storage\Logics\Inventory\InsertToInventoryLogic;
use App\Storage\Models\StorageGeneralInventory;
use App\Storage\Models\StoragePurchaseOrders;
use App\Storage\Transformers\StorageGeneralInventoryListTransformer;
use App\Storage\Transformers\StoragePurchaseOrderInventoryTransformer;
use App\Traits\GlobalUtils;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

class GeneralInventoryController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {

    }


    public function getList(Request $request)
    {
        $response = array();

        // is valid
        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data


        if ($employee && $employee->hasResigned != 1) {

//            $generalInventory = StorageGeneralInventory::orderBy('id', 'desc')->paginate(50); //default get all
            $generalInventory = StorageGeneralInventory::whereHas('inventoryItem', function ($query) {
                $query->whereHas('item', function ($query) {
                    $query->orderBy('name', 'desc');
                });
            })->paginate(50);

            if ($generalInventory) {
                $response['isFailed'] = false;
                $response['message'] = 'Success';
                $response['generalInventory'] = fractal($generalInventory, new StorageGeneralInventoryListTransformer());

                return response()->json($response, 200);

            } else {

                $response['isFailed'] = true;
                $response['message'] = 'No General Inventory found';
                return response()->json($response, 200);
            }

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }

    }

    public function search(Request $request)
    {
        $response = array();

        if ($request->v != '' && $request->v != null) {

            $search = $request->v;

            $generalInventory = StorageGeneralInventory::where(function ($query) use ($search) {
                $query->where('serialNumber', 'like', '%' . $search . '%')
                    ->orWhereHas('inventoryItem', function ($query) use ($search) {
                        $query->whereHas('item', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%')
                                ->orWhere('itemCode', 'like', '%' . $search . '%');
                        });
                    });
            })->orderBy('id', 'desc')->paginate(50); // default get all

        } else {
            $generalInventory = StorageGeneralInventory::orderBy('id', 'desc')->paginate(50); //default get all
        }

        if ($generalInventory) {
            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['generalInventory'] = fractal($generalInventory, new StorageGeneralInventoryListTransformer());

            return response()->json($response, 200);

        } else {

            $response['isFailed'] = true;
            $response['message'] = 'No General Inventory found';
            return response()->json($response, 200);
        }
    }

    public function generateQRCode(Request $request)
    {
        $qrCodeData = array();


        if (count($request->get('id'))>0) {

            $i = 0;

            foreach ($request->get('id') as $itemId) {

                $item = StorageGeneralInventory::find($itemId);

                if ($item) {

                    $id = $item->inventoryItemId;
                    $itemName = $this->getResultWithNullChecker2Connection($item, 'inventoryItem', 'item', 'name');
                    $serialNumber = $item->serialNumber;
                    $salesPrice = $this->getResultWithNullChecker2Connection($item, 'inventoryItem', 'item', 'latestSellingPrice');

                    $arr = ['name' => $itemName, 'SN' => $serialNumber, 'ID' => $id, 'sales_price' => $salesPrice];

                    $qrCodeData[$i]['id'] = $id;
                    $qrCodeData[$i]['name'] = $itemName;
                    $qrCodeData[$i]['SN'] = $serialNumber;
                    $qrCodeData[$i]['data'] = json_encode($arr);

                    $i++;
                }


            }


        }

        $pdf = PDF::loadView('layouts.pdf.qrcode_inventory', compact('qrCodeData'))
            ->setPaper('a4')->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);;
        return $pdf->stream('test-qr-code' . '.pdf');

//        return view('layouts.pdf.qrcode_inventory',compact('qrCodeData') );
    }

}
