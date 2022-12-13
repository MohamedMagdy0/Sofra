@extends('layouts.dashboard.app_master')
@section('page_title')
    Create Offer
@endsection
@section('content')

    <section class="container">
        <div class="card ">

            <div class="card-header">
                <h1 class="text-center"> اضف عرض</h1>
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
            <form action="{{ route('offers.store') }}" method="post" enctype="multipart/form-data">
                @csrf


                  <div class=" mb-3">
                    <label> العنوان</label>
                    <input type="text" name="title" class="form-control form-control-lg"  placeholder="Offer Title">
                  </div><!-- Offer Title -->

                  <div class=" mb-3">
                    <label> المحتوي</label>
                    <textarea class="form-control form-control-lg" name="content"  placeholder="Offer Content" rows="3"></textarea>
                  </div><!-- Offer content -->

                  <div class=" mb-3">
                    <label> الصورة</label>
                    <input type="file" name="image" class="form-control form-control-lg"  placeholder="Offer image">
                  </div><!-- Offer Image -->

                  <div class=" mb-3">
                    <label>بداية العرض</label>
                    <input type="date" name="start_date" class="form-control form-control-lg"  placeholder="Offer Start Time">
                  </div><!-- Offer start_date -->

                  <div class=" mb-3">
                    <label>نهاية العرض</label>
                    <input type="date" name="end_date" class="form-control form-control-lg"  placeholder="Offer End Time">
                  </div><!-- Offer end_date -->

                  <div class=" mb-3">
                    <label>اسم المطعم</label>
                    <select class="form-control form-control-lg" name="restaurant_id">
                        <option>اسم المطعم</option>
                        @foreach ($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                        @endforeach
                    </select>
                  </div><!-- Offer restaurant_id -->


                <div class="mx-auto text-center">
                    <button type="submit" class="btn btn-lg btn-dark text-white">اضف عرض </button>
                </div><!-- btn -->

              </form><!-- end form -->

            </div><!-- card-body -->

            <div class="card-footer">
            </div><!-- card-footer  -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
