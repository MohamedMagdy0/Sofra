@extends('layouts.dashboard.app_master')
@section('page_title')
    Orders
@endsection
{{-- @inject('orders', 'App\Models\Order') --}}
@section('content')

<div class="row d-flex justify-content-arround">

<div class="col-md-6">
<!-- searsh -->
    {{-- <div class=" mb-l"> --}}
        <div class="mb-1 ">
            <form action="" method="get">

                <div class="input-group">
                    <input type="search" name="keyword" value="{{ request('keyword') }}" class="form-control"
                        placeholder="Search here !">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-md btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div><!-- button -->
                </div><!-- input-group -->
            </form>
        </div>
    {{-- </div><!-- container --> --}}
    <!-- end searsh -->
</div>
<div class="col-md-6">
    <a href="{{ route('order.export-excel') }}" class="btn btn-success">تصدير اكسيل</a>
</div>

</div><!-- row -->
    <section class="">
        <div class="card">
            <div class="card-header text-center">
                {{-- <h3> الطلبات : </h3> <!-- {{ count($orders) }} --> --}}
            </div><!-- card-header -->


            <div class="card-body p-0">

                @if (session('success'))
                    <div class="alert alert-success text-center">
                        <h3>{{ session('success') }}</h3>
                    </div>
                @endif
                    {{-- {{dd($orders)}} --}}
                {{-- @if (count($orders) > 0) --}}
                    <table class="table table-responsive-sm m-0 text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>client</th>
                                <th>restaurant</th>
                                <th>payment method</th>
                                <th>address</th>
                                <th>price</th>
                                <th>total</th>
                                <th>net</th>
                                <th>delivery fee</th>
                                <th>total price</th>
                                <th>state</th>
                                {{-- <th>app_commission</th> --}}
                                {{-- <th>تعديل</th> --}}
                                <th>details</th>
                                <th>delete</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @php($index=1) --}}
                            @foreach ($orders as $order)
                                <tr>
                                    {{-- <td>{{ $orders->FirstItem() + $loop->index }}</td> --}}
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->client->name }}</td>
                                    <td>{{ $order->restaurant->name }}</td>
                                    <td>{{ $order->paymentMethod->name }}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>{{ $order->price }}</td>
                                    <td>{{ $order->total }}</td>
                                    <td>{{ $order->net }}</td>
                                    <td>{{ $order->delivery_fee }}</td>
                                    <td>{{ $order->total_price }}</td>
                                    <td>{{ $order->state }}</td>
                                    {{-- <td>{{ $order->app_commission }}</td> --}}
                                    {{-- <td><a href="{{ route('orders.edit', ['order'=>$order->id]) }}" class="btn btn-sm btn-success">تعديل</a></td> --}}
                                    <td><a href="{{ route('orders.show', ['order'=>$order->id]) }}" class="btn btn-sm btn-success">طباعة</a></td>

                                    <td>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#modal-default{{ $order->id }}"> حذف</button>

                                        <!-- model -->
                                        <div class="modal fade" id="modal-default{{ $order->id }}">
                                            <!-- start form -->
                                            <form action="{{ route('order.softDelete', ['id' => $order->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')

                                                <div class="modal-dialog">

                                                    <div class="modal-content">

                                                        <div class="modal-header bg-danger text-white">
                                                            <h4 class="modal-title">
                                                                <h4>رسالة تأكيد</h4>
                                                            </h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div><!-- modal-header -->

                                                        <div class="modal-body text-danger">
                                                            <p>هل انت متأكد هل تريد حذف البيانات : <span
                                                                    class="text-primary">{{ $order->client->name }}</span>
                                                                <br>
                                                                سوف يتم حذف البيانات نهائيا &hellip;</p>
                                                        </div><!-- modal-body -->

                                                        <div class="modal-footer justify-content-between bg-danger">
                                                            <button type="submit" class="btn btn-default"
                                                                data-dismiss="modal">خروج</button>
                                                            <button type="submit" class="btn btn-default">حذف</button>
                                                        </div><!-- modal-footer -->
                                                    </div><!-- /.modal-content -->

                                                </div> <!-- /.modal-dialog -->

                                            </form> <!-- end form -->
                                        </div><!-- /.modal -->


                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                {{-- @else --}}
                    {{-- <div class="alert alert-dark text-center "> --}}
                        {{-- <h1 class="text-capitalize">لا يوجد عملاء حاليا</h1> --}}
                        {{-- <a class="linked text-primary" href="{{ route('orders.create') }}"> اضف طلب جديد </a> --}}
                    {{-- </div> --}}
                {{-- @endif --}}

            </div><!-- card-body -->

            <div class="card-footer ">
                {{-- <div>{{ $orders->links() }}</div> --}}
            </div><!-- card-footer -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
