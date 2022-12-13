@extends('layouts.dashboard.app_master')
@section('page_title')
    Edit Restaurants
@endsection
@section('content')

    <section class="container">
        <div class="card">

            <div class="card-header ">
                <h1 class="text-center"> تعديل المطعم </h1>
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
            <form action="{{ route('restaurants.update', ['restaurant'=>$restaurant->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                  <div class=" mb-3">
                    <label> الاسم</label>
                    <input type="text" name="name" class="form-control form-control-lg" value="{{ $restaurant->name }}">
                  </div><!-- restaurant Name -->

                  <div class=" mb-3">
                    <label>البريد الالكتروني</label>
                    <input type="text" name="email" class="form-control form-control-lg" value="{{ $restaurant->email }}" >
                  </div><!-- restaurant email -->

                  <div class=" mb-3">
                    <label>الهاتف</label>
                    <input type="text" name="phone" class="form-control form-control-lg" value="{{ $restaurant->phone }}">
                  </div><!-- restaurant phone -->

                  <div class=" mb-3">
                    <label> اقل مبلغ لعمل اوردر</label>
                    <input type="text" name="min_charge" class="form-control form-control-lg" value="{{ $restaurant->min_charge }}">
                  </div><!-- restaurant min_charge -->

                  <div class=" mb-3">
                      <label>الصور</label>
                      <input type="file" name="image" class="form-control form-control-lg" value="{{ $restaurant->image }}">
                      <div>
                          <img src="{{ asset(Storage::url($restaurant->image)) }}" height="60" alt="">
                        </div>
                    </div><!-- restaurant image -->

                    <div class=" mb-3">
                      <label>عمولة التوصيل</label>
                      <input type="text" name="delivery_fee" class="form-control form-control-lg" value="{{ $restaurant->delivery_fee }}">
                    </div><!-- restaurant delivery_fee -->


                    <div class=" mb-3">
                      <label>عنوان المطعم </label>
                      <select name="district_id"  class="form-control form-control-lg">
                        <option value="{{ $restaurant->district->id }}">{{ $restaurant->district->name }}</option>
                        @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                      </select>
                    </div><!-- restaurant district_id -->


                <div class="mx-auto text-center">
                    <button type="submit" class="btn btn-lg btn-dark text-white">تحديث المطعم</button>
                </div><!-- btn -->

              </form><!-- end form -->

            </div><!-- card-body -->

            <div class="card-footer ">
            </div><!-- card-footer  -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
