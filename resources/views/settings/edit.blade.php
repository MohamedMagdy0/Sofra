@extends('layouts.dashboard.app_master')
@section('page_title')
    Edit Settings
@endsection
@section('content')

    <section class="container">
        <div class="card">

            <div class="card-header ">
                <h1 class="text-center"> تعديل الاعدادات</h1>
            </div><!-- card-header -->

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


             <!-- form start -->
            <form action="{{ route('setting.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                  <div class=" mb-3">
                    <label>نسبة العمولة</label>
                    <input type="text" name="commission" class="form-control form-control-lg" value="{{ $setting->commission }}">
                  </div><!-- offer Name -->

                  <div class=" mb-3">
                    <label>محتوي عن التطبيق</label>
                    <textarea class="form-control form-control-lg" name="about_app_text"  rows="3">{{ $setting->about_app_text }}</textarea>

                  </div><!-- Offer content -->



                  <div class=" mb-3">
                    <label>اسم وسيلة الدفع</label>
                    <input type="text" name="bank_name" class="form-control form-control-lg" value="{{ $setting->bank_name }}">
                  </div><!-- Offer start_date -->

                  <div class=" mb-3">
                    <label>رقم الحساب  </label>
                    <input type="text" name="Bank_account_number" class="form-control form-control-lg" value="{{ $setting->Bank_account_number }}">
                  </div><!-- Offer end_date -->

                <div class="mx-auto text-center">
                    <button type="submit" class="btn btn-lg btn-dark text-white">تحديث الاعدادات</button>
                </div><!-- btn -->

              </form><!-- end form -->

            </div><!-- card-body -->

            <div class="card-footer ">
            </div><!-- card-footer  -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
