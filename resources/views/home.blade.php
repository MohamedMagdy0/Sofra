@extends('layouts.dashboard.app_master')
@section('page_title')
    Dashboard
@endsection
@inject('orders', 'App\Models\Order')
@inject('clients', 'App\Models\Client')
@inject('restaurants', 'App\Models\Restaurant')
@inject('contacts', 'App\Models\Contact')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-comments"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">الرسائل</span>
                            <span class="info-box-number">
                                {{ count($contacts->all()) }}
                                {{-- <small>%</small> --}}
                            </span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->


                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">الطلبات</span>
                            <span class="info-box-number">{{ count($orders->all()) }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->


                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-tag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">العملاء</span>
                            <span class="info-box-number">{{ count($clients->all()) }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->


                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">المطاعم</span>
                            <span class="info-box-number">{{ count($restaurants->all()) }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
            </div><!-- /.row -->




            <div class="row">

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ round((count($orders->where('state', 'pending')->get()) / count($orders->all())) * 100) }}%
                            </h3>

                            <p>طلبات جديدة</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div><!-- ./col pending -->


                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ round((count($orders->where('state', 'rejected')->get()) / count($orders->all())) * 100) }}%
                            </h3>

                            <p>طلبات مرفوضة</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div><!-- ./col accepted -->


                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ round((count($orders->where('state', 'delivered')->get()) / count($orders->all())) * 100) }}%
                            </h3>

                            <p>طلبات ناجحة</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div><!-- ./col delivered -->


                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ round((count($orders->where('state', 'accepted')->get()) / count($orders->all())) * 100) }}%<sup
                                    style="font-size: 20px">%</sup></h3>

                            <p>طلبات مقبولة </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->








            <div class="row">

         <div class="col-md-6 ">

                    <div class="card">

                        <div class="card-body">
                            <div style="width:75%;">
                                {!! $chartjs2->render() !!}
                            </div>

                        </div>
                    </div><!-- /.card -->

                </div><!-- /.col -->





                <div class="col-md-6     ">

                    <div class="card mx-auto">

                        <div class="card-body">
                            <div style="width:75%;">
                                {!! $chartjs->render() !!}
                            </div>

                        </div>
                    </div><!-- /.card -->

                </div><!-- /.col -->




            </div><!-- /.row -->
        </div><!--/. container-fluid -->
    </section><!-- /.content -->
@endsection
