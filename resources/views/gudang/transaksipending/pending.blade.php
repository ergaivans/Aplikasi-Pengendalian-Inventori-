@extends('layout.layout')

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data Transaksi Pending</h4>
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
                        <a href="#">Transaksi Pending</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Transaksi Pending</a>
                    </li>
                </ul>
                {{-- <div class="ml-auto">
                    <button data-toggle="modal" data-target="#exampleModal" class="btn btn-success" style="margin-top: 10px;" type="submit">Filter</button>
                </div> --}}
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col mt-3">
                                    <h4 class="card-title">Data Transaksi Pending</h4>
                                </div>
                                <div class="col col-lg-2 mt-2">
                                    {{-- <a class="btn btn-primary btn-round ml-auto" href="transaksitambahbarangkeluar">
                                        <i class="fa fa-plus"></i>
                                        Tambah Data
                                    </a> --}}
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
                                        @foreach ($DaftarBarangKeluar as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->NAMA_BARANG }}</td>
                                            <td>{{ $item->TANGGAL_KELUAR }}</td>
                                            <td>{{ $item->NAMA_KAR }}</td>
                                            <td>{{ $item->JML_UNIT }} Unit</td>
                                            <td> @php echo "Rp " . number_format( $item->HARGA_BARANG ,2,',','.'); @endphp </td>

                                            <td> @php echo "Rp " . number_format($item->JML_UNIT * $item->HARGA_BARANG ,2,',','.'); @endphp </td>
                                            <td>{{ $item->KET_KELUAR }}</td>

                                            <td>
                                                @if ($item->JML_UNIT > $item->STOCK_BARANG)
                                                <a href="#"  class="btn btn-secondary btn-xs disabled w-100" >   Stock Tidak Mencukupi </a>
                                                @else
                                                <a href="#ModalHapusPending{{ $item->ID_DETILKEL }}" data-toggle="modal" class="btn btn-warning btn-xs w-100"> Update </a>
                                                @endif

                                            </td>
                                        </tr>
                                        @php
                                        $no++;
                                        @endphp
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

@foreach ($DaftarBarangKeluar as $h)
<div class="modal fade" id="ModalHapusPending{{$h->ID_DETILKEL}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            {{-- Judul Modal --}}

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Peringatan Transaksi Pending</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Isi Modal --}}

            <div class="modal-body">
                {!! Form::open(['url' => '/UpdateDataPending', 'enctype'=>'multipart/form-data']) !!}

                @csrf

                <input type="hidden" value="{{$h->ID_DETILKEL}}"  name="id" required>
                <div class="form-group">
                    <h4> Apakah Anda Ingin Menyelesaikan Transaksi Ini?</h4>
                </div>
            </div>

            {{-- Bawah Modal --}}

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fa fa-undo"></i> Batalkan</button>
                <button type="submit" class="btn btn-warning"> <i class="fa fa-check" ></i>  Update Data</button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
@endforeach
@endsection
