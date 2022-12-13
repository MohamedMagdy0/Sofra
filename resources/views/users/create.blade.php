@extends('layouts.dashboard.app_master')
@section('page_title')
    Create User
@endsection
@section('content')
{{-- @inject('roles','App\Models\Role') --}}

    <section class="container">
        <div class="card ">

            <div class="card-header ">
                <h1 class="text-center">Create User</h1>
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
            <form action="{{ route('users.store') }}" method="post">
                @csrf

                  <div class=" mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control form-control-lg"  placeholder="User Name">
                  </div><!--  Name -->

                  <div class=" mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control form-control-lg"  placeholder="User Email">
                  </div><!--  email -->

                  <div class=" mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control form-control-lg"  placeholder="User Password">
                  </div><!--  password -->

                  <div class=" mb-3">
                    <label>Password Confirmation</label>
                    <input type="password" name="password_confirmation" class="form-control form-control-lg"  placeholder="Password Confirmation">
                  </div><!--  password_confirmation -->

                  <div class=" mb-3">
                    <label>Roles</label>
                    <select class="form-control form-control-lg" name="roles_list[]" >
                        <option value="">select role</option>

                        @foreach ($roles->all() as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach

                    </select>

                  </div><!--  Roles -->


                <div class="mx-auto text-center">
                    <button type="submit" class="btn btn-lg btn-dark text-white">Add User</button>
                </div><!-- btn -->

              </form><!-- end form -->

            </div><!-- card-body -->

            <div class="card-footer">
            </div><!-- card-footer  -->

        </div><!-- card -->
    </section><!-- container -->
@endsection
