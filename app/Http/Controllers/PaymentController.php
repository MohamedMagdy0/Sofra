<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::where(function ($query) use ($request) {
            $query->where('paid', 'like', '%'.$request->keyword.'%');
            $query->orWhere('notes', 'like', '%'.$request->keyword.'%');
            $query->orWhere('restaurant_id', 'like', '%'.$request->keyword.'%');
            $query->orWhere('order_id', 'like', '%'.$request->keyword.'%');
            $query->orWhere('date_of_paid', 'like', '%'.$request->keyword.'%');
        })->latest('id','DESC')->paginate(10);
        return view('payments.index',compact('payments'));
    } //  index


    public function create()
    {
        return view('payments.create')->with('restaurants',Restaurant::get()) ;
    } //create


    public function store(Request $request)
    {
        $this->validate($request,[
            'paid' => 'required' ,
            'notes' => 'required|string' ,
            'restaurant_id' => 'required|exists:restaurants,id' ,
            'order_id' => 'required|exists:orders,id' ,
            'date_of_paid' => 'required|date' ,
        ]);

        $payment = Payment::create($request->all());
        toastr()->success('تم حفظ البيانات بنجاح');
        return redirect()->route('payments.index');
    }  //  store



    public function edit($payment)
    {
        $payment = Payment::findOrFail($payment);
        return view('payments.edit',compact('payment'))->with('restaurants',Restaurant::get()) ;
    }  //edit


    public function update(Request $request,$payment)
    {
        $this->validate($request,[
            'paid' => 'required' ,
            'notes' => 'required|string' ,
            'restaurant_id' => 'required|exists:restaurants,id' ,
            'order_id' => 'required|exists:orders,id' ,
            'date_of_paid' => 'required|date' ,
        ]);

        $payment = Payment::FindOrFail($payment)->update($request->all());
        toastr()->warning('تم تحديث البيانات بنجاح');
        return redirect()->route('payments.index');
    } // update




    // start softDelete

    public function softDelete($id)
    {
        $payment = Payment::findOrFail($id)->delete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('payments.index');
    }  //  softDelete


    public function trash()
    {
        $payments = Payment::onlyTrashed()->paginate(10);
        return view('payments.trash',compact('payments'));
    }  //  trash


    public function restore($id)
    {
        $payment = Payment::withTrashed()->findOrFail($id);
        $payment->restore();
        toastr()->warning('تم ارجاع البيانات بنجاح');
        return redirect()->route('payments.index');
    }  // estore


    public function destroy($payment)
    {
        $payment = Payment::withTrashed()->FindOrFail($payment);
        $payment->forceDelete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('payments.index');
    } //  destroy

}
