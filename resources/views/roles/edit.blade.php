@extends('layouts.dashboard.app_master')
@section('page_title')
    Edit Role
@endsection
{{-- @inject('roles', 'App\Models\Role') --}}
@section('content')

    <section class="container">
        <div class="card">

            <div class="card-header ">
                <h1 class="text-center">Edit Role</h1>
            </div><!-- card-header -->

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

             <!-- form start -->
            <form action="{{ route('roles.update', ['role'=>$role->id]) }}" method="post">
                @csrf
                @method('PUT')

                   <div class=" mb-3">
                    <label>Role Name</label>
                    <input type="text" name="name" class="form-control form-control-lg"  value="{{ $role->name }}">
                  </div><!-- Role name -->

                  <div class=" mb-3">
                    <label>Role Display Name</label>
                    <input type="text" name="guard_name" class="form-control form-control-lg"  value="{{ $role->guard_name }}">
                  </div><!-- Role guard_name -->

                  {{-- <div class=" mb-3">
                    <label>Role Description</label>
                    <input type="text" name="description" class="form-control form-control-lg"  value="{{ $role->description }}">
                  </div><!-- Role description --> --}}

                  <div class="form-check mb-3">
                    <label class="form-check-label my-2">Permissions</label><hr>
                    <div class="row">

                        @foreach ($permissions as $permission)

                        <div class="col-sm-3">
                            <label for="{{ $permission->id }}">
                                <input id="{{ $permission->id }}" type="checkbox" name="permissions_list[]" value="{{ $permission->id }}"
                                    @if ($role->hasPermissionTo($permission->name))
                                        @checked(true)
                                    @endif
                                >  {{ $permission->name }}
                            </label>
                        </div><!-- col-sm-3 -->

                        @endforeach

                    </div><!-- row -->
                  </div><!-- Role Permissions -->


                <div class="mx-auto text-center">
                    <button type="submit" class="btn btn-lg btn-dark text-white">Update Category</button>
                </div><!-- btn -->

              </form><!-- end form -->

            </div><!-- card-body -->

            <div class="card-footer ">
            </div><!-- card-footer  -->

        </div><!-- card -->
    </section><!-- container -->
@endsection

