<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
      public function index(Request $request)
    {
        $offers = Offer::where(function ($query) use ($request) {
            $query->where('title', 'like', '%'.$request->keyword.'%');
            $query->orWhere('content', 'like', '%'.$request->keyword.'%');
        })->latest('id','DESC')->paginate(10);
        return view('offers.index',compact('offers'));
    } //  index


    public function create()
    {
        return view('offers.create')->with('restaurants',Restaurant::get()) ;
    } //create


    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required' ,
            'content' => 'required' ,
            'image' => 'required|image|mimes:png,jpg,jpeg,svg' ,
            'start_date' => 'required|date' ,
            'end_date' => 'required|date' ,
            'restaurant_id' => 'required|exists:restaurants,id' ,
        ]);

        $path = $request->image->store('/public/images/offers');

        $offer = new Offer ;
        $offer->image = $path;
        $offer->title = $request->title;
        $offer->content = $request->content;
        $offer->start_date = $request->start_date;
        $offer->end_date = $request->end_date;
        $offer->restaurant_id = $request->restaurant_id;
        $offer->save();
        toastr()->success('تم حفظ البيانات بنجاح');
        return redirect()->route('offers.index');
    }  //  store



    public function edit($offer)
    {
        $offer = Offer::findOrFail($offer);
        return view('offers.edit',compact('offer'))->with('restaurants',Restaurant::get()) ;
    }  //edit


    public function update(Request $request,$offer)
    {

        $this->validate($request, [
            'title' => 'required' ,
            'content' => 'required' ,
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg' ,
            'start_date' => 'required|date' ,
            'end_date' => 'required|date' ,
            'restaurant_id ' => 'exists:restaurants,id' ,
        ]);


        $offer = Offer::find($offer);
        $oldImage = $offer->image;

        if($request->has('image')){
          $path = $request->image->store('/public/images/offers');
          Storage::delete($oldImage);
        }else {
            $path = $offer->image ;
        }

        $offer->update([
            'image' => $path ,
            'title' => $request->title ,
            'content' => $request->content,
            'start_date' => $request->start_date ,
            'end_date' => $request->end_date ,
            'restaurant_id' => $request->restaurant_id ,
        ]);

        toastr()->warning('تم تحديث البيانات بنجاح');
        return redirect()->route('offers.index');
    } // update




    // start softDelete

    public function softDelete($id)
    {
        $offer = Offer::findOrFail($id)->delete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('offers.index');
    }  //  softDelete


    public function trash()
    {
        $offers = Offer::onlyTrashed()->paginate(10);
        return view('offers.trash',compact('offers'));
    }  //  trash


    public function restore($id)
    {
        $offer = Offer::withTrashed()->findOrFail($id);
        $offer->restore();
        toastr()->warning('تم ارجاع البيانات بنجاح');
        return redirect()->route('offers.index');
    }  // estore


    public function destroy($offer)
    {
        $offer = Offer::withTrashed()->FindOrFail($offer);
        $offer->forceDelete();
        toastr()->error('تم حذف البيانات بنجاح');return back();

        // return redirect()->route('offers.index');
    } //  destroy

}
