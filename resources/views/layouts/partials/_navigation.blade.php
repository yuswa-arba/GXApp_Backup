<!-- START PAGE HEADER WRAPPER -->
<!-- START HEADER -->
<div class="header light bg-white ">
    <!-- START MOBILE SIDEBAR TOGGLE -->
    <a href="#" class="btn-link toggle-sidebar hidden-lg-up pg pg-menu" data-toggle="sidebar">
    </a>
    <!-- END MOBILE SIDEBAR TOGGLE -->
    <div class="">
        <div class="brand inline">
            <img src="{{asset('core/img/logo_blue.png')}}" alt="logo" data-src="{{asset('core/img/logo_blue.png')}}"
                 data-src-retina="{{asset('core/img/logo_blue_2x.png')}}" width="78" height="22"
                 class="m-t-5"
            >
        </div>
    </div>
    <div class="col-lg-4">
        <div class="input-group">
            <input type="text" id="search-box" class="form-control"
            placeholder="Type here to search">
            <span class="input-group-addon primary">
                        <i class="fa fa-search"></i>
                        </span>
        </div>
    </div>

    <div class="d-flex align-items-center">
        <!-- START NOTIFICATION LIST -->
        <ul class="hidden-md-down notification-list no-margin hidden-sm-down b-grey b-r no-style p-l-30 p-r-20">
            <li class="p-r-10 inline">
                <div class="dropdown">
                   <notification-btn></notification-btn>
                </div>
            </li>
            <li class="p-r-10 inline">
                <a href="{{route('misc.notification')}}" class="header-icon fa fa-comment cursor m-b-5" style="font-size: 18px"></a>
            </li>
            <li class="p-r-10 inline">
                <a href="#" class="header-icon pg pg-thumbs"></a>
            </li>
        </ul>
        <!-- END NOTIFICATIONS LIST -->
        <!-- START User Info-->
        <div class="pull-left p-r-10 fs-14 font-heading hidden-md-down m-l-20">
            <span class="semi-bold">{{Auth::user()->email}}</span>
        </div>
        <div class="dropdown pull-right hidden-md-down">
            <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
              <span class="thumbnail-wrapper d32 circular inline">
              <img src="/images/employee/{{!is_null(Auth::user()->employee) ? Auth::user()->employee->employeePhoto : ''}}" alt=""
                   data-src="/images/employee/{{!is_null(Auth::user()->employee) ? Auth::user()->employee->employeePhoto : ''}}"
                   data-src-retina="/images/employee/{{!is_null(Auth::user()->employee) ? Auth::user()->employee->employeePhoto : ''}}" width="32" height="32">
              </span>
            </button>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
                <a href="{{route('profile.index')}}" class="dropdown-item"><i class="fa fa-user"></i> Profile</a>
                <a href="#" class="dropdown-item"><i class="pg-settings_small"></i> Settings</a>
                <a href="#" class="dropdown-item"><i class="pg-signals"></i> Help</a>
                <a href="#" id="logout-btn" class="clearfix bg-master-lighter dropdown-item">
                    <span class="pull-left">Logout</span>
                    <span class="pull-right"><i class="pg-power"></i></span>
                </a>
            </div>
        </div>
        <!-- END User Info-->
        {{--<a href="#" class="header-icon pg pg-alt_menu btn-link m-l-10 sm-no-margin d-inline-block"--}}
           {{--data-toggle="quickview" data-toggle-element="#quickview"></a>--}}


        <form id="logout-form" action="{{route('logout')}}" method="post" style="display: none">
            {{csrf_field()}}
        </form>
    </div>
</div>
<!-- END HEADER -->
<!-- END PAGE HEADER WRAPPER -->

@push('child-page-controller')
<script>
    (function ($) {
        $('#logout-btn').on('click', function (e) {
            e.preventDefault();
            $('#logout-form').submit();
        });
    })(window.jQuery);
</script>
@endpush
