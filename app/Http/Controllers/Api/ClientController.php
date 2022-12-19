<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Token;
use App\Models\Client;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Restaurant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\FireBaseTrait;
use App\Traits\ResponseTrait;
use App\Mail\ResetPasswordClient;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    use ResponseTrait;
    use FireBaseTrait;

        public function register(Request $request)
    {
        // 1- validation
        $validator = Validator::make($request->all(), [
            'name' => 'required' ,
            'email' => 'required|unique:clients,email' ,
            'phone' => 'required' ,
            'password' => 'required|confirmed|min:8' ,
            'image' => 'nullable|image' ,
            'district_id' => 'required' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422, $validator->errors()->first(), $validator->errors());
        }

        $client = Client::create($request->all());
        $client->api_token = Str::random(60);

        if($request->has('image')){
            $path = $request->image->store('public/images/clients');
            $client->image = $this->$path;
        }
        $client->save();
        if ($client) {
            return $this->responseJson(200,'تم انشاء حساب جديد',['client'=>$client,'api_token'=>$client->api_token  ]);
        } else {
            return $this->responseJson(500,'error','تأكد من البيانات');
        }
    } // register



    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:clients,email' ,
            'password' => 'required|min:8' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422, $validator->errors()->first(), $validator->errors());
        }

        $client = Client::where('email', $request->email)->first();

        if ($client) {
            if (Hash::check($request->password, $client->password)) {
                return $this->responseJson(200,'تم تسجيل الدخول بنجاح', ['client'=>$client , 'api_token'=>$client->api_token]);

            } else {
                return $this->responseJson(500, 'برجاء ادخال البيانات صحيحة');
            }
        } else {
            return $this->responseJson(500, 'برجاء التأكد من البيانات المرسلة');
        }//  if($client)
    }// login




    public function resetPassword(Request $request)
    {
        // 1- validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:clients,email' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422, $validator->errors()->first(), $validator->errors());
        }

        //2 find the restaurant
        $client = Client::where('email', $request->email)->first() ;

        // 3 if we have that client do
        if ($client) {
            $pin_code = rand(111111, 999999);
            $clientUpdate = $client->update(['pin_code' => $pin_code]);

            // 4  send SMS  || email
            // smsMisr($request->phone,"Your Reset Password Code Is : ".$pin_code);

            if ($clientUpdate) {

                Mail::to($client->email)
                    // ->cc($moreUsers) // carbon copy
                    ->bcc("mohamedmagdii99@gmail.com") // blind carbon copy
                    ->queue(new ResetPasswordClient($pin_code));

                // $send = $this->notifyByFirebase($title, $body, $tokens, $data) ;

                return $this->responseJson(200, 'برجاء فحص البريد الالكتروني',$client->pin_code);
            } //if($clientUpdate)


        } else {
            return $this->responseJson(500,'برجاء التأكد من البيانات المرسلة');
        } // if($client)

    }//resetPassword



    public function newPassword(Request $request)
    {
        // 1 validation
        $validator = Validator::make($request->all(), [
            'pin_code' => 'required|exists:clients,pin_code|numeric' ,
            'phone' => 'required|exists:clients,phone' ,
            'password' => 'required|confirmed|min:8' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422, $validator->errors()->first(), $validator->errors());
        }

        // 2 get the client
        $client = Client::where('phone',$request->phone)->where('pin_code',$request->pin_code)->where('pin_code','!=',0)->first();

        // 3 if we have client with conditions do
        if($client){
            $client->where('password',bcrypt($request->password));
            $client->pin_code = null ;
            $client->save() ;
        }else{
            return $this->responseJson(500,'برجاء التأكد من البيانات المرسلة');
        }// if($client

        if($client->save()){
            return $this->responseJson(200,'تم تغيير كلمة المرور',$client);
        }else{
            return $this->responseJson(500,'هناك حطأ');
        }// if($client->save())

    } // newPassword



     public function registerTokens(Request $request)  //CREATE
    {
      //validation
        $validator = Validator::make($request->all(),[
            'token'=>'required|string',
            'type'=>'required|string',
          ]);

        if ($validator->fails()) {
            return $this->responseJson(422,$validator->errors()->first(),$validator->errors()) ;
        }

        $token = Token::where('token',$request->token)->delete();

        $request->user()->tokens()->create($request->all());

        return $this->responseJson(200, 'تم التسجيل بنجاح');
    }// registerToken





     public function removeToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422,$validator->errors()->first(),$validator->errors()) ;
        }

        // delete old token
        $removeToken = Token::where('token',$request->token)->delete();
        if($removeToken){
            return $this->responseJson(200,'تم الحذف بنجاح') ;
        }
        return $this->responseJson(500,'لم يتم الحذف بنجاح') ;
    } //  removeToken



     public function profile(Request $request)
    {
        $client = Client::where('id',$request->user()->id)->first();
        return $this->responseJson(200,'تم العرض بنجاح',$client) ;
    }// profile




    public function editProfile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required' ,
            'email' => 'required' ,
            'phone' => 'required' ,
            'image' => 'nullable|image' ,
            'district_id' => 'required' ,
        ]);


        if ($validator->fails()) {
            return $this->responseJson(422, $validator->errors()->first(), $validator->errors()) ;
        }

        $client = Client::where('id', $request->user()->id)->first();
        $oldImage = $client->image ;

       if($request->has('image')){
            $path = $request->image->store('public/images/clients');
            Storage::delete($oldImage) ;
        }else{
           $path = $client->image ;
        }

        $data = $client->update([
            'name' => $request->name ,
            'email' => $request->email ,
            'phone' => $request->phone ,
            'image' => $path ,
            'district_id' => $request->district_id ,
        ]);

        if($data){
            return $this->responseJson(200,'تم التعديل بنجاح',$client) ;
        }else{
            return $this->responseJson(500, 'لم يتم التعديل بنجاح') ;
        }
    }// editProfile


    ################### ########## ##############      ##############   ##############
    // $notifications = $request->user()->notifictions()->latest()->paginate();
    // $order = null
    // $notification = $order->notifiction()->create(['title' => '','content' => '']);
    // $notification->restaurants()->attach($request->restaurant_id)


    public function newOrder(Request $request)
    {
        // 1- validation
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id' ,
            'items.*.item_id' => 'required|exists:items,id' ,
            'items.*.quantity' => 'required' ,
            'address' => 'required' ,
            'payment_method_id' => 'required' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422, $validator->errors()->first(), $validator->errors()) ;
        }

        // 2- if restaurant closed
        $restaurant = Restaurant::find($request->restaurant_id);

        if($request->status == 'closed'){
            return $this->responseJson(500,' (مغلق)نأسف المطعم غير متاح حاليا ',);
        }

        //3- create order
        $order = $request->user()->orders()->create([
            'restaurant_id' => $request->restaurant_id ,
            'address' => $request->address ,
            'state' => 'pending' ,
            'notes' => $request->notes ,
            'payment_method_id' => $request->payment_method_id ,
        ]);

        $total = 0 ;
        $delivery_fee = $restaurant->delivery_fee ;

        // get items[] -> from mobile and foreach it
        foreach ($request->items as $i) {
            $item = Item::find($i['item_id']);
            // dd($item);

            $readyItem = [
                $i['item_id'] => [
                    'quantity'=>$i['quantity'] ,
                    'price'=>$item->price,
                    'notes'=>isset($i['notes']) ? $i['notes'] : '' ,
                ],
            ];

            $order->items()->attach($readyItem);

            $total = $total + ( $item->price * $i['quantity'] ) ;

        }//foreach

        $settings = Setting::first(); // ##########

        // if order > min-charge
        if($total >= $restaurant->min_charge){

            $total_price = $total + $delivery_fee ;
            $appComission = $settings->commission * $total ;
            $net = $total_price - $settings->commission ;
            // dd($net);
            // $net = $total_price - $comission ;

            $updateOrder = $order->update([
                'delivery_fee' => $delivery_fee ,
                'total' => $total ,
                'app_commission' => $appComission ,
                'total_price' => $total_price ,
                'net' => $net ,
            ]);

            // remove items || order from cart
            // $request->user()->cart()->detache() ;

            // notify restaurant - new order
            $restaurant->notifications()->create([
                'title' => 'لديك طلب جديد' ,
                'content' => '  لديك طلب جديد من العميل'.$request->user()->name  ,
                'order_id' => $order->id  ,
            ]);

            // $tokens = Token::get();

            $title = 'لديك طلب جديد' ;
            // dd($title) ;
            $body = 'لديك طلب جديد من العميل'.$request->user()->name ;

            $tokens =  $restaurant->tokens()->where('token','!=','')->pluck('token')->toArray();
            dd($tokens);

            $data = [ 'order' => $order->fresh()->load('items') ] ;

            $send = $this->notifyByFirebase($title,$body,$tokens,$data) ;
            return $this->responseJson(200,'تم الطلب بنجاح ',$data) ;

        }else{
            $order->items()->delete() ;
            $order->delete() ;
            return $this->responseJson(500,' عذرا قيمة اقل طلب'.$restaurant->min_charge) ;
        }

    }//order



    public function previousOrders(Request $request)
    {
        $previousOrders = $request->user()->orders()->whereIn('state',['rejected' , 'delivered'])->latest('id','DESC')->paginate(10);

        if($previousOrders){
            return $this->responseJson(200,'تم العرض بنجاح',$previousOrders) ;
        }else{
            return $this->responseJson(500,'عذرا هناك خطأ في العرض') ;
        }
        // $previousOrders = Order::where(function($query)use($request){
        //     $query->whereIn('state' , ['rejected' , 'delivered']) ;
        //     $query->where('client_id',$request->user()->id) ;
        // })->latest('id','DESC')->paginate(10);
    } // previousOrders



    public function currentOrders(Request $request)
    {

        $currentOrders = $request->user()->orders()->whereIn('state', ['pending' , 'accepted'])->latest('id', 'DESC')->paginate(10);

        if($currentOrders){
            return $this->responseJson(200,'تم العرض بنجاح',$currentOrders) ;
        }else{
            return $this->responseJson(500,'عذرا هناك خطأ في العرض') ;
        }

        // $currentOrders = Order::where(function($query)use($request){
        //     $query->whereIn('state', ['pending' , 'accepted']) ;
        //     $query->where('client_id',$request->user()->id) ;
        // })->paginate(10);
    } // currentOrders




    public function addReview(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required' ,
            'comment' => 'required' ,
            'rating' => 'required' ,
            'restaurant_id' => 'required' ,
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors()) ;
        }

        $review = $request->user()->reviews()->create($request->all());

        if($review){
            return $this->responseJson(200,'تم العرض بنجاح',$review) ;
        }else{
            return $this->responseJson(500,'عذرا هناك خطأ في العرض') ;
        }
        // $reviews = Review::where(function($query) use($request){
        //     $query->where('restaurant_id',$request->restaurant_id);
        //     $query->where('client_id',$request->client_id);
        // })->create($request->all());

    }//addReview


}
