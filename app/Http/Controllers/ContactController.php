<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::where(function ($query) use ($request) {
            $query->where('full_name', 'like', '%'.$request->keyword.'%');
            $query->orWhere('email', 'like', '%'.$request->keyword.'%');
            $query->orWhere('phone', 'like', '%'.$request->keyword.'%');
            $query->orWhere('message', 'like', '%'.$request->keyword.'%');
            $query->orWhere('type', 'like', '%'.$request->keyword.'%');
        })->latest('id','DESC')->paginate(10);
        return view('contacts.index',compact('contacts')) ;
    } // index

     // start softDelete

    public function softDelete($id)
    {
        $contacts = Contact::findOrFail($id)->delete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('contacts.index');
    }  //  softDelete


    public function trash()
    {
        $contacts = Contact::onlyTrashed()->paginate(10);
        return view('contacts.trash',compact('contacts'));
    }  //  trash


    public function restore($id)
    {
        $contact = Contact::withTrashed()->findOrFail($id);
        $contact->restore();
        toastr()->warning('تم ارجاع البيانات بنجاح');
        return redirect()->route('contacts.index');
    }  // cityRestore


    public function destroy($contact)
    {
        $contact = Contact::withTrashed()->FindOrFail($contact);
        $city->forceDelete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('contacts.index');
    } //  destroy

}
