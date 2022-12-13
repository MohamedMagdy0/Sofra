@extends('layouts.dashboard.app_master')
@section('page_title')
    Edit Payment
@endsection
@section('content')

    <section class="container">
        <div class="card">

            <div class="card-header ">
                <h1 class="text-center"> تعديل دفع </h1>
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
            <form action="{{ route('payments.update', ['payment'=>$payment->id]) }}" method="post">
                @csrf
                @method('PUT')

                  <div class=" mb-3">
                    <label> المدفوع</label>
                    <input type="text" name="paid" class="form-control form-control-lg"   value="{{ $payment->paid }}">
                  </div><!-- payment paid -->

                  <div class=" mb-3">
                    <label> ملاحظات</label>
                    <textarea type="text" name="notes" class="form-control form-control-lg" > {{ $payment->notes }}</textarea>
                  </div><!-- payment notes -->

                  <div class=" mb-3">
                    <label>اسم المطعم</label>
                    <select class="form-control form-control-lg" name="restaurant_id">
                        <option value="{{ $payment->restaurant->id }}">{{ $payment->restaurant->name }}</option>
                        @foreach ($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                        @endforeach
                    </select>
                  </div><!-- payment restaurant_id -->

                  <div class=" mb-3">
                    <label> الطلب</label>
                    <input type="text" name="order_id" class="form-control form-control-lg" value="{{ $payment->order_id }}">

                  </div><!-- payment order_id -->

                  <div class=" mb-3">
                    <label> التاريخ</label>
                    <input type="date" name="date_of_paid" class="form-control form-control-lg"  value="{{ $payment->date_of_paid }}">
                  </div><!-- payment date -->



                <div class="mx-auto text-center">
                    <button type="submit" class="btn btn-lg btn-dark text-white">تحديث الدفع</button>
                </div><!-- btn -->

              </form><!-- end form -->

            </div><!-- card-body -->

            <div class="card-footer ">
            </div><!-- card-footer  -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
