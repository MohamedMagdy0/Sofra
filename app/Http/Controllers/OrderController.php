<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Exports\OrderExport;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where(function ($query) use ($request) {
            $query->where('state', 'like', '%'.$request->keyword.'%');
            $query->orWhere('client_id', 'like', '%'.$request->keyword.'%');
            $query->orWhere('restaurant_id', 'like', '%'.$request->keyword.'%');
            $query->orWhere('address', 'like', '%'.$request->keyword.'%');
            $query->orWhereHas('restaurant', function ($query) use ($request) {
                $query->where('name', 'like', '%$'.$request->keyword.'%');
            });
        })->latest('id', 'DESC')->paginate(10);
        // dd($orders);
        return view('orders.index', compact('orders'));
    } //  index


    public function show($id)
    {
        $order = Order::find($id);
        return view('orders.show', compact('order'));
    }  //  show


    // start softDelete

    public function softDelete($id)
    {
        $order = Order::findOrFail($id)->delete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('orders.index');
    }  //  softDelete


    public function trash()
    {
        $orders = Order::onlyTrashed()->latest('id', 'DESC')->paginate(10);
        return view('orders.trash', compact('orders'));
    }  //  trash


    public function restore($id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        $order->restore();
        toastr()->warning('تم ارجاع البيانات بنجاح');
        return redirect()->route('orders.index');
    }  // restore


    public function destroy($order)
    {
        $order = Order::withTrashed()->FindOrFail($order);
        $order->forceDelete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('orders.index');
    } //  destroy



    public function export()
    {
        return Excel::download(new OrderExport(), 'orders.xlsx');
    }
}//end OrderController
