@extends('layout.layout')

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data Perencanaan Pembelian Barang </h4>
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
                        <a href="#">Perhitungan Barang </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Data Perencanaan Pembelian Barang</a>
                    </li>
                </ul>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex bd-highlight">
                                <div class="p-2 flex-grow-1 bd-highlight">
                                    <h4 class="card-title">Data Reorder </h4>
                                </div>
                                <div class="ml-auto">
                                    {{-- <a class="btn btn-primary btn-round ml-auto" href="/barang-kurang">
                                        <i class="fas fa-calculator"></i>
                                        Barang < ROP </a> --}}
                                            <a class="btn btn-danger btn-round ml-auto" target="_blank" href="/export-barang-rop">
                                                <i class="fa fa-plus"></i>
                                                Export Data
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
                                            <th>Nama Supplier</th>
                                            <th>Jumlah Barang</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach ($DataBarangRop as $item)
                                        @if ($item->STOCK_BARANG < $item->NILAI_ROP)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->NAMA_BARANG }}</td>
                                                <td>{{ $item->NAMA_SUPPLIER }}</td>
                                                <td>{{ $item->NILAI_EOQ }} Unit</td>
                                            </tr>
                                            @endif
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
