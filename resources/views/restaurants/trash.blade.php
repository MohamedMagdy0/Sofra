@extends('layouts.dashboard.app_master')
@section('page_title')
    Restaurants Trash
@endsection

@section('content')
    <section class=" ">
        <div class="card">
            <div class="card-header text-center">
                <h3> المطاعم المحذوفة : {{ count($restaurants) }}</h3>
            </div><!-- card-header -->


            <div class="card-body p-0">

                @if (session('success'))
                    <div class="alert alert-success text-center">
                        <h3>{{ session('success') }}</h3>
                    </div>
                @endif

                @if (count($restaurants) > 0)
                    <table class="table table-responsive-sm m-0 text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>المطاعم</th>
                                <th>البريد الالكتروني</th>
                                <th>الهاتف</th>
                                <th>الحد الادني للطلب</th>
                                <th>الصور</th>
                                <th>الحالة</th>
                                <th>تكلفة الدليفري</th>
                                <th> العنوان</th>
                                <th>ارجاع</th>
                                <th>حذف</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @php($index=1) --}}
                            @foreach ($restaurants as $restaurant)
                                <tr>
                                    <td>{{ $restaurants->FirstItem() + $loop->index }}</td>
                                    <td>{{ $restaurant->name }}</td>
                                    <td>{{ $restaurant->email }}</td>
                                    <td>{{ $restaurant->phone }}</td>
                                    <td>{{ $restaurant->min_charge }}</td>
                                    <td><img src="{{ asset(Storage::url($restaurant->image)) }}" height="55"
                                            alt=""></td>
                                    <td>{{ $restaurant->status }}</td>
                                    <td>{{ $restaurant->delivery_fee }}</td>
                                    <td>{{ $restaurant->district->id }}</td>
                                    <td><a href="{{ route('restaurant.restore', ['id' => $restaurant->id]) }}"
                                            class="btn btn-sm btn-success">ارجاع</a></td>

                                    <td>

                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#modal-default{{ $restaurant->id }}"> حذف</button>

                                        <!-- model -->
                                        <div class="modal fade" id="modal-default{{ $restaurant->id }}">
                                            <!-- start form -->
                                            <form
                                                action="{{ route('restaurants.destroy', ['restaurant' => $restaurant->id]) }}"
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
                                                                    class="text-primary">{{ $restaurant->name }}</span>
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
                <div>{{ $restaurants->links() }}</div>
            </div><!-- card-footer -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
