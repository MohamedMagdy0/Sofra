<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
     public function index()
    {
        $districts = District::paginate(10);
        return view('districts.index',compact('districts')) ;
    } // index


    public function create()
    {
        $district = District::get();
        return view('districts.create',compact('district'))->with('cities',City::get()) ;
    } //create


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required' ,
            'city_id' => 'required|exists:cities,id' ,
        ]);
        $district = District::create($request->all());
        toastr()->success('تم حفظ البيانات بنجاح');
        return redirect()->route('districts.index');
    }  //  store


    public function show()
    {
        //
    }


    public function edit($district)
    {
        $district = District::findOrFail($district);
        return view('districts.edit',compact('district'))->with('cities',City::get()) ;
    }  //edit


    public function update(Request $request,$district)
    {
        $this->validate($request, [
            'name' => 'required' ,
        ]);
        $district = District::findOrFail($district)->update($request->all());
        toastr()->warning('تم تحديث البيانات بنجاح');
        return redirect()->route('districts.index');
    } // update





    // start softDelete

    public function softDelete($id)
    {
        $districts = District::findOrFail($id)->delete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('districts.index');
    }  //  softDelete


    public function trash()
    {
        $districts = District::onlyTrashed()->paginate(10);
        return view('districts.trash',compact('districts'));
    }  //  trash


    public function Restore($id)
    {
        $district = District::withTrashed()->findOrFail($id);
        $district->restore();
        toastr()->warning('تم ارجاع البيانات بنجاح');
        return redirect()->route('districts.index');
    }  // cityRestore


    public function destroy($district)
    {
        $district = District::withTrashed()->FindOrFail($district);
        $district->forceDelete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('districts.index');
    } //  destroy
}
