@extends('layout.layout')

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data Master Barang</h4>
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
                        <a href="#">Master Barang</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Daftar Barang</a>
                    </li>
                </ul>
                <div class="ml-auto">
                    <button data-toggle="modal" data-target="#exampleModal" class="btn btn-success" style="margin-top: 10px;" type="submit">Filter</button>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col mt-3">
                                    <h4 class="card-title">Data Barang Masuk</h4>
                                    <p>Menampilkan data <b>'{{$namaBarang}}'</b> dari tanggal {{ Carbon\Carbon::parse($fromDate)->format('d M Y') }} sampai tanggal {{ Carbon\Carbon::parse($toDate)->format('d M Y') }}</p>
                                </div>
                                <div class="col-md-auto mt-2">
                                    <a class="btn btn-danger btn-round ml-auto" href="/transaksibarangkeluar/export?from={{$fromDate}}&to={{$toDate}}&search={{$namaBarang}}">
                                        <i class="fa fa-plus"></i>
                                        Export PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Tanggal</th>
                                            <th>Nama Karyawan</th>
                                            <th>Jumlah</th>
                                            <th>Harga Barang</th>
                                            <th>Total</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @php
                                        $no = 1;
                                        @endphp
                                        @if (!empty($DaftarBarangKeluar))
                                        @foreach ($DaftarBarangKeluar as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->NAMA_BARANG }}</td>
                                            <td>{{ $item->TANGGAL_KELUAR }}</td>
                                            <td>{{ $item->NAMA_KAR }}</td>
                                            <td>{{ $item->JML_KELUAR }} Unit</td>
                                            <td> @php echo "Rp " . number_format( $item->HARGA_BARANG ,2,',','.'); @endphp </td>

                                            <td> @php echo "Rp " . number_format($item->JML_KELUAR * $item->HARGA_BARANG ,2,',','.'); @endphp </td>
                                            <td>{{ $item->KET_KELUAR }}</td>
                                            <td>
                                                <a href="#ModalHapusBarang{{ $item->ID_KELUAR }}" data-toggle="modal" class="btn btn-danger btn-xs"> <i class="fa fa-trash"> Hapus</i></a>
                                            </td>
                                        </tr>
                                        @php
                                        $no++;
                                        @endphp
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="8" align="center">Data Kosong</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/transaksibarangkeluar/filter') }}" method="post">

                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="from">Nama Barang :</label>
                            <div class="form-group ml-auto" align="right">
                                <input type="text" name="namaBarang" class="form-control" id="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-6">
                            <label for="from">Dari Tanggal :</label>
                            <div class="form-group ml-auto" align="right">
                                <input type="date" name="fromFilterDate" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-sm-6 col-6">
                            <label for="to">Sampai Tanggal :</label>
                            <div class="form-group ml-auto" align="right">
                                <input type="date" name="toFilterDate" class="form-control" id="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-success" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
