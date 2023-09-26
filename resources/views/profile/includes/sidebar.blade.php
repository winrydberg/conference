  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar" style="background-color: #234F1E;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel" style="position:inherit">
        <div class="image" style="display:block;margin:auto">
          <img src="{{asset('assets/img/mawuli.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="info">
          <p>OMSU GLOBAL</p>
        </div>
      </div>

      <ul class="sidebar-menu" data-widget="tree" style="margin-top:20px">
        <li class="">
            <a href="{{url('/profile')}}">
              <i class="fa fa-dashboard"></i> <span>HOME</span>
            </a>
        </li>

        <li class="">
            <a href="{{url('/year-group')}}">
              <i class="fa fa-list"></i> <span>MY YEAR GROUP</span>
            </a>
        </li>
  
        
        <li>
          <a href="{{url('/profile-logout')}}">
            <i class="fa fa-sign-out"></i> <span>LOGOUT</span>
          </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
