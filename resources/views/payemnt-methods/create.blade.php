@extends('layouts.dashboard.app_master')
@section('page_title')
    Create payemnt-Method
@endsection
@section('content')

    <section class="container">
        <div class="card ">

            <div class="card-header">
                <h1 class="text-center"> اضف وسيلة دفع</h1>
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
            <form action="{{ route('payemnt-methods.store') }}" method="post">
                @csrf


                  <div class=" mb-3">
                    <label> الاسم</label>
                    <input type="text" name="name" class="form-control form-control-lg"  placeholder="اسم وسيلة الدفع">
                  </div><!-- payemntMethods Name -->



                <div class="mx-auto text-center">
                    <button type="submit" class="btn btn-lg btn-dark text-white">اضف وسيلة الدفع</button>
                </div><!-- btn -->

              </form><!-- end form -->

            </div><!-- card-body -->

            <div class="card-footer">
            </div><!-- card-footer  -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
