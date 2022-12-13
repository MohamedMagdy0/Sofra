<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $restaurants = Restaurant::where(function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->keyword.'%');
            $query->orWhere('email', 'like', '%'.$request->keyword.'%');
            $query->orWhere('phone', 'like', '%'.$request->keyword.'%');
        })->latest('id','DESC')->paginate(10);
        return view('restaurants.index',compact('restaurants'));
    } //  index


    public function create()
    {
        return view('restaurants.create') ;
    } //create


    public function edit($restaurant)
    {
        $restaurant = Restaurant::findOrFail($restaurant);
        return view('restaurants.edit',compact('restaurant'))->with('districts',District::get()) ;
    }  //edit


    public function update(Request $request,$restaurant)
    {

        $this->validate($request, [
            'name' => 'required' ,
            'email' => 'required' ,
            'image' => 'nullable' ,
            'phone' => 'required' ,
            // 'password' => 'required' ,
            'min_charge' => 'required' ,
            'delivery_fee' => 'required' ,
            'district_id' => 'required' ,
        ]);


        $restaurant = Restaurant::FindOrFail($restaurant);
        $oldImage = $restaurant->image;

        if($request->has('image')){
            $path = $request->image->store('public/images/restaurants') ;
        //   Storage::delete($oldImage);
        }else {
            $path = $restaurant->image ;
        }

        // $restaurant = $restaurant->update($request->all());

        $restaurant->update([
            'image' => $path,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'min_charge' => $request->min_charge,
            'delivery_fee' => $request->delivery_fee,
            'district_id' => $request->district_id,
        ]);

        toastr()->warning('تم تحديث البيانات بنجاح');
        return redirect()->route('restaurants.index');
    } // update

    // start softDelete

    public function softDelete($id)
    {
        $restaurant = Restaurant::findOrFail($id)->delete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('restaurants.index');
    }  //  softDelete


    public function trash()
    {
        $restaurants = Restaurant::onlyTrashed()->latest('id','DESC')->paginate(10);
        return view('restaurants.trash',compact('restaurants'));
    }  //  trash


    public function restore($id)
    {
        $restaurant = Restaurant::withTrashed()->findOrFail($id);
        $restaurant->restore();
        toastr()->warning('تم ارجاع البيانات بنجاح');
        return redirect()->route('restaurants.index');
    }  // estore


    public function destroy($restaurant)
    {
        $restaurant = Restaurant::withTrashed()->FindOrFail($restaurant);
        $restaurant->forceDelete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('restaurants.index');
    } //  destroy



        public function status(Request $request, $id)
        {

            $restaurant = tap(Restaurant::findOrFail($id))->update(['status' => $request->status]) ;
            return back() ;

            // if ($request->id) {
            //     $user->where('id', $request->id)->update(['is_active' => $request->is_active]) ;
            //     return back() ;
            // }
        }  // isActive

}
