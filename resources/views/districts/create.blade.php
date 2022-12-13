@extends('layouts.dashboard.app_master')
@section('page_title')
    Create District
@endsection
@section('content')

    <section class="container">
        <div class="card ">

            <div class="card-header ">
                <h1 class="text-center"> اضف حي</h1>
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
            <form action="{{ route('districts.store') }}" method="post">
                @csrf
                  <div class="City mb-3">
                    <label>الحي</label>
                    <input type="text" name="name" class="form-control form-control-lg"  placeholder="District Name">
                  </div><!-- district Name -->

                  <div class="City mb-3">
                    <label> اسم المدينة</label>

                    <select name="city_id" class="form-control form-control-lg">
                        <option>اختر مدينة</option>
                        @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>

                  </div><!-- city Name -->


                <div class="mx-auto text-center">
                    <button type="submit" class="btn btn-lg btn-dark text-white">اضف حي</button>
                </div><!-- btn -->

              </form><!-- end form -->

            </div><!-- card-body -->

            <div class="card-footer ">
            </div><!-- card-footer  -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
