<?php

namespace App\Http\Controllers;


use App\Models\User;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // if (! auth()->user()->can('users-list') ) {
        //     abort(403) ;
        // }

        $users = User::paginate(10);

        return view('users.index', compact('users'))->with('roles', Role::get());
            //
    } // end of index

    public function create()
    {
        $roles = Role::get();
        return view('users.create', compact('roles'))->with('users',User::get());
    } // end of create


    public function store(Request $request)
    {
        // return $request ;
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'roles_list' => 'required|array',
        ]);


        $request->merge(['password'=> bcrypt($request->password)])  ;

        $user = User::create($request->except('roles_list'));

        $user->assignRole($request->roles_list) ;

        return redirect()->route('users.index');
    } // end of store


    public function show($user)
    {
        //
    } // show


    public function edit($user)
    {
        $user = User::find($user) ;
        return view('users.edit', compact('user'))->with('roles', Role::get());
    } //  edit



    public function update(Request $request, $user)
    {
        $request->validate([
            'name' => 'required',
            // 'email' => 'required|unique:users,email',
            // 'password' => 'required|confirmed',
            'roles_list' => 'required|array',
        ]);

        $request->merge(['password'=> bcrypt($request->password)])  ;

        $user = User::findOrFail($user) ;

        $user->syncRoles($request->roles_list) ;
        $user->update($request->except(['roles_list','email']));

        return redirect()->route('users.index');
    } // end of store



       // start softDelete

    public function softDelete($id)
    {
        $user = User::findOrFail($id)->delete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('users.index');
    }  //  softDelete


    public function trash()
    {
        $users = User::onlyTrashed()->latest('id','DESC')->paginate(10);
        return view('users.trash',compact('users'));
    }  //  trash


    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $restaurant->restore();
        toastr()->warning('تم ارجاع البيانات بنجاح');
        return redirect()->route('users.index');
    }  // estore


    public function destroy($user)
    {
        $user = User::findOrFail($user);
        $user->delete();
        return redirect()->route('users.index') ;
    }// destroy


}
