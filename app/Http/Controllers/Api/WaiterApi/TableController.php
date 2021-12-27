<?php

namespace App\Http\Controllers\Api\WaiterApi;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\WaiterApi\CheckoutRequest;
use App\Http\Resources\Order;
use App\Models\Branch;
use App\Models\BranchTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TableController extends ApiBaseController
{
    public function getTables()
    {
        $branch = Auth::user()->branch;
        $tables = $branch->tables;
        return $this->sendResponse($tables);
    }

    public function getTable($branchTable)
    {
        $table = BranchTable::find($branchTable);
        if (!$table)
            abort(404);

        $order = $table->getActiveOrder();
        return $order ? new Order($order) : $this->sendErrorMessage('No orders on this table', 202);
    }

    public function checkout(CheckoutRequest $request, BranchTable $table)
    {
        if (!Hash::check($request->password, $table->branch->password)) {
            return $this->sendErrorMessage('Wrong password', 406);
        }

        $order = $table->getActiveOrder();
        if ($order) {
            $order->close();
            $table->clear();
            return new Order($order);
        } else {
            $table->clear();
            return $this->sendResponse(['message' => 'success']);
        }
    }

    public function turnOffCallWaiter(Request $request, BranchTable $branchTable)
    {
        $branchTable->setCallWaiter(false);
        return $this->sendResponse(['message' => 'success']);
    }

    public function transfer(Request $request)
    {
        /**
         * @var BranchTable $sourceTable
         * @var BranchTable $destinationTable
         */
        $sourceTable = BranchTable::findOrFail($request->source_table_id);
        $destinationTable = BranchTable::findOrFail($request->destination_table_id);
        $transferResult = $destinationTable->transferOrderFromTable($sourceTable);
        if(!$transferResult) {
            return $this->sendResponse("Cannot transfer to busy table");
        }
        return $this->sendResponse(['message'=>'success']);
    }

    public function merge(Request $request)
    {
        $tables = collect([]);
        foreach ($request->tables as $table_id)
        {
            $table = BranchTable::find($table_id);
            $tables->add($table);
        }
        /**
         * @var Branch $branch
         */
        $branch = Auth::user()->branch;
        $tableNumbers = $tables->pluck('number')->toArray();
        $mergedTableNumber = "Merge of Table : ".implode(', ',$tableNumbers);
        /**
         * @var BranchTable $mergedTable
         */
        $mergedTable = $branch->tables()->create(['number' => $mergedTableNumber,'is_merged_table'=>true]);
        $mergedTable->mergeTablesWithMe($tables);

    }
}
