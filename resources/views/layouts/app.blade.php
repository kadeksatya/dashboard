<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}} | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('layouts.style')
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        @include('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @if (session('message'))
                    <div class="alert alert-success">
                        {{session('message')}}
                    </div>
                    @endif
                    @yield('content')
                </div>
                <!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0-rc
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    @include('layouts.script')

    <script>
        $(document).ready(function () {
            $('.delete').click(function () {
                var label = $(this).data('label');
                var url = $(this).data('url');
                Swal.fire({
                    title: 'Perhatian',
                    text: "Apakah yakin menghapus data " + label + " ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).data("id");
                        var token = $("meta[name='csrf-token']").attr("content");
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                "id": id,
                                "_token": token,
                            },
                            success: function (data) {
                                Swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                )
                                window.location.reload().time(3)
                            }
                        });
                    }
                })
            })
        });
    </script>
</body>

</html>