@extends('layout.layout')

@section('content')
<link href="{{ asset('./assets/select2/css/select2.min.css') }}" rel="stylesheet" />
<script src="{{ asset('./assets/select2/js/select2.min.js') }}"></script>
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Proses Perhitungan  Nilai Barang </h4>
                    <ul class="breadcrumbs">
                        <li class="nav-home">
                            <a href="#">
                                <i class="flaticon-home"></i>
                            </a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Perhitungan  Nilai Barang </a>
                        </li>

                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Tambah Data Perhitungan Nilai Barang </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['url' => '/TambahDataPerhitunganBarang', 'method' => 'POST','enctype' => 'multipart/form-data']) !!}

                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <select class="js-example-basic-single form-control" name="barang" id="barang" onchange="cari_barang(this.value)" required>
                                        <option value="" hidden>---- Pilih Barang ----</option>

                                        @foreach ($DataBarang as $db)
                                        <option value="{{ $db->ID_BARANG }}">{{ $db->NAMA_BARANG }}</option>
                                        @endforeach

                                    </select>

                                    <small id="emailHelp2" class="form-text text-muted">Kondisi Barang Tampil Harus Mempunyai Data Kebutuhan 12 Bulan Kebelakang, Data Operasi, dan Data Safety Factor
                                       <br> .
                                       <br>
                                        Jika Barang Tidak Tampil Mohon Cek Kembali PErsayaratan Data Diatas!!!!
                                    </small>
                                </div>

                                <div id="nilaisd"></div>
                                <div id="nilaiss"></div>
                                <div id="nilairop"></div>

                                {{-- <div class="form-group">
                                    <label >Status</label>
                                    <select class="form-control" name="status_rop" required>
                                        <option value="" hidden>---- Pilih Status ----</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Non-Aktif</option>
                                    </select>
                                </div> --}}

                            </div>
                            <div class="card-action">
                                <button type="submit" class="btn btn-success">Tambahkan </button>

                                <!-- <a href="TambahDataBarangMasuk" class="btn btn-success">Submit</a> -->
                                <a href="transaksibarangmasuk" class="btn btn-danger">Batal</a>
                            </div>
                            {!! Form::close() !!}

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="public/assets/js/core/jquery.3.2.1.min.js"></script>

    <script>
         $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    function cari_barang(val) {
        const url = "ajaxPerhitungan"; // get the url of the view
        console.log(val);
        $.ajax({ // initialize an AJAX request
            url: url, // set the url of the request (=)
            data: {
                'ID_BARANG': val // add the country id to the GET parameters
            },
            success: function(data) {
                $("#nilaisd").html(data);
            }
        });
    }

    </script>

@endsection
