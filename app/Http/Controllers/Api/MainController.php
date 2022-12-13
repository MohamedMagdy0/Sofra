<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Item;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Token;
use App\Models\Client;
use App\Models\Review;
use App\Models\Contact;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Category;
use App\Models\District;
// use Illuminate\Validation\Validator;
use App\Models\Restaurant;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Traits\FireBaseTrait;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    use ResponseTrait;
    use FireBaseTrait;

    public function categories()
    {
        $categories = Category::get();
        return $this->responseJson(200, 'تم العرض بنجاح', $categories);
    }//categories



    public function cities()
    {
        $cities = City::with('districts')->get();
        return $this->responseJson(200, 'تم العرض بنجاح', $cities);
    }//cities


    public function districts(Request $request)
    {
        $districts = District::whereHas('city', function ($query) use ($request) {
            if ($request->has('city_id')) {
                $query->where('city_id', $request->city_id);
            }
        })->paginate(10);
        return $this->responseJson(200, 'تم العرض بنجاح', $districts);
    }//districts


    public function clients(Request $request)
    {
        $clients = Client::where(function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->keyword.'%');
            $query->orWhere('email', 'like', '%'.$request->keyword.'%');
            $query->orWhere('phone', 'like', '%'.$request->keyword.'%');
        })->get();
        return $this->responseJson(200, 'تم العرض بنجاح', $clients);
    }//clients


    public function contacts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required' ,
            'email' => 'required' ,
            'phone' => 'required' ,
            'type' => 'required' ,
            'message' => 'required' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422, $validator->errors()->first(), $validator->errors()) ;
        }

        $contacts = Contact::create($request->all());  /// create
        return $this->responseJson(200, 'تم العرض بنجاح', $contacts);
    }//contacts


    public function items(Request $request,$id)
    {
        $items = Item::where('restaurant_id',$request->id)->latest('id','desc')->paginate(10);
        return $this->responseJson(200,'تم العرض بنجاح',$items);
    }//items


    public function offers(Request $request)
    {
        $offers = Offer::with('restaurant')->latest('id','DESC')->paginate(10);
        return $this->responseJson(200, 'تم العرض بنجاح', $offers);
    }// offers.index


    public function notifications()
    {
        $notifications = Notification::latest('id','DESC')->paginate(10);
        return $this->responseJson(200, 'تم العرض بنجاح',$notifications);
    }//notifications


    public function paymentMethod()
    {
        $paymentMethod = PaymentMethod::get();
        return $this->responseJson(200,'تم العرض بنجاح',$paymentMethod);
    }//paymentMethod


    public function restaurants(Request $request)
    {
       $restaurants = Restaurant::where(function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->keyword.'%');
            $query->orWhere('email', 'like', '%'.$request->keyword.'%');
            $query->orWhere('phone', 'like', '%'.$request->keyword.'%');
        })->latest('id','DESC')->with('orders')->paginate(10);
        return $this->responseJson(200, 'تم العرض بنجاح', $restaurants);
    }// restaurants


    public function Reviews(Request $request)
    {
       $reviews = Review::where('restaurant_id',$request->restaurant_id)->latest('id','DESC')->paginate(10);
        return $this->responseJson(200, 'تم العرض بنجاح', $reviews);
    }// Reviews


    public function settings()
    {
        $settings = Setting::first();
         return $this->responseJson(200, 'تم العرض بنجاح', $settings);
    }




}//MainController
