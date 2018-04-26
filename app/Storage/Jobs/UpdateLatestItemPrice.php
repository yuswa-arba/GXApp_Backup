<?php
namespace App\Storage\Jobs;

use App\Storage\Models\StorageItems;
use App\Storage\Models\StoragePurchaseOrderItems;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 21/12/17
 * Time: 11:43 AM
 */
class UpdateLatestItemPrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;

    public function __construct()
    {

    }

    /**
     * update item prices
     * get latest purchased item from purchase order items DB and
     * update the storage item price based on it
     */
    public function handle()
    {

        $storageItems = StorageItems::all();

        foreach ($storageItems as $storageItem){

            $purchasedOrderItem = StoragePurchaseOrderItems::where('itemId',$storageItem->id)
                ->orderBy('id','desc')->first();

            if($purchasedOrderItem){
                $storageItem->latestPurchasedPrice = $purchasedOrderItem->pricePurchased;
                $storageItem->latestSellingPrice = $purchasedOrderItem->pricePurchased * 200 /100;
                $storageItem->save();
            }
        }


    }


}