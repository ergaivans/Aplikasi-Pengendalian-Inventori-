@extends('layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Proses Perhitungan Economic Order Quantity</h4>
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
                            <a href="#">Perhitungan Economic Order Quantity</a>
                        </li>

                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Tambah Data Economic Order Quantity </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['url' => '/TambahDataEOQ', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <select class="form-control" name="barang" id="barang"
                                        onchange="cari_barang(this.value)" required>
                                        <option value="" hidden>---- Pilih Barang ----</option>

                                        @foreach ($DataBarang as $db)
                                            <option value="{{ $db->ID_BARANG }}">{{ $db->NAMA_BARANG }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Operasi</label>
                                    <input type="date" class="form-control" name="tgl_eoq"
                                        placeholder="Masukkan Tanggal Input Perhitungan" required>
                                </div>

                                <div class="form-group">
                                    <label> Persentase Biaya Simpan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">%</span>
                                        </div>
                                        <input type="number" onkeyup="perkalianbiayasimpan()" id="biaya_simpan"
                                            class="form-control" name="biaya_simpan"
                                            placeholder="Masukkan Harga Beli Barang" min="0" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Nilai Biaya Simpan</label>
                                    <input type="hidden" class="form-control" name="nilai_simpan" id="nilai_simpanV"
                                        readonly required>
                                    <input type="text" class="form-control" id="nilai_simpanD" readonly required>
                                </div>


                                <div id="nilaiEOQ"></div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status_EOQ" required>
                                        <option value="" hidden>---- Pilih Status ----</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Non-Aktif</option>
                                    </select>
                                </div>

                            </div>
                            <div class="card-action">
                                <button type="submit" class="btn btn-success">Tambahkan </button>

                                <!-- <a href="TambahDataBarangMasuk" class="btn btn-success">Submit</a> -->
                                <a href="mastereoq" class="btn btn-danger">Cancel</a>
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
        function cari_barang(val) {
            const url = "ajaxeoq"; // get the url of the view
            console.log(val);
            $.ajax({ // initialize an AJAX request
                url: url, // set the url of the request (=)
                data: {
                    'ID_BARANG': val // add the country id to the GET parameters
                },
                success: function(data) { // `data` is the return of the view function
                    // $("#nilaisd").html(data);
                    $("#nilaiEOQ").html(data);
                }
            });
        }

        function perkalianbiayasimpan() {

            let biaya = (document.getElementById("biaya_simpan").value / 100) * document.getElementById("harga_barang")
                .value;

            $('#nilai_simpanV').val(biaya);
            $('#nilai_simpanD').val(harga_tip(biaya))

            perhitunganeoq();

        }

        function perhitunganeoq() {
            document.getElementById("nilai_eoq").value = Math.round(Math.sqrt((2 * document.getElementById("nilai_kb")
                    .value * document.getElementById("nilai_pem").value) / document.getElementById("nilai_simpanV")
                .value));
        }

        function harga_tip(val) {
            var formatter = new Intl.NumberFormat('id-ID', {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            });
            return "Rp " + formatter.format(val);
        }
    </script>
@endsection
