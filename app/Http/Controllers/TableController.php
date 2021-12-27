<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchTable;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Branch $branch)
    {
        $tables = $branch->tables;
        return view('table.all',compact('branch','tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Branch $branch)
    {
        $table = new BranchTable();
        return view('table.form',compact('branch','table'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Branch $branch)
    {
        $request->validate([
            'number' => 'required'
        ]);

        $table = $branch->tables()->create($request->except('test_mode'));

        if($request->test_mode)
            $table->update(['hash'=>md5('1')]); //c4ca4238a0b923820dcc509a6f75849b static for test mode
        else
            $table->update(['hash'=>md5('venu'.$table->id)]);

        return redirect()->route('branches.tables.index',['branch'=>$branch->id])->with('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit(Branch $branch,BranchTable $table)
    {
        return view('table.form',compact('table','branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch,BranchTable $table)
    {
        $request->validate([
            'number' => 'required'
        ]);

        $table->update($request->except('test_mode'));
//
        if($request->test_mode)
            $table->update(['hash'=>md5('1')]); //c4ca4238a0b923820dcc509a6f75849b static for test mode
        else
            $table->update(['hash'=>md5('venu'.$table->id)]);
        return redirect()->route('branches.tables.index',['branch'=>$branch->id])->with('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch,BranchTable $table)
    {
        if($table->status == BranchTable::STATE_BUSY)
            return back()->with('error','لا يمكن مسح طاولة مشغولة');
        $table->delete();
        return back();
    }

    public function qrCode(Branch $branch,BranchTable $table)
    {
        return view('table.qrCode',compact('table'));
    }
}
