<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Item;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Token;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Category;
use App\Models\District;
use App\Models\Restaurant;
// use Illuminate\Validation\Validator;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Traits\FireBaseTrait;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    use ResponseTrait;
    use FireBaseTrait;



    public function addOffer(Request $request)
    {
          $validator = Validator::make($request->all(),[
            'title'=>'required|string',
            'content'=>'required',
            'image'=>'required|image',
            'start_date'=>'required',
            'end_date'=>'required',
            // 'restaurant_id'=>'required',
          ]);

        if ($validator->fails()) {
            return $this->responseJson(422,$validator->errors()->first(),$validator->errors()) ;
        }

        $path = $request->image->store('public/images/offers');
        $offer = $request->user()->offers()->create($request->all(),['image'=>$path]);
        // $offer = Offer::where(function($query){
        //     $query->where('restaurant_id',$request->user()->id);
        // })->create($request->all(),['image'=>$path]);

        return $this->responseJson(200,'تم الاضافة بنجاح',$offer) ;
    }// offers.add




    public function editOffer(Request $request,$id)
    {
          $validator = Validator::make($request->all(),[
            'title'=>'required|string',
            'content'=>'required',
            'image'=>'nullable|image',
            'start_date'=>'required',
            'end_date'=>'required',
            // 'restaurant_id'=>'required',
          ]);

        if ($validator->fails()) {
            return $this->responseJson(422,$validator->errors()->first(),$validator->errors()) ;
        }

        $offer = Offer::find($id) ;
        // $oldImage = $offer->image ;

        if($request->hasFile('image')){
            $path = $request->file('image')->store('public/images/offers');
            $request->merge(['image' => $path]);
            // Storage::delete($oldImage);
        }else{
            $path = $offer->image ;
        }
        // dd($request->user()->offers());
        $offer = $request->user()->offers()->update($request->except('_method'));
        // $offer = $request->user()->offers()->update([
        //     'title'=>$request->title,
        //     'content'=>$request->content,
        //     'image'=>$path,
        //     'start_date'=>$request->start_date,
        //     'end_date'=>$request->end_date,
        // ]);
        return $this->responseJson(200,'تم الاضافة بنجاح',$offer) ;

        // $offer = Offer::where(function($query){
        //     $query->where('restaurant_id',$request->user()->id);
        // })->update($request->all(),['image'=>$path]);
    }// offers.edit




}
