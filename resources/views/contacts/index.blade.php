@extends('layouts.dashboard.app_master')
@section('page_title')
    Contacts
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
                <h3> الاقسام : {{ count($contacts) }}</h3>
            </div><!-- card-header -->


            <div class="card-body p-0">

                @if (session('success'))
                    <div class="alert alert-success text-center">
                        <h3>{{ session('success') }}</h3>
                    </div>
                @endif

                @if (count($contacts) > 0)
                    <table class="table table-responsive-sm m-0 text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>الاسم</th>
                                <th>البريد الالكتروني</th>
                                <th>الهاتف</th>
                                <th>نوع الشكوي</th>
                                <th>الشكوي</th>
                                {{-- <th>تعديل</th> --}}
                                <th>حذف</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @php($index=1) --}}
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $contacts->FirstItem() + $loop->index }}</td>
                                    <td>{{ $contact->full_name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>{{ $contact->type }}</td>
                                    <td>{{ $contact->message }}</td>
                                    {{-- <td><a href="{{ route('contacts.edit', ['contact'=>$contact->id]) }}" class="btn btn-sm btn-success">تعديل</a></td> --}}

                                    <td>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#modal-default{{ $contact->id }}"> حذف</button>

                                        <!-- model -->
                                        <div class="modal fade" id="modal-default{{ $contact->id }}">
                                            <!-- start form -->
                                            <form action="{{ route('contact.softDelete', ['id' => $contact->id]) }}"
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
                                                                    class="text-primary">{{ $contact->full_name }}</span>
                                                                <br>
                                                                سوف يتم حذف البيانات نهائيا &hellip;
                                                            </p>
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
                        <h1 class="text-capitalize">لا يوجد رسائل حاليا</h1>
                        {{-- <a class="linked text-primary" href="{{ route('contacts.create') }}"> اضف قسم جديد </a> --}}
                    </div>
                @endif

            </div><!-- card-body -->

            <div class="card-footer ">
                <div>{{ $contacts->links() }}</div>
            </div><!-- card-footer -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
