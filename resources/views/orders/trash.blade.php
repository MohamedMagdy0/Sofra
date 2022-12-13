@extends('layouts.dashboard.app_master')
@section('page_title')
    Orders Trash
@endsection

@section('content')
    <section class=" ">
        <div class="card">
            <div class="card-header text-center">
                <h3> الطلبات المحذوفة : {{ count($orders) }}</h3>
            </div><!-- card-header -->


            <div class="card-body p-0">

                @if (session('success'))
                    <div class="alert alert-success text-center">
                        <h3>{{ session('success') }}</h3>
                    </div>
                @endif

                @if (count($orders) > 0)
                    <table class="table table-responsive-sm m-0 text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>client_id</th>
                                <th>restaurant_id</th>
                                <th>payment_method_id</th>
                                <th>address</th>
                                <th>price</th>
                                <th>total</th>
                                <th>net</th>
                                <th>delivery_fee</th>
                                <th>total_price</th>
                                <th>state</th>
                                <th>app_commission</th>
                                {{-- <th>تعديل</th> --}}
                                <th>delete</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @php($index=1) --}}
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $orders->FirstItem() + $loop->index }}</td>
                                    <td>{{ $order->client->name }}</td>
                                    <td>{{ $order->restaurant->name }}</td>
                                    <td>{{ $order->payment_method_id }}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>{{ $order->price }}</td>
                                    <td>{{ $order->total }}</td>
                                    <td>{{ $order->net }}</td>
                                    <td>{{ $order->delivery_fee }}</td>
                                    <td>{{ $order->total_price }}</td>
                                    <td>{{ $order->state }}</td>
                                    <td>{{ $order->app_commission }}</td>
                                    <td><a href="{{ route('order.restore', ['id' => $order->id]) }}"
                                            class="btn btn-sm btn-success">ارجاع</a></td>

                                    <td>

                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#modal-default{{ $order->id }}"> حذف</button>

                                        <!-- model -->
                                        <div class="modal fade" id="modal-default{{ $order->id }}">
                                            <!-- start form -->
                                            <form action="{{ route('orders.destroy', ['order' => $order->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')

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
                @else
                    <div class="alert alert-dark text-center ">
                        <h1 class="text-capitalize">لايوجد محذوفات</h1>
                    </div><!-- alert elseif -->
                @endif

            </div><!-- card-body -->

            <div class="card-footer ">
                <div>{{ $orders->links() }}</div>
            </div><!-- card-footer -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
