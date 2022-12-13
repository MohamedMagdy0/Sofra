@extends('layouts.dashboard.app_master')
@section('page_title')
Districts
@endsection

@section('content')
    <section class=" ">
        <div class="card ">
            <div class="card-header text-center">
                <h3> الاحياء : {{ count($districts) }}</h3>
            </div><!-- card-header -->


     <div class="card-body p-0">

        @if (session('success'))
            <div class="alert alert-success text-center">
                <h3>{{ session('success') }}</h3>
            </div>
        @endif

                @if (count($districts)>0)

                    <table class="table table-responsive-sm m-0 text-center">
                     <thead>
                       <tr>
                         <th>ID</th>
                         <th>الحي</th>
                         <th>اسم المدينة</th>
                         <th>تعديل</th>
                         <th>حذف</th>
                       </tr>
                     </thead>
                     <tbody>

                        {{-- @php($index=1) --}}
                   @foreach ($districts as $district)

                       <tr>
                          <td>{{ $districts->FirstItem()+$loop->index}}</td>
                           <td>{{ $district->name }}</td>
                           <td>{{ $district->city->name }}</td>
                           <td><a href="{{ route('districts.edit', ['district'=>$district->id]) }}" class="btn btn-sm btn-success">تعديل</a></td>

                           <td>

      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default{{ $district->id }}"> حذف</button>

                        <!-- model -->
   <div class="modal fade" id="modal-default{{ $district->id }}">
    <!-- start form -->
    <form action="{{ route('district.softDelete', ['id'=>$district->id]) }}" method="post">
        @csrf
        @method('DELETE')

        <div class="modal-dialog">

          <div class="modal-content">

            <div class="modal-header bg-danger text-white">
              <h4 class="modal-title"><h4>رسالة تأكيد</h4></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div><!-- modal-header -->

            <div class="modal-body text-danger">
              <p>هل انت متأكد هل تريد حذف البيانات : <span class="text-primary">{{ $district->name }}</span> <br>
                سوف يتم حذف البيانات نهائيا &hellip;</p>
            </div><!-- modal-body -->

            <div class="modal-footer justify-content-between bg-danger">
              <button type="submit" class="btn btn-default" data-dismiss="modal">خروج</button>
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
                        <h1 class="text-capitalize">لا يوجد احياء حاليا</h1>
                        <a class="linked text-primary" href="{{ route('districts.create') }}"> اضف حي جديد </a>
                   </div><!-- alert elseif -->
                @endif

            </div><!-- card-body -->

            <div class="card-footer ">
                <div>{{ $districts->links() }}</div>
            </div><!-- card-footer -->

        </div><!-- card -->
    </section><!-- container -->
@endsection

