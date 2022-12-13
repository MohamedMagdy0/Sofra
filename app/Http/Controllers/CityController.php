<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{

    public function index()
    {
        $cities = City::paginate(10);
        return view('cities.index',compact('cities')) ;
    } // index


    public function create()
    {
        $cities = City::get();
        return view('cities.create',compact('cities')) ;
    } //create


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required' ,
        ]);
        $city = City::create($request->all());
        toastr()->success('تم حفظ البيانات بنجاح');
        return redirect()->route('cities.index');
    }  //  store


    public function show()
    {
        //
    }


    public function edit($city)
    {
        $city = City::findOrFail($city);
        return view('cities.edit',compact('city')) ;
    }  //edit


    public function update(Request $request,$city)
    {
        $this->validate($request, [
            'name' => 'required' ,
        ]);
        $city = City::findOrFail($city)->update($request->all());
        toastr()->warning('تم تحديث البيانات بنجاح');
        return redirect()->route('cities.index');
    } // update





    // start softDelete

    public function softDelete($id)
    {
        $cities = City::findOrFail($id)->delete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('cities.index');
    }  //  softDelete


    public function cityTrash()
    {
        $cities = City::onlyTrashed()->paginate(10);
        return view('cities.trash',compact('cities'));
    }  //  cityTrash


    public function cityRestore($id)
    {
        $city = City::withTrashed()->findOrFail($id);
        $city->restore();
        toastr()->warning('تم ارجاع البيانات بنجاح');
        return redirect()->route('cities.index');
    }  // cityRestore


    public function destroy($city)
    {
        $city = City::withTrashed()->FindOrFail($city);
        $city->forceDelete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('cities.index');
    } //  destroy
}
