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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    use ResponseTrait;
    use FireBaseTrait;

    public function items(Request $request)
    {
        $items = $request->user()->items()->where(function($query) use($request){
            $query->where('name', 'like', '%'.$request->keyword.'%');
            $query->orWhere('description', 'like', '%'.$request->keyword.'%');
            $query->orWhere('price', 'like', '%'.$request->keyword.'%');
        })->with('categories')->latest('id','desc')->paginate(10);

        return $this->responseJson(200,'تم العرض بنجاح',$items) ;
    }// items.index


    public function addItem(Request $request)
    {
          $validator = Validator::make($request->all(),[
            'name'=>'required|string|unique:items,name',
            'description'=>'required',
            'price'=>'required',
            'sale_price'=>'nullable',
            'notes'=>'nullable',
            'service_time'=>'nullable|string',
            'image'=>'required|image',
            'category_id'=>'nullable|exists:categories,id',
          ]);

        if ($validator->fails()) {
            return $this->responseJson(422,$validator->errors()->first(),$validator->errors()) ;
        }

        $path = $request->image->store('public/images/items');
        $items = $request->user()->items()->create($request->all(),['image' => $path]);

        return $this->responseJson(200,'تم الاضافة بنجاح',$items) ;
    }// items.add



    public function editItem(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
            'price' => 'required' ,
            'sale_price' => 'nullable',
            'notes' => 'nullable',
            'service_time' => 'nullable' ,
            'image' => 'required|image' ,
            'category_id' => 'required' ,
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422, $validator->errors()->first(), $validator->errors()) ;
        }

        $item = Item::find($id) ;
        $oldImage = $item->image ;

        if($request->has('image')){
            $path = $request->image->store('public/images/items');
            Storage::delete($oldImage);
        }else{
            $path = $item->image ;
        }// image

        // $items = tap($request->user()->items()->where('id',$id))->update($request->all(),['image' => $path]);
        
        $items = Item::where(function($query) use($request){
            $query->where('id',$request->id);
            $query->where('restaurant_id',$request->user()->id);
        })->update($request->all(),['image' => $path]);
        return $this->responseJson(200, 'تم تحديث البيانات بنجاح',$items) ;

    }// items.edit




}
