<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Aplikasi Pengendalian Inventori</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('./assets/img/icon.ico') }}" type="image/x-icon" />
    <script src="{{ asset('./assets/js/core/jquery.3.2.1.min.js') }}"></script>



    <!-- Fonts and icons -->
    <script src="{{ asset('./assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Open+Sans:300,400,600,700"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"],
                urls: ["{{ asset('./assets/css/fonts.css') }}"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('./assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/css/azzara.min.css') }}">
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('./assets/css/demo.css') }}">
</head>

<body>

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="wrapper">
        <!--
    Tip 1: You can change the background color of the main header using: data-background-color="blue | purple | light-blue | green | orange | red"
  -->
        <div class="main-header" data-background-color="purple">
            <!-- Logo Header -->
            <div class="logo-header">

                <a href="#" class="logo px-3">
                    <img src="{{ asset('./assets/img/greven-03.png') }}" style="height: 85%" alt="navbar brand" class="navbar-brand">
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="fa fa-bars"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>
                <div class="navbar-minimize">
                    <button class="btn btn-minimize btn-rounded">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg">

                <div class="container-fluid">
                    <div class="collapse" id="search-nav">
                        <form class="navbar-left navbar-form nav-search mr-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pr-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control">
                            </div>
                        </form>
                    </div>
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item toggle-nav-search hidden-caret">
                            <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button"
                                aria-expanded="false" aria-controls="search-nav">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>


                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="{{ asset('./assets/img/profile.jpg') }}" alt="..."
                                        class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <li>
                                    <div class="user-box">
                                        <div class="avatar-lg"><img src="{{ asset('./assets/img/profile.jpg') }}"
                                                alt="image profile" class="avatar-img rounded"></div>
                                        <div class="u-text">
                                            <h4> {{ Session::get('user')[1] }}</h4>
                                            <p class="text-muted"> {{ Session::get('user')[3] }}</p>
                                            {{-- <a href="profile.html" class="btn btn-rounded btn-danger btn-sm">View Profile</a> --}}
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#"> <i class="fa fa-user"
                                            aria-hidden="true"></i> My Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="logout"> <i class="fa fa-lock"
                                            aria-hidden="true"></i> Logout</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
        <!-- Sidebar -->
        <div class="sidebar">

            <div class="sidebar-wrapper scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-2">
                            <img src="{{ asset('./assets/img/profile.jpg') }}" alt="..."
                                class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
                                    {{ Session::get('user')[1] }}
                                    <span class="user-level">
                                        @if (Session::get('user')[2] == 0)
                                            Bagian Gudang
                                        @elseif(Session::get('user')[2] == 1)
                                            Bagian Administrasi
                                        @else
                                            Pemilik
                                        @endif
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="{{ url('dashboard') }}">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        @if (Session::get('user')[2] != 2)

                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Menu Aplikasi</h4>
                        </li>



                        {{-- disebar karyawan --}}
                        @if (Session::get('user')[2] == 1)
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#karyawan">
                                <i class="fa fa-user"></i>
                                <p>Karyawan</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="karyawan">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="{{ url('masteruser') }}">
                                            <span class="sub-item">Daftar Karyawan</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endif

                        {{-- Master Barang --}}
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#transaksimaster">

                                <i class="fas fa-box-open"></i>
                                <p> Master Data </p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="transaksimaster">
                                <ul class="nav nav-collapse">
                                    @if (Session::get('user')[2] == 1)
                                    <li>
                                        <a href="{{ url('mastersupplier') }}">
                                            <span class="sub-item">Master Supplier</span>
                                        </a>
                                    </li>
                                    @endif
                                    @if (Session::get('user')[2] != 1 )
                                    <li>
                                        <a href="{{ url('masterkategori') }}">
                                            <span class="sub-item">Master Kategori</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('masterbarang') }}">
                                            <span class="sub-item">Master Barang</span>
                                        </a>
                                    </li>
                                    @endif
                                    @if (Session::get('user')[2] == 1)
                                    <li>
                                        <a href="{{ url('masterfactor') }}">
                                            <span class="sub-item">Master Safety Factor</span>
                                        </a>
                                    </li>
                                    @endif
                                    @if (Session::get('user')[2] == 1)
                                    <li>
                                        <a href="{{ url('masteroperasi') }}">
                                            <span class="sub-item">Master Operasi</span>
                                        </a>
                                    </li>
                                    @endif

                                </ul>
                            </div>
                        </li>
                        @if (Session::get('user')[2] != 1)
                        {{-- disebar Transaksi barang --}}
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#transaksibarang">
                                <i class="fa fa-shopping-cart"></i>
                                <p>Transaksi Barang</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="transaksibarang">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="{{ url('transaksibarangmasuk') }}">
                                            <span class="sub-item">Barang Masuk</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('transaksibarangkeluar') }}">
                                            <span class="sub-item">Barang Keluar</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('transaksibarangpending') }}">
                                            <span class="sub-item">Barang Pending</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        {{-- disebar Operasi barang --}}
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#transaksioperasi">
                                <i class="fas fa-money-bill-wave    "></i>
                                <p>Perhitungan Barang</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="transaksioperasi">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="{{ url('kebutuhanbarang') }}">
                                            <span class="sub-item">Perhitungan Kebutuhan Barang</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('PerhitunganBarang') }}">
                                            <span class="sub-item">Perhitungan Nilai Barang</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="{{ url('mastersd') }} ">
                                            <span class="sub-item">Perhitungan Standard Deviation</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('masterss') }}">
                                            <span class="sub-item">Perhitungan Safety Stock</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('masterrop') }}">
                                            <span class="sub-item">Perhitungan Reorder Point</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('mastereoq') }}">
                                            <span class="sub-item">Perhitungan Economic Order Quantity</span>
                                        </a>
                                    </li> --}}

                                    <li>
                                        <a href="{{ url('databarangrop') }}">
                                            <span class="sub-item">Perencanaan Pembelian Barang</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        @endif
                        @endif

                        @if (Session::get('user')[2] == 2)
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Menu Persetujuan</h4>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#persetujuan">
                                <i class="fa fa-shopping-cart"></i>
                                <p>Persetujuan Pembelian</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="persetujuan">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="{{ url('persetujuanbarang') }}">
                                            <span class="sub-item">Persetujuan Daftar Pembelian</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endif


                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Menu Laporan</h4>
                        </li>


                        {{-- disebar Transaksi barang --}}
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#transaksilaporan">
                                <i class="fa fa-shopping-cart"></i>
                                <p>Laporan</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="transaksilaporan">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="{{ url('export-barang-masuk') }}">
                                            <span class="sub-item">Laporan Transaksi Barang Masuk</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('export-barang-keluar') }}">
                                            <span class="sub-item">Laporan Transaksi Barang Keluar</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('pembelian') }}">
                                            <span class="sub-item">Laporan Rencana Pembelian Barang</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @yield('content')
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('./assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('./assets/js/core/bootstrap.min.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('./assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('./assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
    <!-- Bootstrap Toggle -->
    <script src="{{ asset('./assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>
    <!-- jQuery Scrollbar -->
    <script src="{{ asset('./assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('./assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <!-- Azzara JS -->
    <script src="{{ asset('./assets/js/ready.min.js') }}"></script>
    <!-- Azzara DEMO methods, don't include it in your project! -->
    <script src="{{ asset('./assets/js/setting-demo.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#add-row').DataTable({});
        });
    </script>

    @stack('scripts')

</body>

</html>
