<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Token;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Restaurant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\FireBaseTrait;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordRestaurant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    use ResponseTrait;
    use FireBaseTrait;


    public function register(Request $request)
    {
        // 1- validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:restaurants,name' ,
            'email' => 'required|unique:restaurants,email' ,
            'phone' => 'required|unique:restaurants,phone' ,
            'password' => 'required|confirmed|min:8' ,
            'min_charge' => 'required' ,
            'image' => 'nullable|image' ,
            'status' => 'required' ,
            'delivery_fee' => 'required' ,
            'district_id' => 'required' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422, $validator->errors()->first(), $validator->errors());
        }

        $restaurant = Restaurant::create($request->all());
        $restaurant->api_token = Str::random(60);

        if ($request->has('image')) {
            $path = $request->image->store('public/images/restaurants');
            $restaurant->image = $this->$path;
        }
        $restaurant->save();

        if ($restaurant) {
            return $this->responseJson(200, 'تم انشاء حساب جديد', ['restaurant'=>$restaurant,'api_token'=>$restaurant->api_token]);
        } else {
            return $this->responseJson(500, 'error', 'تأكد من البيانات');
        }
    } // registerRestaurant



    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:restaurants,email' ,
            'password' => 'required|min:8' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422, $validator->errors()->first(), $validator->errors());
        }

        $restaurant = Restaurant::where('email', $request->email)->first();

        if ($restaurant) {
            if (Hash::check($request->password, $restaurant->password)) {
                return $this->responseJson(200, 'تمت تسجيل الدخول بنجاح', ['restaurant'=>$restaurant,'api_token'=>$restaurant->api_token]);
            } else {
                return $this->responseJson(500, 'برجاء ادخال البيانات صحيحة');
            }
        } else {
            return $this->responseJson(500, 'برجاء التأكد من رقم الهاتف');
        }//  if($restaurant)
    }// loginRestaurant



    public function resetPassword(Request $request)
    {
        // 1- validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:restaurants,email' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        //2 find the restaurant
        $restaurant = Restaurant::where('email', $request->email)->first() ;

        // 3 if we have that client do
        if ($restaurant) {
            $pin_code = rand(111111, 999999);
            $restaurantUpdate = $restaurant->update(['pin_code' => $pin_code]);

            // 4  send SMS  || email
            // smsMisr($request->phone,"Your Reset Password Code Is : ".$pin_code);

            if ($restaurantUpdate) {
                Mail::to($restaurant->email)
                    // ->cc($moreUsers) // carbon copy
                    ->bcc("mohamedmagdii99@gmail.com") // blind carbon copy
                    ->queue(new ResetPasswordRestaurant($pin_code));

                return $this->responseJson(200, 'برجاء فحص البريد الالكتروني', $restaurant->pin_code);
            } //if($restaurantUpdate)
        } else {
            return $this->responseJson(0, 'برجاء التأكد من البيانات المرسلة ');
        } // if($restaurant)
    }//resetPasswordRestaurant





    public function newPassword(Request $request)
    {
        // 1 validation
        $validator = Validator::make($request->all(), [
            'pin_code' => 'required|exists:restaurants,pin_code|numeric' ,
            'phone' => 'required|exists:restaurants,phone' ,
            'password' => 'required|confirmed|min:8' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(500, $validator->errors()->first(), $validator->errors());
        }

        // 2 get the restaurant
        $restaurant = Restaurant::where('phone', $request->phone)->where('pin_code', $request->pin_code)->where('pin_code', '!=', 0)->first();

        // 3 if we have restaurant with conditions do
        if ($restaurant) {
            $restaurant->pin_code = null ;
            $restaurant->save() ;
        } else {
            return $this->responseJson(500, 'برجاء التأكد من البيانات المرسلة');
        }// if($restaurant

        if ($restaurant->save()) {
            return $this->responseJson(200, 'تم تغيير كلمة المرور', $restaurant);
        } else {
            return $this->responseJson(500, 'هناك حطأ');
        }// if($restaurant->save())
    } // newPasswordRestaurant




     public function registerTokens(Request $request)
     {
         //validation
         $validator = Validator::make($request->all(), [
             'token'=>'required|string',
             'type'=>'required|string',
           ]);

         if ($validator->fails()) {
             return $this->responseJson(500, $validator->errors()->first(), $validator->errors()) ;
         }

         $token = Token::where('token', $request->token)->delete();

         $request->user()->tokens()->create($request->all());

         return $this->responseJson(200, 'تم التسجيل بنجاح');
     }// registerToken





     public function removeToken(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'token' => 'required' ,
         ]);

         if ($validator->fails()) {
             return $this->responseJson(422, $validator->errors()->first(), $validator->errors()) ;
         }

         // delete old token
         Token::where('token', $request->token)->delete();

         return $this->responseJson(200, 'تم الحذف بنجاح') ;
     } //  removeToken



    public function profile(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->user()->id)->first();
        return $this->responseJson(200, 'تم العرض بنجاح', $restaurant) ;
    }// profile



    public function editProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required' ,
            'email' => 'required' ,
            'phone' => 'required' ,
            'min_charge' => 'required' ,
            'delivery_fee' => 'required' ,
            'image' => 'nullable|image' ,
            'district_id' => 'required' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422, $validator->errors()->first(), $validator->errors()) ;
        }

        $restaurant = Restaurant::where('id', $request->user()->id)->first();
        $oldImage = $restaurant->image ;

        if ($request->has('image')) {
            $path = $request->image->store('public/images/clients');
            // Storage::delete($oldImage) ;
        } else {
            $path = $restaurant->image ;
        }

        $data = $restaurant->update([
            'name' => $request->name ,
            'email' => $request->email ,
            'phone' => $request->phone ,
            'min_charge' => $request->min_charge ,
            'delivery_fee' => $request->delivery_fee ,
            'image' => $path ,
            'district_id' => $request->district_id ,
        ]);

        if ($data) {
            return $this->responseJson(200, 'تم التعديل بنجاح', $restaurant) ;
        } else {
            return $this->responseJson(500, 'لم يتم التعديل بنجاح') ;
        }
    }// editProfile



    public function myOrders(Request $request)
    {
        $myOrders = $request->user()->orders()->where('client_id', $request->client_id)->latest('id', 'DESC')->paginate(10);
        if ($myOrders) {
            return $this->responseJson(200, 'تم العرض بنجاح', $myOrders) ;
        } else {
            return $this->responseJson(500, 'عذرا هناك خطأ في العرض') ;
        }
        // $myOrders = Order::where(function($query)use($request){
        //     $query->where('client_id',$request->client_id) ;
        //     $query->where('restaurant_id',$request->user()->id) ;
        // })->orderBy('id','DESC')->paginate(10);
    } // myOrders





    public function previousOrders(Request $request)
    {
        $previousOrders = $request->user()->orders()->whereIn('state', ['rejected','delivered'])->latest('id', 'DESC')->paginate(10);
        if ($previousOrders) {
            return $this->responseJson(200, 'تم العرض بنجاح', $previousOrders) ;
        } else {
            return $this->responseJson(500, 'عذرا هناك خطأ في العرض') ;
        }
        // $previousOrders = Order::where(function($query)use($request){
        //     $query->whereIn('state',['rejected','delivered']) ;
        //     $query->where('restaurant_id',$request->user()->id) ;
        // })->orderBy('id','DESC')->paginate(10);
    } // previousOrders



    public function myNewOrders(Request $request)
    {
        $myNewOrders = $request->user()->orders()->where('state', 'pending')->latest('id', 'DESC')->paginate(10);
        if ($myNewOrders) {
            return $this->responseJson(200, 'تم العرض بنجاح', $myNewOrders) ;
        } else {
            return $this->responseJson(500, 'عذرا هناك خطأ في العرض') ;
        }
        // $currentOrders = Order::where(function($query)use($request){
        //     $query->whereIn('state',['pending']) ;
        //     $query->where('restaurant_id',$request->user()->id) ;
        // })->orderBy('id','DESC')->paginate(10);
    } // mynewOrders




    public function currentOrders(Request $request)
    {
        $currentOrders = $request->user()->orders()->where('state', 'accepted')->latest('id', 'DESC')->paginate(10);
        if ($currentOrders) {
            return $this->responseJson(200, 'تم العرض بنجاح', $currentOrders) ;
        } else {
            return $this->responseJson(500, 'عذرا هناك خطأ في العرض') ;
        }
        // $currentOrders = Order::where(function($query)use($request){
        //     $query->where('state','accepted') ;
        //     $query->where('restaurant_id',$request->user()->id) ;
        // })->orderBy('id','DESC')->paginate(10);
    } // currentOrders



    ########## error #######  $client line 340 ..................


    public function acceptOrder(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'state' => 'required|in:accepted' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422, $validator->errors()->first(), $validator->errors()) ;
        }
        $order = tap(Order::find($id))->update(['state'=>'accepted']);
        $restaurant= $request->user();
        $client = $order->client ;

        if ($restaurant) {
            $client->notifications()->create([
                'title' => 'تم قبول طلبك' ,
                'content' => 'تم قبول مطلبك من مطعم '.$request->user()->name  ,
                'order_id' => $request->id  ,
            ]);

            $title = 'تم قبول طلبك' ;
            $body = 'تم قبول مطلبك من مطعم '.$request->user()->name  ;
            $tokens =  $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();
            $data = [ 'order' => $order->fresh()->load('items') ] ;

            $send = $this->notifyByFirebase($title, $body, $tokens, $data) ;

            return $this->responseJson(200, 'تم قبول الطلب بنجاح ', $data) ;
        } else {
            return $this->responseJson(500, 'عذرا هناك خطأ') ;
        } // if($acceptOrder)
    } // acceptOrder



    public function rejectOrder(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'state' => 'required|in:rejected' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422, $validator->errors()->first(), $validator->errors()) ;
        }

        $order = tap(Order::find($id))->update(['state'=>'rejected']);
        $restaurant= $request->user();
        $client = $order->client;

        if ($restaurant) {
            $client->notifications()->create([
                'title' => 'تم رفض طلبك' ,
                'content' => 'تم رفض مطلبك من مطعم '.$request->user()->name  ,
                'order_id' => $restaurant->id  ,
            ]);

            $title = 'تم رفض طلبك' ;
            $body = 'تم رفض مطلبك من مطعم '.$request->user()->name  ;
            $tokens =  $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();
            $data = [ 'order' => $order->fresh()->load('items') ] ;

            $send = $this->notifyByFirebase($title, $body, $tokens, $data) ;

            return $this->responseJson(200, 'تم رفض الطلب بنجاح ', $data) ;
        } else {
            return $this->responseJson(500, 'عذرا هناك خطأ') ;
        } // if($rejectOrder)
    } // rejectOrder



    public function deliveredOrder(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'state' => 'required|in:delivered' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422, $validator->errors()->first(), $validator->errors()) ;
        }

        $order = tap(Order::find($id))->update(['state'=>'delivered']);
        $restaurant= $request->user();
        $client = $order->client;

        // $restaurant = $request->user()->orders()->update(['state'=>'delivered']) ;
        // $client = Client::orders()->where('id', $request->client_id);

        if ($restaurant) {
            $client->notifications()->create([
                'title' => 'تم توصيل طلبك' ,
                'content' => 'تم توصيل من مطعم '.$request->user()->name  ,
                'order_id' => $restaurant->id  ,
            ]);

            $title = 'تم تسليم طلبك' ;
            $body = 'تم تسليم مطلبك من مطعم '.$request->user()->name  ;
            $tokens =  $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();
            $data = [ 'order' => $order->fresh()->load('items') ] ;

            $send = $this->notifyByFirebase($title, $body, $tokens, $data) ;

            return $this->responseJson(200, 'تم توصيل الطلب بنجاح ', $data) ;
        } else {
            return $this->responseJson(500, 'عذرا هناك خطأ') ;
        } // if($deliveredOrder)
    } // deliveredOrder


    public function commissions(Request $request)
    {
        // get sum of total orders  $request->orders()->completed()->sum('total')
        // get sum of total commissions of orders
        // get sum of payemnts
        // remaining = step 2 - step 3

        // return [
        //             'total_sales' => 'setp 1',
        //             'comissions' => 'setp 2',
        //             'payments' => 'step 3',
        //             'remaing' => 'step 4'
        //         ];

        // 1
        $orders = $request->user()->orders()->where('state', 'delivered')->get();
        if (!$orders == null) {
            foreach ($orders as $order) {
                $total =   $orders->sum('total');
            }

            // 2
            $settings = Setting::first() ;
            $appCommission = $total * $settings->commission ;

            // 3
            $payment = Payment::first() ;
            $payments = $payment->paid ;
            if ($payments == null) {
                $payments = 0 ;
            }

            // 4
            $remaing = $appCommission - $payments ;

            $data = [' اجمالي سعر الطلب ' . $total,' عمولة التطبيق ' . $appCommission,' المدفوع ' . $payments,' المتبقي ' . $remaing] ;
            return $this->responseJson(200, 'بيانات عمولة التطبيق', $data) ;
        } else {
            return $this->responseJson(200, ' عذرا لا يوجد بيانات لعمولة التطبيق حاليا') ;
        }
    }
}
