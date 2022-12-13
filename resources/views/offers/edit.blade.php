@extends('layouts.dashboard.app_master')
@section('page_title')
    Edit City
@endsection
@section('content')

    <section class="container">
        <div class="card">

            <div class="card-header ">
                <h1 class="text-center"> تعديل عرض</h1>
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
            <form action="{{ route('offers.update', ['offer'=>$offer->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                  <div class=" mb-3">
                    <label>العنوان</label>
                    <input type="text" name="title" class="form-control form-control-lg" value="{{ $offer->title }}">
                  </div><!-- offer Name -->

                  <div class=" mb-3">
                    <label>المحتوي</label>
                    <textarea class="form-control form-control-lg" name="content"  rows="3">{{ $offer->content }}</textarea>
                  </div><!-- Offer content -->

                  <div class=" mb-3">
                    <label>الصورة</label>
                    <input type="file" name="image" class="form-control form-control-lg" value="{{ $offer->image }}">
                    <div>
                        <img src="{{ asset(Storage::url($offer->image)) }}"  height="75" alt="">
                    </div>
                </div><!-- Offer Image -->

                  <div class=" mb-3">
                    <label>بداية العرض</label>
                    <input type="date" name="start_date" class="form-control form-control-lg" value="{{ $offer->start_date }}">
                  </div><!-- Offer start_date -->

                  <div class=" mb-3">
                    <label>نهاية العرض</label>
                    <input type="date" name="end_date" class="form-control form-control-lg" value="{{ $offer->end_date }}">
                  </div><!-- Offer end_date -->

                  <div class=" mb-3">
                    <label>اسم المطعم</label>
                    <select class="form-control form-control-lg" name="restaurant_id">
                        <option value="{{ $offer->restaurant_id }}"> {{ $offer->restaurant->name }} </option>
                        @foreach ($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                        @endforeach
                    </select>
                  </div><!-- Offer restaurant_id -->


                <div class="mx-auto text-center">
                    <button type="submit" class="btn btn-lg btn-dark text-white">تحديث العرض</button>
                </div><!-- btn -->

              </form><!-- end form -->

            </div><!-- card-body -->

            <div class="card-footer ">
            </div><!-- card-footer  -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
