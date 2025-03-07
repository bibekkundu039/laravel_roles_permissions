<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;



class PermissionController extends Controller
{
    //this method is show pemissions page
    public function index(){
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    //this method is show create permission page
    public function create(){
        return view('permissions.create');
    }

    //this method is create permission in DB
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:permissions|min:3',
        ]);
    
        if($validator->passes()){
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success','Permission created successfully');
        }else{
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

    //this method is show edit permission page
    public function edit($id){
        $permission = Permission::find($id);
        return view('permissions.edit', compact('permission'));
    }

    //this method is update permission
    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:permissions|min:3',
        ]);

        if($validator->passes()){
            $permission = Permission::find($id);
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.index')->with('success','Permission updated successfully');
        }else{
            return redirect()->route('permissions.edit', $id)->withInput()->withErrors($validator);
        }

    }


    //this method is delete permission in DB
    public function destroy(Request $request){
        $permission = Permission::find($request->id);

        if($permission == null){
            session()->flash('error', 'Permission not found.');
            return response()->json([
                'status' => 'error',
                'message' => 'Permission not found',
            ]);
        }else{
            $permission->delete();
            session()->flash('success', 'Permission deleted successfully.');
            return response()->json([
                'status' => 'success',
                'message' => 'Permission deleted successfully',
            ]);

        }
    }
}
