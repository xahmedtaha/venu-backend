<?php

namespace App\Http\Controllers\Api\UserApi;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Resturant;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Models\BranchTable;
use Illuminate\Support\Facades\Auth;

class TableController extends ApiBaseController
{
    public function scanTable(Request $request,$tableHash)
    {
        $table = BranchTable::where('hash',$tableHash)->with(['branch'])->first();
        if(!$table)
            abort(404);
        if($table->merged_into)
            $table = BranchTable::find($table->merged_into);
        $user = Auth::user();

        if($table && $table->state == BranchTable::STATE_AVAILABLE)
        {
            if($user->active_cart)
            {
                if ($user->active_cart->table_id != $table->id)
                    return $this->sendErrorMessage('This is not your table',406);
            }

//            if($this->awayFromBranch($table->branch,$request->header('Lat'),$request->header('Lng')))
//            {
//                return $this->sendErrorMessage('You are not in the branch',407);
//            }
            $order = $table->initOrder();
            return $this->checkInTable($table);
        }
        elseif($table && $table->state == BranchTable::STATE_BUSY)
        {
            $user = Auth::user();
            if($user->active_cart)
            {
                if ($user->active_cart->table_id == $table->id)
                    return $this->reCheckInTable($table);
                else
                    return $this->sendErrorMessage('This is not your table',406);
            }
            else
                return $this->checkInTable($table);
            return $this->sendErrorMessage('Table is Busy!',406);
        }
        else
        {
            return $this->sendErrorMessage('Not Found',404);
        }
    }

    public function scanTableV2(Request $request,$tableHash, $nfcUid)
    {
        $table = BranchTable::where('hash',$tableHash)->with(['branch'])->first();
        if(!$table){
            return $this->sendErrorMessage('This Table is not found',404);
        }

        if($table->nfc_uid != NULL && $table->nfc_uid != $nfcUid){
            return $this->sendErrorMessage('Tag does not belong to this Table',406);
        }
        if($table->merged_into)
            $table = BranchTable::find($table->merged_into);
        $user = Auth::user();

        if($table && $table->state == BranchTable::STATE_AVAILABLE)
        {
            if($user->active_cart)
            {
                if ($user->active_cart->table_id != $table->id)
                    return $this->sendErrorMessage('This is not your table',406);
            }

//            if($this->awayFromBranch($table->branch,$request->header('Lat'),$request->header('Lng')))
//            {
//                return $this->sendErrorMessage('You are not in the branch',407);
//            }
            $order = $table->initOrder();
            return $this->checkInTable($table);
        }
        elseif($table && $table->state == BranchTable::STATE_BUSY)
        {
            $user = Auth::user();
            if($user->active_cart)
            {
                if ($user->active_cart->table_id == $table->id)
                    return $this->reCheckInTable($table);
                else
                    return $this->sendErrorMessage('This is not your table',406);
            }
            else
                return $this->checkInTable($table);
            return $this->sendErrorMessage('Table is Busy!',406);
        }
        else
        {
            return $this->sendErrorMessage('Not Found',404);
        }
    }

    public function scanSharedTable(Request $request,$tableShareCode)
    {
        $table = BranchTable::where('share_code',$tableShareCode)->with(['branch'])->first();
        if($table)
        {
//            if($this->awayFromBranch($table->branch,$request->header('Lat'),$request->header('Lng')))
//            {
//                return $this->sendErrorMessage('You are not in the branch',407);
//            }
            $user = Auth::user();
            if($user->active_cart)
            {
                return $this->reCheckInTable($table);
            }
            $order = $table->getActiveOrder();

            return $this->checkInTable($table);
        }
        else
        {
            return $this->sendErrorMessage('Not Found',404);
        }
    }

    private function checkInTable(BranchTable $table)
    {
        $user = Auth::user();
        $cart = $user->initCart($table,$table->getActiveOrder());
        $response = $this->createScanObject($table, $cart);
        return $this->sendResponse($response);
    }

    private function reCheckInTable(BranchTable $table)
    {
        $user = Auth::user();
        $cart = $user->active_cart;
        $response = $this->createScanObject($table, $cart);
        return $this->sendResponse($response);
    }

    public function callWaiter(Request $request)
    {
        $value = $request->is_calling_waiter;
        $user = Auth::user();
        $cart = $user->active_cart;
        $table = $cart->table;
        $table->setCallWaiter($value);
        return $this->sendResponse(['message'=>'success']);
    }
    /*
     * Checks if the user is currently in branch
     * */
    private function awayFromBranch($branch,$lat,$lng)
    {
        $distance = haversineGreatCircleDistance( $branch->lat, $branch->lng , $lat, $lng);
        return $distance > $branch->range;
    }

    /**
     * @param BranchTable $table
     * @param $cart
     * @return array
     */
    private function createScanObject(BranchTable $table, $cart): array
    {
        $branch = $table->branch;
        /**
         * @var Resturant $resturant
         */
        $resturant = $branch->resturant;
        $categories = $resturant->itemCategories;
        $response = [
            'table' => $table->makeHidden('branch'),
            'resturant' => $resturant->load('images','theme'),
            'categories' => $categories,
            'cart_id' => $cart->id
        ];
        return $response;
    }
}
