<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header pt-0">
        <div class="container-fluid pt-1">
            @include('flash::message')
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content pt-0">
        @yield('content')
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
