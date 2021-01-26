<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-olive">
    <!-- Brand Logo -->
    <a href="/" class="brand-link navbar-white">
        <img src="/img/logo.png"
             alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Tasks App</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/img/man.png" class="img-elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="" onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                   class="d-block">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
            </div>
        </div>

        <form id="logout-form" class="d-block" action="{{ route('logout') }}" method="POST" style="display:none;">
            {{ csrf_field() }}
        </form>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @hasanyrole('admin|simple')
                <li class="nav-item">
                    <a href="{{route('task_index')}}" class="nav-link" style="color:#28a745">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Tarefas</p>
                    </a>
                </li>
                @endhasanyrole
                @hasrole('admin')
                <li class="nav-item">
                    <a href="{{route('user_index')}}" class="nav-link" style="color:#28a745">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Utilizadores</p>
                    </a>
                </li>
                @endhasrole
                @hasrole('admin')
                <li class="nav-item">
                    <a href="{{route('department_index')}}" class="nav-link" style="color:#28a745">
                        <i class="fas fa-building nav-icon"></i>
                        <p>Departamentos</p>
                    </a>
                </li>
                @endhasrole
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
