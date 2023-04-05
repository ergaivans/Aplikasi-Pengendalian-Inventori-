@extends('layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Data Kebutuhan Barang</h4>
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
                            <a href="#">Kebutuhan Barang</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Daftar Data Kebutuhan Barang</a>
                        </li>
                    </ul>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title"> Data Kebutuhan Barang {{$keterangan->NAMA_BARANG}}</h4>
                                    <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#ModalTambahKebutuhan">
                                        <i class="fa fa-plus"></i>
                                        Tambah Data
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal </th>
                                                <th> Nilai Kebutuhan </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($barang as $item)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td> {{  Carbon\Carbon::parse($item->TANGGAL)->format('d / M / Y') }}</td>
                                                    <td>{{ $item->NOMINAL }} Unit
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

    <div class="modal fade" id="ModalTambahKebutuhan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {{-- Judul Modal --}}

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Safety Factor {{$keterangan->NAMA_BARANG}}</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Isi Modal --}}

                <div class="modal-body">
                    {!! Form::open(['url' => '/ProsesTambahKebutuhanBaru', 'enctype'=>'multipart/form-data']) !!}

                    @csrf
                    <input type="hidden" value="{{$keterangan->ID_BARANG}}"  name="id" required>

                    <div class="form-group">
                        <label >Tanggal Dimasukkan</label>
                        <input type="month" class="form-control" onchange="console.log(this.value)" name="tgl_masuk" placeholder="Masukkan Tanggal Diproses" required>
                    </div>
                    <div class="form-group">
                        <label >Nilai Kebutuhan Sebesar</label>
                        <input type="number" step="0.01" class="form-control" name="nilai" placeholder="Masukkan Nilai Kebutuhan" min="0" required>
                    </div>
                </div>

                {{-- Bawah Modal --}}

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection
