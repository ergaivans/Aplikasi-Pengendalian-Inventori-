@extends('layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Data Economic Order Quantity</h4>
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
                            <a href="#">Economic Order Quantity</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Daftar Data Economic Order Quantity</a>
                        </li>
                    </ul>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Data Economic Order Quantity</h4>
                                    <a class="btn btn-primary btn-round ml-auto" href="tambahEOQ">
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
                                                <th>Tanggal</th>
                                                <th>Persentase Biaya Simpan</th>
                                                <th>Nilai Biaya Simpan</th>
                                                <th>Nilai EOQ</th>
                                                <th>Status</th>
                                                {{-- <th>Aksi</th> --}}
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($DataEOQ as $item)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td>{{ $item->NAMA_BARANG }}</td>
                                                    <td>{{ Carbon\Carbon::parse($item->TANGGAL_EOQ)->format('d / M / Y') }}</td>
                                                    <td>{{ $item->PERSEN_SIMPAN }} %</td>
                                                    <td> @php   echo "Rp " . number_format($item->BIAYA_SIMPAN ,2,',','.');  @endphp </td>
                                                    <td>{{ $item->NILAI_EOQ }} Unit</td>
                                                   @if ($item->STATUS_EOQ == 0  )
                                                   <td><button class="btn btn-secondary">Non-Aktif</button></td>
                                                   @else
                                                   <td><button class="btn btn-warning">Aktif</button></td>
                                                   @endif


                                                    {{-- <td>
                                                        <a href="#ModalHapusEOQ{{ $item->ID_EOQ }}"
                                                            data-toggle="modal" class="btn btn-danger btn-xs"> <i
                                                                class="fa fa-trash"> Hapus</i></a>
                                                    </td> --}}
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

    {{-- ModalHapus --}}
    @foreach ($DataEOQ as $h)
    <div class="modal fade" id="ModalHapusEOQ{{$h->ID_EOQ}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {{-- Judul Modal --}}

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Hapus Data Safety Stock</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Isi Modal --}}

                <div class="modal-body">
                    {!! Form::open(['url' => '/HapusDataEOQ', 'enctype'=>'multipart/form-data']) !!}

                    @csrf

                    <input type="hidden" value="{{$h->ID_EOQ}}"  name="id" required>
                    <div class="form-group">
                        <h4> Apakah Anda Ingin Menghapus Data Ini ? </h4>
                    </div>


                </div>

                {{-- Bawah Modal --}}

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                    <button type="submit" class="btn btn-danger"> <i class="fa fa-trash" >Hapus Data</i> </button>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
    @endforeach

@endsection
