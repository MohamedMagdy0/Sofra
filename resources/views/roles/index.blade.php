@extends('layouts.dashboard.app_master')
@section('page_title')
    Roles
@endsection

@section('content')
    <section class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>All Roles : {{ count($roles) }}</h3>
            </div><!-- card-header -->

            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success text-center">
                        <h3>{{ session('success') }}</h3>
                    </div>
                @endif

                @if (count($roles) > 0)
                    <table class="table table-responsive-lg text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Guard Name</th>
                                {{-- <th>Description</th> --}}
                                <th>Permissions</th>

                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @php($index=1) --}}
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $roles->FirstItem() + $loop->index }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->guard_name }}</td>
                                    {{-- <td>
                                        @if ($role->description == null)
                                            empty
                                        @else
                                            {{ $role->description }}
                                        @endif
                                    </td><!-- description --> --}}

                                    <td>
                                        @foreach ($role->permissions as $index=>$permission)
                                            {{ $permission->name }} {{ $index+1 <$role->permissions->count() ? ',' : '' }}
                                        @endforeach
                                    </td><!-- permissions -->

                                    <td><a href="{{ route('roles.edit', ['role' => $role->id]) }}"
                                            class="btn btn-sm btn-success">Edit</a></td>

                                    <td>

                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#modal-default{{ $role->id }}"> Delete</button>

                                        <!-- model -->
                                        <div class="modal fade" id="modal-default{{ $role->id }}">
                                            <!-- start form -->
                                            <form action="{{ route('roles.destroy', ['role' => $role->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')

                                                <div class="modal-dialog">

                                                    <div class="modal-content">

                                                        <div class="modal-header bg-dark text-white">
                                                            <h4 class="modal-title">
                                                                <h4>Delete Confirmation</h4>
                                                            </h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div><!-- modal-header -->

                                                        <div class="modal-body text-dark">
                                                            <p>Are You Sure You Want TO Delete This Role : <span
                                                                    class="text-danger">{{ $role->name }}</span> <br>
                                                                It Will Be Deleted Permenantly &hellip;</p>
                                                        </div><!-- modal-body -->

                                                        <div class="modal-footer justify-content-between bg-dark">
                                                            <button type="submit" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
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
                        <h1 class="text-capitalize">Sorry No Roles</h1>
                        <a class="linked text-primary" href="{{ route('roles.create') }}">If You Want To Create Please
                            Click Here</a>
                    </div><!-- alert elseif -->
                @endif

            </div><!-- card-body -->

            <div class="card-footer ">
                <div>{{ $roles->links() }}</div>
            </div><!-- card-footer -->

        </div><!-- card -->
    </section><!-- container -->
@endsection

