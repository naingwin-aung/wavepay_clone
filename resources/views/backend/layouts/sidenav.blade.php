<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          {{-- <img src="assets/img/brand/blue.png" class="navbar-brand-img" alt="..."> --}}
          {{-- <img src="{{asset('/img/brand/blue.png')}}" class="navbar-brand-img" alt="..."> --}}
          <h2><span class="text-danger font-weight-bold">Wave</span> Pay</h2>
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link @yield('admin_dashboard')" href="{{route('admin.index')}}">
                <i class="fas fa-user text-primary"></i>
                <span class="nav-link-text">Admin Users</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @yield('user_dashboard')" href="{{route('users')}}">
                <i class="fas fa-users text-primary"></i>
                <span class="nav-link-text">Users</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>