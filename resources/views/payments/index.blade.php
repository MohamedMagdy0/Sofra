@extends('layouts.dashboard.app_master')
@section('page_title')
    Payments
@endsection

@section('content')

    <!-- searsh -->
    <div class=" mb-l">
        <div class="mb-1 w-25">
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
    </div><!-- container -->
    <!-- end searsh -->


    <section class="">
        <div class="card">
            <div class="card-header text-center">
                <h3> المدفوعات : {{ count($payments) }}</h3>
            </div><!-- card-header -->


            <div class="card-body p-0">

                @if (session('success'))
                    <div class="alert alert-success text-center">
                        <h3>{{ session('success') }}</h3>
                    </div>
                @endif

                @if (count($payments) > 0)
                    <table class="table table-responsive-sm m-0 text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>المدفوع</th>
                                <th>ملاحظات</th>
                                <th>المطعم</th>
                                <th>الطلب</th>
                                <th>التاريخ</th>
                                <th>تعديل</th>
                                <th>حذف</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @php($index=1) --}}
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $payments->FirstItem() + $loop->index }}</td>
                                    <td>{{ $payment->paid }}</td>
                                    <td>{{ $payment->notes }}</td>
                                    <td>{{ $payment->restaurant->name }}</td>
                                    <td>{{ $payment->order_id }}</td>
                                    <td>{{ $payment->created_at }}</td>
                                    <td><a href="{{ route('payments.edit', ['payment' => $payment->id]) }}"
                                            class="btn btn-sm btn-success">تعديل</a></td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#modal-default{{ $payment->id }}"> حذف</button>

                                        <!-- model -->
                                        <div class="modal fade" id="modal-default{{ $payment->id }}">
                                            <!-- start form -->
                                            <form action="{{ route('payment.softDelete', ['id' => $payment->id]) }}"
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
                                                                    class="text-primary">{{ $payment->restaurant->name }}</span>
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
                        <h1 class="text-capitalize">لا يوجد اقسام حاليا</h1>
                        <a class="linked text-primary" href="{{ route('payments.create') }}"> اضف قسم جديد </a>
                    </div>
                @endif

            </div><!-- card-body -->

            <div class="card-footer ">
                <div>{{ $payments->links() }}</div>
            </div><!-- card-footer -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
