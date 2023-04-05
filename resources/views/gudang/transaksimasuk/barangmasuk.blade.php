@extends('layout.layout')

@section('content')
<link href="{{ asset('./assets/select2/css/select2.min.css') }}" rel="stylesheet" />
<script src="{{ asset('./assets/select2/js/select2.min.js') }}"></script>
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Tambah Barang Masuk</h4>
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
                            <a href="#">Transaksi Barang</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Barang Masuk</a>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Tambah Barang Masuk</div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['url' => '/TambahDataBarangMasuk', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <select class="js-example-basic-single form-control" name="barang" id="barang"
                                        onchange="run_ajax(this)" required>
                                        <option value="" style="display: none;">---- Pilih Barang ----</option>
                                        @foreach ($DaftarBarang as $db)
                                            <option value="{{ $db->ID_BARANG }}">{{ $db->NAMA_BARANG }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group" style="display: none;" id="daftarsupplier"></div>

                                <div class="form-group" style="display: none;" id="daftar_id_pemesanan"></div>

                                <div class="form-group">
                                    <label>Karyawan</label>
                                    <input type="text" class="form-control"
                                        placeholder=" {{ Session::get('user')[1] }}" readonly required>
                                    <input type="hidden" class="form-control" value=" {{ Session::get('user')[0] }}"
                                        name="karyawan" readonly required>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Masuk</label>
                                    <input type="date" class="form-control" name="tgl_masuk"
                                        placeholder="Masukkan Tanggal Keluar Barang" required>

                                </div>
                                <div class="form-group">
                                    <label>Jumlah Barang Masuk</label>
                                    <input type="number" id="jml_masuk" onkeyup="perkalian()" class="form-control"
                                        name="jml_masuk" placeholder="Masukkan Jumlah Keluar Barang" min="0"
                                        required>
                                        <small id="textpemesanan" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group">
                                    <label>Harga Barang Masuk</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                        </div>
                                        <input type="number" onkeyup="perkalian()" id="hrg_masuk" class="form-control"
                                            name="hrg_masuk" placeholder="Masukkan Harga Beli Barang" min="0"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Total Nilai Barang Masuk</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                        </div>
                                        <input type="number" id="tot_masuk" class="form-control" name="tot_masuk" readonly required>
                                    </div>
                                </div>

                            </div>
                            <div class="card-action">
                                <button type="submit" class="btn btn-success">Tambahkan</button>
                                <!-- <a href="TambahDataBarangMasuk" class="btn btn-success">Submit</a> -->
                                <a href="transaksibarangmasuk" class="btn btn-danger">Cancel</a>
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

        function run_ajax(val){
            cari_supplier(val.value);
            cari_id_pemesanan(val.value);
        }

        function cari_supplier(val) {
            const url = "transaksitambahbarangmasukAjax"; // get the url of the view
            $.ajax({ // initialize an AJAX request
                url: url, // set the url of the request (=)
                data: {
                    'ID_BARANG': val // add the country id to the GET parameters
                },
                success: function(data) { // `data` is the return of the view function
                    document.getElementById('daftarsupplier').style.display = '';
                    $("#daftarsupplier").html(data);
                }
            });
        }

        function cari_id_pemesanan(val){
            const url = "cariidpemesananbarangmasukAjax"; // get the url of the view
            $.ajax({ // initialize an AJAX request
                url: url, // set the url of the request (=)
                data: {
                    'ID_BARANG': val // add the country id to the GET parameters
                },
                success: function(data) { // `data` is the return of the view function
                    document.getElementById('daftar_id_pemesanan').style.display = '';
                    $("#daftar_id_pemesanan").html(data);
                }
            });
        }


        function perkalian() {
            document.getElementById("tot_masuk").value = document.getElementById("hrg_masuk").value * document
                .getElementById("jml_masuk").value;
        }


        document.getElementById('jml_masuk').oninput = function () {
        var max = parseInt(this.max);

        if (parseInt(this.value) > max) {
            this.value = max;
        }
    }
    </script>
@endsection
