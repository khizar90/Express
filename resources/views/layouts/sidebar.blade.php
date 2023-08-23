<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class=""><img src="/assets/img/logo.png" alt="" width="50" height="50"></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item {{(Request::url() == route('dashboard-home'))? 'active':''}}">
            <a href="{{ route('dashboard-home') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Home">Home</div>
            </a>
            
        </li>

        <li class="menu-item {{(Request::url() == route('dashboard-view-bus'))? 'active':''}}">
            <a href="{{ route('dashboard-view-bus') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-bus"></i>
                <div data-i18n="Buses">Buses</div>
            </a>
        </li>

        <li class="menu-item {{(Request::url() == route('dashboard-cities'))? 'open':''}} || {{(Request::url() == route('dashboard-routes'))? 'open':''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-route"></i>
                <div data-i18n="Routes Details">Routes Details</div>
            </a>
            <ul class="menu-sub ">
                <li class="menu-item {{(Request::url() == route('dashboard-cities'))? 'active':''}}">
                    <a href="{{ route('dashboard-cities') }}" class="menu-link">
                        <div>Cities</div>
                    </a>
                </li>
                <li class="menu-item {{(Request::url() == route('dashboard-routes'))? 'active':''}}">
                    <a href="{{ route('dashboard-routes') }}" class="menu-link">
                        <div>All  Routes</div>
                    </a>
                </li>
              
            </ul>
        </li>



        <li class="menu-item {{(Request::url() == route('dashboard-schedules'))? 'active':''}}">
            <a href="{{ route('dashboard-schedules') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-calendar"></i>
                <div data-i18n="Schedules">Schedules</div>
            </a>
        </li>

        <li class="menu-item {{(Request::url() == route('dashboard-bus-images'))? 'active':''}}">
            <a href="{{ route('dashboard-bus-images') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-album"></i>
                <div data-i18n="Bus Images">Bus Images</div>
            </a>
        </li>

        <li class="menu-item {{(Request::url() == route('dashboard-users'))? 'active':''}}">
            <a href="{{ route('dashboard-users') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Users">Users</div>
            </a>
        </li>

        
        <li class="menu-item {{(Request::url() == route('dashboard-report' , 'active'))? 'open':''}} || {{(Request::url() == route('dashboard-report' , 'close'))? 'open':''}} || {{(Request::url() == route('dashboard-category'))? 'open':''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-headphones"></i>
                <div data-i18n="Help">Help</div>
            </a>
            <ul class="menu-sub ">
                <li class="menu-item {{(Request::url() == route('dashboard-report' , 'active' ))? 'active':''}}">
                    <a href="{{ route('dashboard-report' , 'active') }}" class="menu-link">
                        <div>Active Report Tickets</div>
                    </a>
                </li>
                <li class="menu-item {{(Request::url() == route('dashboard-report' , 'close'))? 'active':''}} ">
                    <a href="{{ route('dashboard-report' , 'close') }}" class="menu-link">
                        <div>Close Report Tickets</div>
                    </a>
                </li><li class="menu-item {{(Request::url() == route('dashboard-category'))? 'active':''}}">
                    <a href="{{ route('dashboard-category') }}" class="menu-link">
                        <div>Add Category</div>
                    </a>
                </li>
                
              
            </ul>
        </li>


        <li class="menu-item {{(Request::url() == route('dashboard-faqs'))? 'active':''}}">
            <a href="{{ route('dashboard-faqs') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-help"></i>
                <div data-i18n="FAQ'S">FAQ'S</div>
            </a>
        </li>


        <li class="menu-item {{(Request::url() == route('dashboard-account'))? 'active':''}} || {{(Request::url() == route('dashboard-account-security'))? 'active':''}}">
            <a href="{{ route('dashboard-account') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="Account Settings">Account Settings</div>
            </a>
        </li>


        <li class="menu-item {{(Request::url() == route('dashboard-get-logout'))? 'active':''}} ">
            <a href="{{ route('dashboard-get-logout') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-logout"></i>
                <div data-i18n="Logout">Logout</div>
            </a>
        </li>





      

    </ul>
</aside>
