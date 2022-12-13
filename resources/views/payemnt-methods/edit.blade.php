@extends('layouts.dashboard.app_master')
@section('page_title')
    Edit payemnt-Method
@endsection
@section('content')

    <section class="container">
        <div class="card">

            <div class="card-header ">
                <h1 class="text-center"> تعديل وسيلة دفع </h1>
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
            <form action="{{ route('payemnt-methods.update', ['payemnt_method'=>$payemntMethod->id]) }}" method="post">
                @csrf
                @method('PUT')

                  <div class=" mb-3">
                    <label>الاسم</label>
                    <input type="text" name="name" class="form-control form-control-lg" value="{{ $payemntMethod->name }}">
                  </div><!-- Category Name -->


                <div class="mx-auto text-center">
                    <button type="submit" class="btn btn-lg btn-dark text-white">تحديث البيانات</button>
                </div><!-- btn -->

              </form><!-- end form -->

            </div><!-- card-body -->

            <div class="card-footer ">
            </div><!-- card-footer  -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
