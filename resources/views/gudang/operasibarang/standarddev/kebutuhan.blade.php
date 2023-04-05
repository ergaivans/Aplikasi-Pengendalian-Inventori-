@extends('layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Data Standard Deviation</h4>
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
                            <a href="#">Oprasi Data</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Data Dtandard Deviation</a>
                        </li>
                    </ul>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Data Standard Deviation</h4>
                                    {{-- <button class="btn btn-primary btn-round ml-auto" data-toggle="modal"
                                        data-target="#ModalTambahNSD">
                                        <i class="fa fa-plus"></i>
                                        Tambah Data Kebutuhan
                                    </button> --}}
                                    <a class="btn btn-primary btn-round ml-auto" href="tambahStandard">
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
                                                <th>Tanggal Perhitungan</th>
                                                <th>Nilai Perhitungan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($DaftarNilaiNSD as $item)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td>{{ $item->NAMA_BARANG }}</td>
                                                    <td>{{ Carbon\Carbon::parse($item->TANGGAL_NSD)->format('d / M / Y') }}</td>
                                                    <td>{{ $item->NILAI_NSD }}</td>
                                                   {{-- <td>@php echo date_format( $item->TANGGAL_MASUK," %D %M %Y ") @endphp</td> --}}
                                                   @if ($item->STATUS_NSD == 0  )
                                                   <td><button class="btn btn-secondary">Non-Aktif</button></td>
                                                   @else
                                                   <td><button class="btn btn-warning">Aktif</button></td>
                                                   @endif
                                                    {{-- <td>
                                                        <a href="#ModalHapusBarang{{ $item->ID_NSD}}"
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

    {{-- Modal Tambah --}}
    <div class="modal fade" id="ModalTambahNSD" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {{-- Judul Modal --}}

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Kebutuhan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Isi Modal --}}

                <div class="modal-body">
                    {!! Form::open(['url' => '/TambahKebutuhanBarang', 'enctype' => 'multipart/form-data']) !!}

                    @csrf

                    <div class="form-group">
                        <label>Nama Barang</label>
                        <select class="form-control" name="barang" id="barang" required>
                            <option value="" hidden>---- Pilih Barang ----</option>

                            @foreach ($DaftarBarang as $db)
                            <option value="{{ $db->ID_BARANG }}">{{ $db->NAMA_BARANG }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-1</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Harga Barang" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-2</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Harga Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-3</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Harga Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-4</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Harga Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-5</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Harga Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-6</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Harga Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-7</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Harga Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-8</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Harga Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-9</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Harga Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-10</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Harga Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-11</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Harga Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-12</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Harga Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label >Status</label>
                        <select class="form-control" name="status_nsd" required>
                            <option value="" hidden>---- Pilih Status ----</option>
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>

                </div>

                {{-- Bawah Modal --}}

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-undo"></i>
                        Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>

    {{-- ModalHapus --}}
    @foreach ($DaftarNilaiNSD as $h)
        <div class="modal fade" id="ModalHapusBarang{{ $h->ID_NSD }}" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    {{-- Judul Modal --}}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Hapus Data Supplier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    {{-- Isi Modal --}}

                    <div class="modal-body">
                        {!! Form::open(['url' => '/HapusBarang', 'enctype' => 'multipart/form-data']) !!}

                        @csrf

                        <input type="hidden" value="{{ $h->ID_NSD }}" name="id" required>
                        <div class="form-group">
                            <h4> Apakah Anda Ingin Menghapus Data Ini ? </h4>
                        </div>


                    </div>

                    {{-- Bawah Modal --}}

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-undo"></i>
                            Close</button>
                        <button type="submit" class="btn btn-danger"> <i class="fa fa-trash">Hapus Data</i> </button>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    @endforeach

@endsection
