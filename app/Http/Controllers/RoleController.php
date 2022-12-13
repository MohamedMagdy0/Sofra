<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);
        return view('roles.index', compact('roles'));
    } //  index

    public function create()
    {
        $permissions = Permission::get();
        return view('roles.create', compact('permissions')) ;
    } //create

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:roles,name' ,
            'guard_name' => 'required|string|unique:roles,guard_name' ,
            // 'description' => 'nullable|unique:roles,description' ,
            'permissions_list' => 'required|array' ,
        ]);
        $role = Role::create($request->except('permissions_list'));
        $role->givePermissionTo($request->permissions_list);

        toastr()->success('تم حفظ البيانات بنجاح');
        return redirect()->route('roles.index');
    }  //  store

    public function show($role)
    {
        //
    }
    public function edit($role)
    {
        $role = Role::findOrFail($role);
        return view('roles.edit', compact('role'))->with('permissions', Permission::get()) ;
    }  //edit


    public function update(Request $request, $role)
    {
        $this->validate($request, [
            'name' => 'required' ,
            'guard_name' => 'required' ,
            // 'description' => 'nullable|unique:roles,description' ,
            'permissions_list' => 'required|array' ,
        ]);

        $role = Role::FindOrFail($role);
        $role->update($request->except('permissions_list'));
        $role->syncPermissions($request->permissions_list);
        // return $role ;

        toastr()->warning('تم تحديث البيانات بنجاح');
        return redirect()->route('roles.index');
    } // update

    public function destroy($role)
    {
        $role = Role::findOrFail($role);
        $role->delete();

        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('roles.index');
    } //  destroy
}

