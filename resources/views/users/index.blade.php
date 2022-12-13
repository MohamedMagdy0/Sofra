@extends('layouts.dashboard.app_master')
@section('page_title')
Users
@endsection
@php
    // $roles = $roles->pluck('name','id')->toArray();
@endphp

@section('content')
    <section class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>All users : {{ count($users) }}</h3>
            </div><!-- card-header -->

     <div class="card-body">

        @if (session('success'))
            <div class="alert alert-success text-center">
                <h3>{{ session('success') }}</h3>
            </div>
        @endif

                @if (count($users)>0)

                    <table class="table table-responsive-lg text-center">
                     <thead>
                       <tr>
                         <th>ID</th>
                         <th>Name</th>
                         <th>Email</th>
                         <th>Roles</th>

                         <th>Edit</th>
                         <th>Delete</th>
                       </tr>
                     </thead>
                     <tbody>

                        {{-- @php($index=1) --}}
                   @foreach ($users as $user)

                       <tr>
                          <td>{{ $users->FirstItem()+$loop->index}}</td>
                           <td>{{ $user->name }}</td>
                           <td>{{ $user->email }}</td>

                           <td>

                            @foreach ($user->roles as $index=>$role)
                               {{ $role->name }}
                               {{ $index+1 < $user->roles->count() ? ',' : '' }}
                            @endforeach
                            </td>

                           <td><a href="{{ route('users.edit', ['user'=>$user->id]) }}" class="btn btn-sm btn-success">Edit</a></td>

                           <td>

      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default{{ $user->id }}"> Delete</button>

                        <!-- model -->
   <div class="modal fade" id="modal-default{{ $user->id }}">
    <!-- start form -->
    <form action="{{ route('users.destroy', ['user'=>$user->id]) }}" method="post">
        @csrf
        @method('DELETE')

        <div class="modal-dialog">

          <div class="modal-content">

            <div class="modal-header bg-dark text-white">
              <h4 class="modal-title"><h4>Delete Confirmation</h4></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div><!-- modal-header -->

            <div class="modal-body text-dark">
              <p>Are You Sure You Want TO Delete This User : <span class="text-danger">{{ $user->name }}</span> <br>
                It Will Be Deleted Permenantly &hellip;</p>
            </div><!-- modal-body -->

            <div class="modal-footer justify-content-between bg-dark">
              <button type="submit" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-default">Delete</button>
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
                        <h1 class="text-capitalize">Sorry No Users</h1>
                        <a class="linked text-primary" href="{{ route('users.create') }}">If You Want To Create Please Click Here</a>
                   </div><!-- alert elseif -->
                @endif

            </div><!-- card-body -->

            <div class="card-footer ">
                <div>{{ $users->links() }}</div>
            </div><!-- card-footer -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
