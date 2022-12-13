<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::paginate(10);
        return view('categories.index',compact('categories'));
    } //  index


    public function create()
    {
        return view('categories.create') ;
    } //create


    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|unique:categories,name' ,
        ]);

        $category = Category::create($request->all());
        toastr()->success('تم حفظ البيانات بنجاح');
        return redirect()->route('categories.index');
    }  //  store



    public function edit($category)
    {
        $category = Category::findOrFail($category);
        return view('categories.edit',compact('category')) ;
    }  //edit


    public function update(Request $request,$category)
    {
        $this->validate($request,[
            'name' => 'required|string' ,
        ]);

        $category = Category::FindOrFail($category)->update($request->all());
        toastr()->warning('تم تحديث البيانات بنجاح');
        return redirect()->route('categories.index');
    } // update




    // start softDelete

    public function softDelete($id)
    {
        $category = Category::findOrFail($id)->delete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('categories.index');
    }  //  softDelete


    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate(10);
        return view('categories.trash',compact('categories'));
    }  //  trash


    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        toastr()->warning('تم ارجاع البيانات بنجاح');
        return redirect()->route('categories.index');
    }  // estore


    public function destroy($category)
    {
        $category = Category::withTrashed()->FindOrFail($category);
        $category->forceDelete();
        toastr()->error('تم حذف البيانات بنجاح');
        return redirect()->route('categories.index');
    } //  destroy

}
