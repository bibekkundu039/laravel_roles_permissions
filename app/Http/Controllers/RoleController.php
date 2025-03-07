<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::orderBy('name', 'asc')->paginate(4);
        $permissions = Permission::all();
        return view('roles.index', compact('roles', 'permissions'));
    }

    public function create() {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:roles|min:3',
            'permissions' => 'required|array|min:1'
        ]);

        if($validator->passes()) {
            $role = Role::create(['name' => $request->name]);

            if(!empty($request->permissions)) {
                foreach($request->permissions as $name) {
                    $role->givePermissionTo($name);
                }
            }
            return redirect()->route('roles.index')->with('success','Role created successfully');
        }else{
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }

    public function edit($id){
        $role = Role::find($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id){ 
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'permissions' => 'required|array|min:1'
        ]);

        if($validator->passes()) {
            $role = Role::find($id);
            $role->name = $request->name;
            $role->save();

            if(!empty($request->permissions)) {
                $role->syncPermissions($request->permissions);
                // foreach($request->permissions as $name) {
                //     $role->givePermissionTo($name);
                // }
            }

            return redirect()->route('roles.index')->with('success','Role updated successfully');
        }else{
            return redirect()->route('roles.edit', $id)->withInput()->withErrors($validator);
        }
    }

    public function destroy(Request $request) {
        $role = Role::find($request->id);

        if($role == null){
            session()->flash('error', 'Role not found');
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found'
            ]);
        }else{
            $role->delete();
            session()->flash('success', 'Role deleted successfully.');
            return response()->json([
                'status' => 'success',
                'message' => 'Role deleted successfully'
            ]);
        }
    }
}
