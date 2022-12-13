@extends('layouts.dashboard.app_master')
@section('page_title')
    Cients
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
                <h3> العملاء : {{ count($clients) }}</h3>
            </div><!-- card-header -->


            <div class="card-body p-0">

                @if (session('success'))
                    <div class="alert alert-success text-center">
                        <h3>{{ session('success') }}</h3>
                    </div>
                @endif

                @if (count($clients) > 0)
                    <table class="table table-responsive-sm m-0 text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>الاسم</th>
                                <th>البريد الالكتروني</th>
                                <th>الهاتف</th>
                                <th>الصور</th>
                                <th> المنطقة</th>
                                <th>الحالة</th>
                                <th>تغيير الحالة</th>
                                {{-- <th>تعديل</th> --}}
                                <th>حذف</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @php($index=1) --}}
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{ $clients->FirstItem() + $loop->index }}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td><img src="{{ asset(Storage::url($client->image)) }}" height="55"
                                            alt=""></td>
                                    <td>{{ $client->district->name }}</td>

                                    <td class="my-auto">
                                        @if ($client->is_active == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Deactivate</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('client.is-Active', ['id' => $client->id]) }}"
                                            method="post">
                                            @csrf

                                            @if ($client->is_active == 1)
                                                <input type="hidden" name="is_active" value="0" class="btn btn-sm btn-warning">
                                                <button type="submit" class="btn btn-sm btn-danger">deActivate</button>
                                            @elseif ($client->is_active == 0)
                                                <input type="hidden" name="is_active" value="1" class="btn btn-sm btn-success mb-1">
                                                <button type="submit" class="btn btn-sm btn-success">activate</button>
                                            @endif

                                        </form>
                                    </td>
                                    {{-- <td><a href="{{ route('clients.ediorderst', ['client'=>$client->id]) }}" class="btn btn-sm btn-success">تعديل</a></td> --}}

                                    <td>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#modal-default{{ $client->id }}"> حذف</button>

                                        <!-- model -->
                                        <div class="modal fade" id="modal-default{{ $client->id }}">
                                            <!-- start form -->
                                            <form action="{{ route('client.softDelete', ['id' => $client->id]) }}"
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
                                                                    class="text-primary">{{ $client->name }}</span>
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
                        <h1 class="text-capitalize">لا يوجد عملاء حاليا</h1>
                        {{-- <a class="linked text-primary" href="{{ route('client.create') }}"> اضف عميل جديد </a> --}}
                    </div>
                @endif

            </div><!-- card-body -->

            <div class="card-footer ">
                <div>{{ $clients->links() }}</div>
            </div><!-- card-footer -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
