@extends('layouts.dashboard.app_master')
@section('page_title')
Offers Trash
@endsection

@section('content')
    <section class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>العروض المحذوفة : {{ count($offers) }}</h3>
            </div><!-- card-header -->


     <div class="card-body p-0">

        @if (session('success'))
            <div class="alert alert-success text-center">
                <h3>{{ session('success') }}</h3>
            </div>
        @endif

                @if (count($offers)>0)

                    <table class="table table-responsive-sm m-0 text-center">
                     <thead>
                       <tr>
                         <th>ID</th>
                         <th>العنوان</th>
                         <th>المحتوي</th>
                         <th>الصور</th>
                         <th>بداية العرض</th>
                         <th>نهاية العرض</th>
                         <th>اسم المطعم</th>
                         <th>ارجاع</th>
                         <th>حذف</th>
                       </tr>
                     </thead>
                     <tbody>

                        {{-- @php($index=1) --}}
                   @foreach ($offers as $offer)

                       <tr>
                          <td>{{ $offers->FirstItem()+$loop->index}}</td>
                           <td>{{ $offer->title }}</td>
                           <td>{{ $offer->content }}</td>
                           <td><img src="{{ asset(Storage::url($offer->image)) }}" height="75" alt=""></td>
                           <td>{{ $offer->start_date }}</td>
                           <td>{{ $offer->end_date }}</td>
                           <td>{{ $offer->restaurant->name }}</td>
                           <td><a href="{{ route('offer.restore', ['id'=>$offer->id]) }}" class="btn btn-sm btn-success">ارجاع</a></td>

                           <td>

      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default{{ $offer->id }}"> حذف</button>

                        <!-- model -->
   <div class="modal fade" id="modal-default{{ $offer->id }}">
    <!-- start form -->
    <form action="{{ route('offers.destroy', ['offer'=>$offer->id]) }}" method="post">
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
              <p>هل انت متأكد هل تريد حذف البيانات : <span class="text-primary">{{ $offer->title }}</span> <br>
                سوف يتم حذف البيانات نهائيا &hellip;</p>
            </div><!-- modal-body -->

            <div class="modal-footer justify-content-between bg-danger">
              <button type="submit" class="btn btn-default" data-dismiss="modal">Close</button>
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
                <div>{{ $offers->links() }}</div>
            </div><!-- card-footer -->

        </div><!-- card -->
    </section><!-- container -->
@endsection

