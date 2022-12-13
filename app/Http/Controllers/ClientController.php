<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\District;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::where(function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->keyword.'%');
            $query->orWhere('email', 'like', '%'.$request->keyword.'%');
            $query->orWhere('phone', 'like', '%'.$request->keyword.'%');
        })->latest('id','DESC')->paginate(10);
        return view('clients.index',compact('clients'));
    } //  index


    public function create()
    {
        return view('clients.create') ;
    } //create


    public function edit($client)
    {
        $client = Client::findOrFail($client);
        return view('clients.edit',compact('client'))->with('districts',District::get()) ;
    }  //edit


    public function update(Request $request,$client)
    {

        $this->validate($request, [
            'name' => 'required' ,
            'email' => 'required' ,
            'image' => 'nullable' ,
            'phone' => 'required' ,
            'district_id' => 'required' ,
        ]);


        $client = Client::FindOrFail($client);
        $oldImage = $client->image;

        if($request->has('image')){
            $path = $request->image->store('public/images/clients') ;
        //   Storage::delete($oldImage);
        }else {
            $path = $client->image ;
        }

        // $client = $client->update($request->all());

        $client->update([
            'image' => $path,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'district_id' => $request->district_id,
        ]);

        toastr()->warning('تم تحديث البيانات بنجاح');
        return redirect()->route('clients.index');
    } // update

    // start softDelete

    public function softDelete($id)
    {
        $client = Client::findOrFail($id)->delete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('clients.index');
    }  //  softDelete


    public function trash()
    {
        $clients = Client::onlyTrashed()->latest('id','DESC')->paginate(10);
        return view('clients.trash',compact('clients'));
    }  //  trash


    public function restore($id)
    {
        $client = Client::withTrashed()->findOrFail($id);
        $client->restore();
        toastr()->warning('تم ارجاع البيانات بنجاح');
        return redirect()->route('clients.index');
    }  // estore


    public function destroy($client)
    {
        $client = Client::withTrashed()->FindOrFail($client);
        $client->forceDelete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('clients.index');
    } //  destroy


    public function isActive(Request $request, $id)
        {

            $client = tap(Client::findOrFail($id))->update(['is_active' => $request->is_active]) ;
            return back() ;

            // if ($request->id) {
            //     $user->where('id', $client->id)->update(['is_active' => $request->is_active]) ;
            //     return back() ;
            // }
        }  // isActive


}
