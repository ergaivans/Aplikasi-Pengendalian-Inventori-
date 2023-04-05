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
                                    <h4 class="card-title"> Data Kebutuhan Barang</h4>
                                    <button class="btn btn-success btn-round ml-auto" data-toggle="modal" data-target="#ModalTambahExcel">
                                        <i class="fa fa-plus"></i>
                                        Import Excel
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th> Rata - Rata Kebutuhan </th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($DaftarNilaiKebutuhan as $item)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td> {{ $item->NAMA_BARANG }}</td>
                                                    <td>{{ $item->AVG }} Unit
                                                    </td>
                                                    <td>
                                                        <a href="detail-kebutuhan/{{ $item->ID_BARANG}}"
                                                            class="btn btn-info btn-xs"> <i class="fa fa-info">
                                                                Lihat</i></a>
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
    <div class="modal fade" id="ModalTambahExcel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {{-- Judul Modal --}}

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Import Data Kebutuhan</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Isi Modal --}}

                <div class="modal-body">
                    {!! Form::open(['url' => '/importExcel', 'enctype'=>'multipart/form-data']) !!}

                    @csrf

                    <div class="form-group">
                        <label >Upload File Excel</label>
                        <input type="file" name="filexcel" class="form-control-file" id="exampleFormControlFile1" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                    </div>
                </div>

                {{-- Bawah Modal --}}

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection
