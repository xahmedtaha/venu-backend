<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Resturant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view employees'])->only(['index']);
        $this->middleware(['permission:add employees'])->only(['create','store']);
        $this->middleware(['permission:update employees'])->only(['edit','update']);
        $this->middleware(['permission:delete employees'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employee.all',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function create()
    {
        $employee  = new Employee();
        $resturants = Resturant::all();
        $roles = Role::all();
        return view('employee.add',compact('employee','resturants','roles'));
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
            "name"=>"required",
            "is_admin"=>"required",
            "role_id"=>"required_if:is_admin,0",
            "email"=>"required|email|unique:employees,email",
            "password"=>"required"
        ]);
        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }
        $name = $request->name;
        $is_admin = $request->is_admin;
        $all_resturants = $request->all_resturants;
        $resturants = $request->resturants;
        $role_id = $request->role_id;
        $email = $request->email;
        $password = Hash::make($request->password);
        $level = $is_admin==1?'SuperAdmin':'Employee';
        $employee = Employee::create([
            "name"=>$name,
            "email"=>$email,
            "password"=>$password,
            "level"=>$level
        ]);

        if(!$is_admin)
        {
            $employee->assignRole($role_id);
            if($all_resturants)
            {
                $resturants = Resturant::query()->pluck('id')->toArray();
            }
            $employee->resturants()->attach($resturants);
        }

        return redirect()->route('employee.index');
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
     * @param  Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $resturants = Resturant::all();
        $roles = Role::all();
        return view('employee.add',compact('resturants','roles','employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        
        $validator = Validator::make($request->all(),[
            "name"=>"required",
            "is_admin"=>"required",
            "role_id"=>"required_if:is_admin,0",
            "email"=>"required|email|",
            "password"=>"required"
        ]);
        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }
        $name = $request->name;
        $is_admin = $request->is_admin;
        $all_resturants = $request->all_resturants;
        $resturants = $request->resturants;
        $role_id = $request->role_id;
        $email = $request->email;
        $password = Hash::make($request->password);
        $level = $is_admin==1?'SuperAdmin':'Employee';
        $employee->update([
            "name"=>$name,
            "email"=>$email,
            "password"=>$password,
            "level"=>$level
        ]);

        if(!$is_admin)
        {
            $employee->assignRole($role_id);
            if($all_resturants)
            {
                $resturants = Resturant::query()->pluck('id')->toArray();
            }
            $employee->resturants()->attach($resturants);
        }

        return redirect()->route('employee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return back();
    }
}
