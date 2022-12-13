   <!-- Main Sidebar Container -->
   <aside class="main-sidebar sidebar-dark-primary ">
       <!-- Brand Logo -->
       <div class=" text-center">
        <a href="{{ route('home') }}" class="brand-link">
           {{-- <img src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
               class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
           <span class="brand-text font-weight-normal">{{ config('app.name') }}</span>
       </a>
       </div>


       <!-- Sidebar -->
       <div class="sidebar">
           <!-- Sidebar user panel (optional) -->
           <div class="user-panel mt-3 pb-3 mb-2 d-flex">
               <div class="image">
                   <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                       alt="User Image">
               </div>
               <div class="info">
                   <a href="" class="d-block">Alexander Pierce</a>
               </div>
           </div>

           <!-- SidebarSearch Form -->
           {{-- <div class="form-inline">
               <div class="input-group" data-widget="sidebar-search">
                   <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                       aria-label="Search">
                   <div class="input-group-append">
                       <button class="btn btn-sidebar">
                           <i class="fas fa-search fa-fw"></i>
                       </button>
                   </div>
               </div>
           </div> --}}

           <!-- Sidebar Menu -->
           <nav class="mt-1">
               <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                   data-accordion="false">
                   <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                   <!-- start cities -->
                   <li class="nav-item">
                       <!--  menu-open -->
                       <a href="" class="nav-link ">
                           <i class="nav-icon fas fa-flag-checkered"></i>
                           <p>
                               المدن
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{ route('cities.index') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> المدن</p>
                               </a>
                           </li><!-- المدن -->
                           <li class="nav-item">
                               <a href="{{ route('cities.create') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p>اضافة مدينة</p>
                               </a>
                           </li><!--  اضافة مدينة -->
                           <li class="nav-item">
                               <a href="{{ route('city.trash') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> المحذوفات</p>
                               </a>
                           </li><!-- المحذوفات -->
                       </ul>
                   </li><!-- end cities -->


                   <!-- start districts -->
                   <li class="nav-item">
                       <!--  menu-open -->
                       <a href="" class="nav-link ">
                           <i class="nav-icon far fa-building"></i>
                           <p>
                               الاحياء
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{ route('districts.index') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> الاحياء</p>
                               </a>
                           </li><!-- districts -->
                           <li class="nav-item">
                               <a href="{{ route('districts.create') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p>اضافة حي</p>
                               </a>
                           </li><!--  اضافة مدينة -->
                           <li class="nav-item">
                               <a href="{{ route('district.trash') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> المحذوفات</p>
                               </a>
                           </li><!-- المحذوفات -->
                       </ul>
                   </li><!-- end districts -->


                   <!-- start categories -->
                   <li class="nav-item">
                       <!--  menu-open -->
                       <a href="" class="nav-link ">
                           <i class="nav-icon fas fa-palette"></i>
                           <p>
                               الاقسام
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{ route('categories.index') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> الاقسام</p>
                               </a>
                           </li><!-- categories -->
                           <li class="nav-item">
                               <a href="{{ route('categories.create') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p>اضافة قسم</p>
                               </a>
                           </li><!--  اضافة مدينة -->
                           <li class="nav-item">
                               <a href="{{ route('category.trash') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> المحذوفات</p>
                               </a>
                           </li><!-- المحذوفات -->
                       </ul>
                   </li><!-- end categories -->



                   <!-- start offers -->
                   <li class="nav-item">
                       <!--  menu-open -->
                       <a href="" class="nav-link ">
                           <i class="nav-icon fas fa-gift"></i>
                           <p>
                               العروض
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{ route('offers.index') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> العروض</p>
                               </a>
                           </li><!-- offers -->
                           <li class="nav-item">
                               <a href="{{ route('offers.create') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p>اضافة عرض</p>
                               </a>
                           </li><!--  اضافة مدينة -->
                           <li class="nav-item">
                               <a href="{{ route('offer.trash') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> المحذوفات</p>
                               </a>
                           </li><!-- المحذوفات -->
                       </ul>
                   </li><!-- end offers -->


                   <!-- start contacts -->
                   <li class="nav-item">
                       <!--  menu-open -->
                       <a href="" class="nav-link ">
                           <i class="nav-icon fas fa-comments"></i>
                           <p>
                               الرسائل
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{ route('contacts.index') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> الرسائل</p>
                               </a>
                           </li><!-- offers -->

                           <li class="nav-item">
                               <a href="{{ route('contact.trash') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> المحذوفات</p>
                               </a>
                           </li><!-- المحذوفات -->
                       </ul>
                   </li><!-- end offers -->


                   <!-- start payments -->
                   <li class="nav-item">
                       <!--  menu-open -->
                       <a href="" class="nav-link ">
                           <i class="nav-icon fas fa-dollar-sign"></i>
                           <p>
                               الدفع
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{ route('payments.index') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> الدفع</p>
                               </a>
                           </li><!-- payments -->

                           <li class="nav-item">
                               <a href="{{ route('payment.trash') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> المحذوفات</p>
                               </a>
                           </li><!-- المحذوفات -->
                       </ul>
                   </li><!-- end offers -->


                   <!-- start restaurants -->
                   <li class="nav-item">
                       <!--  menu-open -->
                       <a href="" class="nav-link ">
                           <i class="nav-icon fas fa-utensils"></i>
                           <p>
                               المطاعم
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{ route('restaurants.index') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> المطاعم</p>
                               </a>
                           </li><!-- restaurants -->

                           <li class="nav-item">
                               <a href="{{ route('restaurant.trash') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> المحذوفات</p>
                               </a>
                           </li><!-- المحذوفات -->
                       </ul>
                   </li><!-- end restaurants -->


                   <!-- start payemntMethods -->
                   <li class="nav-item">
                       <!--  menu-open -->
                       <a href="" class="nav-link ">
                           <i class="nav-icon fab fa-cc-visa"></i>
                           <p>
                               طرق الدفع
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{ route('payemnt-methods.index') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> وسائل الدفع</p>
                               </a>
                           </li><!-- payemntMethods index -->

                           <li class="nav-item">
                               <a href="{{ route('payemnt-methods.create') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> اضف وسيلة الدفع</p>
                               </a>
                           </li><!-- payemntMethods create -->

                           <li class="nav-item">
                               <a href="{{ route('payemnt-method.trash') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> المحذوفات</p>
                               </a>
                           </li><!-- المحذوفات -->
                       </ul>
                   </li><!-- end payemntMethods -->


                   <!-- start clients -->
                   <li class="nav-item">
                       <!--  menu-open -->
                       <a href="" class="nav-link ">
                           <i class="nav-icon fas fa-user-tag"></i>
                           <p>
                               العملاء
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{ route('clients.index') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> العملاء</p>
                               </a>
                           </li><!-- clients index -->

                           <li class="nav-item">
                               <a href="{{ route('client.trash') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> المحذوفات</p>
                               </a>
                           </li><!-- المحذوفات -->
                       </ul>
                   </li><!-- end clients -->


                   <!-- start orders -->
                   <li class="nav-item">
                       <!--  menu-open -->
                       <a href="" class="nav-link ">
                           <i class="nav-icon fas fa-shopping-cart"></i>
                           <p>
                               الطلبات
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{ route('orders.index') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> الطلبات</p>
                               </a>
                           </li><!-- orders index -->

                           <li class="nav-item">
                               <a href="{{ route('order.trash') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> المحذوفات</p>
                               </a>
                           </li><!-- المحذوفات -->
                       </ul>
                   </li><!-- end orders -->


                   <!-- start Users -->
                   <li class="nav-item">
                       <!--  menu-open -->
                       <a href="" class="nav-link ">
                           <i class="nav-icon fa fa-biking"></i>
                           <p>
                               الادمن
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{ route('users.index') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> الادمن</p>
                               </a>
                           </li><!-- users index -->
                           <li class="nav-item">
                               <a href="{{ route('users.create') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> اضف ادمن</p>
                               </a>
                           </li><!-- users create -->

                           <li class="nav-item">
                               <a href="{{ route('user.trash') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> المحذوفات</p>
                               </a>
                           </li><!-- المحذوفات -->
                       </ul>
                   </li><!-- end users -->


                   <!-- start roles -->
                   <li class="nav-item">
                       <!--  menu-open -->
                       <a href="" class="nav-link ">
                           <i class="nav-icon fa fa-biking"></i>
                           <p>
                               الرتب
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{ route('roles.index') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> الرتب</p>
                               </a>
                           </li><!-- users index -->
                           <li class="nav-item">
                               <a href="{{ route('roles.create') }}" class="nav-link">
                                   <!-- active -->
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> اضف رتبة</p>
                               </a>
                           </li><!-- users create -->
{{--
                           <li class="nav-item">
                               <a href="{{ route('user.trash') }}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p> المحذوفات</p>
                               </a>
                           </li><!-- المحذوفات --> --}}
                       </ul>
                   </li><!-- end users -->


                   <li class="nav-item">
                       <a href="{{ route('setting.edit') }}" class="nav-link">
                           <i class="nav-icon fas fa-wrench"></i>
                           <p>
                               الاعدادات
                               {{-- <span class="right badge badge-danger">New</span> --}}
                           </p>
                       </a>
                   </li><!-- setting -->

                   <li class="nav-item">
                       <a href="{{ route('change-password') }}" class="nav-link">
                           <i class="nav-icon fas fa-wrench"></i>
                           <p>
                               تغيير كلمة المرور
                               {{-- <span class="right badge badge-danger">New</span> --}}
                           </p>
                       </a>
                   </li><!-- setting -->



                   <li class="nav-item">
                       <a href="#" class="nav-link">
                           <i class="nav-icon fas fa-th text-warning"></i>
                           <p>
                               Simple Link
                               <span class="right badge badge-danger">New</span>
                           </p>
                       </a>
                   </li>

               </ul>
           </nav>
           <!-- /.sidebar-menu -->
       </div>
       <!-- /.sidebar -->
   </aside>
