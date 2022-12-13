@extends('layouts.dashboard.app_master')
@section('page_title')
    Create Role
@endsection
@section('content')

    <section class="container">
        <div class="card ">

            <div class="card-header">
                <h1 class="text-center">Create Role</h1>
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
            <form action="{{ route('roles.store') }}" method="post">
                @csrf

                  <div class=" mb-3">
                    <label>Role Name</label>
                    <input type="text" name="name" class="form-control form-control-lg"  placeholder="Role Name">
                  </div><!-- Role name -->

                  <div class=" mb-3">
                    <label>Role Guard Name</label>
                    <input type="text" name="guard_name" class="form-control form-control-lg"  placeholder="Guard Name">
                  </div><!-- Role guard_name -->

                  {{-- <div class=" mb-3">
                    <label>Role Description</label>
                    <input type="text" name="description" class="form-control form-control-lg"  placeholder="Display Description">
                  </div><!-- Role description --> --}}

                  <div class="form-check mb-3">
                        <label class="form-check-label my-2">Permissions</label>
                        <hr>

                        <div class="mb-2">
                        <input id="select-all" type="checkbox">
                        <label for='select-all'>Select All</label><br>
                        </div>

                        <div class="row">

                            @foreach ($permissions as $permission)
                                <div class="col-sm-3">
                                    <label for="{{ $permission->id }}">
                                        <input id="{{ $permission->id }}" type="checkbox" name="permissions_list[]"
                                            value="{{ $permission->id }}"> {{ $permission->name }}
                                    </label>
                                </div><!-- col-sm-3 -->
                            @endforeach

                        </div><!-- row -->
                    </div><!-- Role Permissions -->


                    <div class="mx-auto text-center">
                        <button type="submit" class="btn btn-lg btn-dark text-white">Add Role</button>
                    </div><!-- btn -->




                    <!-- jquerry select all checkbox -->
                    @push('scripts')
                        <script>
                            $("#select-all").click(function() {
                                $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
                            });

                            // $("input[type=checkbox]").click(function() {
                            // if (!$(this).prop("checked")) {
                            // $("#select-all").prop("checked", false);
                            // }
                            // });
                        </script>
                    @endpush



              </form><!-- end form -->

            </div><!-- card-body -->

            <div class="card-footer">
            </div><!-- card-footer  -->

        </div><!-- card -->
    </section><!-- container -->
@endsection

