@extends('layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Tambah Standard Deviation</h4>
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
                            <a href="#">Standard Deviation</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Daftar Data Standard Deviation</a>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Tambah Data Standard Deviation</div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['url' => '/TambahDataStandardDD', 'method' => 'POST','enctype' => 'multipart/form-data']) !!}

                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <select class="form-control" name="barang" id="barang" onchange="cari_barang(this.value)" required>
                                        <option value="" hidden>---- Pilih Barang ----</option>

                                        @foreach ($DataBarang as $db)
                                        <option value="{{ $db->ID_BARANG }}">{{ $db->NAMA_BARANG }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Operasi</label>
                                    <input type="date" class="form-control" name="tgl_nsd" placeholder="Masukkan Tanggal Input Perhitungan" required>
                                </div>
                                <div  id="nilaisf"></div>

                                <div class="form-group">
                                    <label >Status</label>
                                    <select class="form-control" name="status_nsd" required>
                                        <option value="" hidden>---- Pilih Status ----</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Non-Aktif</option>
                                    </select>
                                </div>

                            </div>
                            <div class="card-action">
                                <button type="submit" class="btn btn-success">Tambahkan </button>

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
    function cari_barang(val) {
        const url = "perhitunganajaxkeb"; // get the url of the view
        $.ajax({ // initialize an AJAX request
            url: url, // set the url of the request (=)
            data: {
                'ID_BARANG': val // add the country id to the GET parameters
            },
            success: function(data) { // `data` is the return of the view function
                // $("#nilaisd").html(data);
                $("#nilaisf").html(data);
            }
        });
    }

    // function perkalian() {
    //     document.getElementById("tot_masuk").value = document.getElementById("hrg_masuk").value * document.getElementById("jml_masuk").value  ;
    // }

</script>

@endsection
