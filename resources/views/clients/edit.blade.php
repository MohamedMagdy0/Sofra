@extends('layouts.dashboard.app_master')
@section('page_title')
    Edit Clients
@endsection
@section('content')

    <section class="container">
        <div class="card">

            <div class="card-header ">
                <h1 class="text-center"> تعديل عميل </h1>
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
            <form action="{{ route('clients.update', ['client'=>$client->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                  <div class=" mb-3">
                    <label> الاسم</label>
                    <input type="text" name="name" class="form-control form-control-lg" value="{{ $client->name }}">
                  </div><!-- client Name -->

                  <div class=" mb-3">
                    <label>البريد الالكتروني</label>
                    <input type="text" name="email" class="form-control form-control-lg" value="{{ $client->email }}" >
                  </div><!-- client email -->

                  <div class=" mb-3">
                    <label>الهاتف</label>
                    <input type="text" name="phone" class="form-control form-control-lg" value="{{ $client->phone }}">
                  </div><!-- client phone -->

                  <div class=" mb-3">
                      <label>الصور</label>
                      <input type="file" name="image" class="form-control form-control-lg" value="{{ $client->image }}">
                      <div>
                          <img src="{{ asset(Storage::url($client->image)) }}" height="60" alt="">
                        </div>
                    </div><!-- client image -->


                    <div class=" mb-3">
                      <label>عنوان العميل </label>
                      <select name="district_id"  class="form-control form-control-lg">
                        <option value="{{ $client->district->id }}">{{ $client->district->name }}</option>
                        @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                      </select>
                    </div><!-- client district_id -->


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
