  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar" style="background-color: #000073;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
   

      </div>

      <ul class="sidebar-menu" data-widget="tree">
        <li class="">
            <a href="{{url('/admin-dashboard')}}">
              <i class="fa fa-dashboard"></i> <span>DASHBOARD</span>
            </a>
        </li>

        {{-- @hasanyrole('UGBS ACCREDITATION STAFF|UGBSSTAFF|SUPERADMIN') --}}
        <li class="treeview">
            <a href="#">
              <i class="fa fa-bookmark"></i>
              <span>CONFERENCES</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{url('/new-conference')}}"><i class="fa fa-circle-o"></i> New Conference</a></li>
                <li><a href="{{url('/conferences')}}"><i class="fa fa-circle-o"></i> All Conferences</a></li>
            </ul>
        </li> 
        {{-- @endhasanyrole --}}


          @role('UGCS-ADMIN')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-list"></i>
              <span>ACCOUNTS</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
             
              <li><a href="{{url('/accounts')}}"><i class="fa fa-circle-o"></i> New Account</a></li>
              <li><a href="{{url('/accounts')}}"><i class="fa fa-circle-o"></i> Accounts</a></li>
            </ul>
          </li>
          @endrole




        

        <li>
          <a href="{{url('/logout')}}">
            <i class="fa fa-sign-out"></i> <span>LOGOUT</span>
          </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
