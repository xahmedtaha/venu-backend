<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view roles'])->only(['index']);
        $this->middleware(['permission:add roles'])->only(['create','store']);
        $this->middleware(['permission:update roles'])->only(['edit','update']);
    }

    public function index(Request $request)
    { 
        $roles = Role::all();
        $permissions = Permission::all();
        return view('groups.all',compact('roles','permissions'));
    } 
    
    public function create(Request $request)
    {
        $permissions = Permission::all();
        return view('groups.add',compact('permissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:roles,name',
        ],[
            'name.unique' => 'الاسم موجود من قبل'
        ]);
        
        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }

        $role = Role::create([
            "name"=>$request->name,
            "name_ar" => $request->name_ar
        ]);

        $role->syncPermissions($request->permissions);
        return redirect()->route('employee.roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('userRoles.editRole',compact('role','permissions'));
    }
    public function update(Request $request,Role $role)
    {
        $role->syncPermissions($request->permissions);
        return redirect()->route('employee.roles.index');
    }

    public function destroy(Role $role)
    {
        $users = $role->users;
        $role->delete();
        foreach($users as $user)
        {
            $user->forceDelete();
        }
        return back();
    }
}
