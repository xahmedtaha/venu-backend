<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Resturant;
use App\Models\Waiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class WaiterController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:view waiters'])->only(['index']);
        $this->middleware(['permission:add waiters'])->only(['create','store']);
        $this->middleware(['permission:update waiters'])->only(['edit','update']);
        $this->middleware(['permission:delete waiters'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $waiters = Waiter::all();
        return view('waiter.all',compact('waiters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resturants = Resturant::all();
        $branches   = Branch::all();
        $waiter = new Waiter();
        return view('waiter.add',compact('resturants','branches','waiter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name"         => "required",
            "email"        => "required|email|unique:waiters,email",
            "resturant_id" => "required",
            "branch_id"    => "required",
            "password"     => "required"
        ]);
        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }
        $name         = $request->name;
        $resturant_id = $request->resturant_id;
        $branch_id    = $request->branch_id;
        $email        = $request->email;
        $password     = Hash::make($request->password);
        $waiter       = Waiter::create([
                    "name"         => $name,
                    "email"        => $email,
                    "password"     => $password,
                    "resturant_id" => $resturant_id,
                    "branch_id"    => $branch_id
                     ]);

        return redirect()->route('waiter.index');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function edit(Waiter $waiter)
    {
        $resturants = Resturant::all();
        $branches   = Branch::all();
        return view('waiter.add',compact('waiter','resturants','branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Waiter $waiter)
    {
        $validator = Validator::make($request->all(),[
            "name"         => "required",
            "email"        => "required|email",
            "resturant_id" => "required",
            "branch_id"    => "required",
            "password"     => "required"
        ]);
        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }
        $name         = $request->name;
        $resturant_id = $request->resturant_id;
        $branch_id    = $request->branch_id;
        $email        = $request->email;
        $password     = Hash::make($request->password);
        $arr = [
                "name"         => $name,
                "email"        => $email,
                "password"     => $password,
                "resturant_id" => $resturant_id,
                "branch_id"    => $branch_id
                    ];
        $waiter->update($arr);

        return redirect()->route('waiter.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Waiter $waiter)
    {
        $waiter->delete();
        return back();
    }
    public function get_branchs($id)
    {
        $resturant = Resturant::find($id);
        $data  =   $resturant->branches->pluck('id','name_ar');
        return $data;
    }
}
