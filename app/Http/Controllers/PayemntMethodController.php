<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PayemntMethodController extends Controller
{
        public function index()
    {
        $payemntMethods = PaymentMethod::paginate(10);
        return view('payemnt-methods.index',compact('payemntMethods'));
    } //  index


    public function create()
    {
        return view('payemnt-methods.create') ;
    } //create


    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|unique:payment_methods,name' ,
        ]);

        $payemntMethod = PaymentMethod::create($request->all());
        toastr()->success('تم حفظ البيانات بنجاح');
        return redirect()->route('payemnt-methods.index');
    }  //  store



    public function edit($payemnt_method)
    {
        $payemntMethod = PaymentMethod::findOrFail($payemnt_method);
        return view('payemnt-methods.edit',compact('payemntMethod')) ;
    }  //edit


    public function update(Request $request,$payemnt_method)
    {
        $this->validate($request,[
            'name' => 'required|string' ,
        ]);

        $payemntMethod = PaymentMethod::FindOrFail($payemnt_method)->update($request->all());
        toastr()->warning('تم تحديث البيانات بنجاح');
        return redirect()->route('payemnt-methods.index');
    } // update




    // start softDelete

    public function softDelete($id)
    {
        $payemntMethod = PaymentMethod::findOrFail($id)->delete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('payemnt-methods.index');
    }  //  softDelete


    public function trash()
    {
        $payemntMethods = PaymentMethod::onlyTrashed()->paginate(10);
        return view('payemnt-methods.trash',compact('payemntMethods'));
    }  //  trash


    public function restore($id)
    {
        $payemntMethod = PaymentMethod::withTrashed()->findOrFail($id);
        $payemntMethod->restore();
        toastr()->warning('تم ارجاع البيانات بنجاح');
        return redirect()->route('payemnt-methods.index');
    }  // estore


    public function destroy($payemnt_method)
    {
        $payemntMethod = PaymentMethod::withTrashed()->FindOrFail($payemnt_method);
        $payemntMethod->forceDelete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('payemnt-methods.index');
    } //  destroy
}
