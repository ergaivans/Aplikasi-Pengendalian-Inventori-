@extends('layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Data Master Safety Factor</h4>
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
                            <a href="#">Master Safety Factor</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Daftar Safety Factor</a>
                        </li>
                    </ul>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Data Master Karyawan</h4>
                                    <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#ModalTambahSafety">
                                        <i class="fa fa-plus"></i>
                                        Add Row
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
                                                <th>Tanggal Safety Factor</th>
                                                <th>Nilai Safety Factor</th>
                                                <th>Status</th>
                                                {{-- <th>Aksi</th> --}}
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($DaftarFactor as $item)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td>{{ $item->NAMA_BARANG }}</td>
                                                    <td> Tahun {{ Carbon\Carbon::parse($item->TANGGAL_SAFE)->format('Y') }}</td>
                                                    <td>{{ $item->NILAI_SAFE }}</td>
                                                    @if ($item->STATUS_SAFE == 0  )
                                                    <td><button class="btn btn-secondary">Non-Aktif</button></td>
                                                    @else
                                                    <td><button class="btn btn-warning">Aktif</button></td>
                                                    @endif

                                                    {{-- <td>
                                                        <a href="#ModalHapusSafety{{ $item->ID_SAFETY }}" data-toggle="modal" class="btn btn-danger btn-xs"> <i class="fa fa-trash"> Hapus</i></a>
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

    {{-- Modal Tambah --}}
    <div class="modal fade" id="ModalTambahSafety" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {{-- Judul Modal --}}

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Safety Factor</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Isi Modal --}}

                <div class="modal-body">
                    {!! Form::open(['url' => '/TambahSafetyFactor', 'enctype'=>'multipart/form-data']) !!}

                    @csrf

                    <div class="form-group">
                        <label>Barang Yang Dipilih</label>
                        <select class="form-control" name="barang" required>
                            <option value="" hidden>---- Pilih Barang ----</option>

                            @foreach ($DaftarBarang as $dk)
                                <option value="{{ $dk->ID_BARANG }}">{{ $dk->NAMA_BARANG }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group">
                        <label >Tanggal Dimasukkan</label>
                        <input type="date" class="form-control" name="tgl_masuk" placeholder="Masukkan Tanggal Diproses" required>
                    </div>
                    <div class="form-group">
                        <label >Nilai Sebesar</label>
                        <input type="number" step="0.01" class="form-control" name="nilai" placeholder="Masukkan Nilai Safety Factor" min="0" required>
                    </div>
                    <div class="form-group">
                        <label >Status</label>
                        <select class="form-control" name="status" required>
                            <option value="" hidden>---- Pilih Status ----</option>
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
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


    {{-- ModalHapus --}}
    @foreach ($DaftarFactor as $h)
    <div class="modal fade" id="ModalHapusSafety{{ $h->ID_SAFETY }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {{-- Judul Modal --}}

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Hapus Data Safety Factor</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Isi Modal --}}

                <div class="modal-body">
                    {!! Form::open(['url' => '/HapusSafetyFactor', 'enctype'=>'multipart/form-data']) !!}

                    @csrf

                    <input type="hidden" value="{{$h->ID_SAFETY}}"  name="id" required>
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
