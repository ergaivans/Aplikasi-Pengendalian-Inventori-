@extends('layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Data Perhitungan</h4>
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
                            <a href="#">Perhitungan</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Daftar Nilai Perhitungan Barang</a>
                        </li>
                    </ul>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Data Nilai Perhitungan Barang</h4>
                                    <a class="btn btn-primary btn-round ml-auto" href="TambahPerhitunganBarang">
                                        <i class="fa fa-plus"></i>
                                        Tambah Data
                                     </a>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                {{-- <th>Standard Deviation</th> --}}
                                                <th>Stock Aman Persediaan</th>
                                                <th>Titik Pemesanan Kembali</th>
                                                <th>Jumlah Pemesanan </th>
                                                {{-- <th>Aksi</th> --}}
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{$item->NAMA_BARANG}}</td>
                                            {{-- <td>{{$item->NILAI_NSD}}</td> --}}
                                            <td>{{$item->NILAI_SS}} Unit</td>
                                            <td>{{$item->NILAI_ROP}} Unit</td>
                                            <td>{{$item->NILAI_EOQ}} Unit</td>
                                        </tr>
                                        @endforeach
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

@endsection
