<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::first();
        return view('settings.edit',compact('setting'));
    }//edit

    public function update(Request $request)
    {
        $this->validate($request, [
            'commission' => 'required' ,
            'about_app_text' => 'required' ,
            'bank_name' => 'required' ,
            'Bank_account_number' => 'required' ,
        ]);
        $setting = Setting::first()->update($request->all());
        toastr()->warning('تم تحديث البيانات بنجاح');
        return back() ;
    }

}
