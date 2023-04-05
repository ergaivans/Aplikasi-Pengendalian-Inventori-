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
                            <a href="#">Operasi Data</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Data Kebutuhan Barang</a>
                        </li>
                    </ul>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Data Kebutuhan Barang</h4>
                                    <button class="btn btn-primary btn-round ml-auto" data-toggle="modal"
                                        data-target="#ModalTambahNSD">
                                        <i class="fa fa-plus"></i>
                                        Tambah Data Kebutuhan
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
                                                <th>Januari</th>
                                                <th>Februari</th>
                                                <th>Maret</th>
                                                <th>April</th>
                                                <th>Mei</th>
                                                <th>Juni</th>
                                                <th>Juli</th>
                                                <th>Agustus</th>
                                                <th>September</th>
                                                <th>Oktober</th>
                                                <th>November</th>
                                                <th>Desember</th>

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
                                                    <td>{{ $item->NAMA_BARANG }}</td>
                                                    <td>{{ $item->BULAN_1 }} Unit</td>
                                                    @if ($item->BULAN_2 == null)
                                                        <td>Data Belum Dimasukan</td>
                                                    @else
                                                        <td>{{ $item->BULAN_2 }} Unit</td>
                                                    @endif
                                                    @if ($item->BULAN_3 == null)
                                                        <td>Data Belum Dimasukan</td>
                                                    @else
                                                        <td>{{ $item->BULAN_3 }} Unit</td>
                                                    @endif
                                                    @if ($item->BULAN_4 == null)
                                                        <td>Data Belum Dimasukan</td>
                                                    @else
                                                        <td>{{ $item->BULAN_4 }} Unit</td>
                                                    @endif
                                                    @if ($item->BULAN_5 == null)
                                                        <td>Data Belum Dimasukan</td>
                                                    @else
                                                        <td>{{ $item->BULAN_5 }} Unit</td>
                                                    @endif
                                                    @if ($item->BULAN_6 == null)
                                                        <td>Data Belum Dimasukan</td>
                                                    @else
                                                        <td>{{ $item->BULAN_6 }} Unit</td>
                                                    @endif
                                                    @if ($item->BULAN_7 == null)
                                                        <td>Data Belum Dimasukan</td>
                                                    @else
                                                        <td>{{ $item->BULAN_7 }} Unit</td>
                                                    @endif
                                                    @if ($item->BULAN_8 == null)
                                                        <td>Data Belum Dimasukan</td>
                                                    @else
                                                        <td>{{ $item->BULAN_8 }} Unit</td>
                                                    @endif
                                                    @if ($item->BULAN_9 == null)
                                                        <td>Data Belum Dimasukan</td>
                                                    @else
                                                        <td>{{ $item->BULAN_9 }} Unit</td>
                                                    @endif
                                                    @if ($item->BULAN_10 == null)
                                                        <td>Data Belum Dimasukan</td>
                                                    @else
                                                        <td>{{ $item->BULAN_10 }} Unit</td>
                                                    @endif
                                                    @if ($item->BULAN_11 == null)
                                                        <td>Data Belum Dimasukan</td>
                                                    @else
                                                        <td>{{ $item->BULAN_11 }} Unit</td>
                                                    @endif
                                                    @if ($item->BULAN_12 == null)
                                                        <td>Data Belum Dimasukan</td>
                                                    @else
                                                        <td>{{ $item->BULAN_12 }} Unit</td>
                                                    @endif
                                                    {{-- <td>@php echo date_format( $item->TANGGAL_MASUK," %D %M %Y ") @endphp</td> --}}

                                                    <td>
                                                        <a href="#ModalEditKebutuhan{{ $item->ID_SD }}" data-toggle="modal"
                                                            class="btn btn-primary btn-xs"> <i class="fa fa-edit">
                                                                Edit</i></a>
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

                            @foreach ($barang as $db)
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
                            <input type="number" class="form-control" name="harga[]" placeholder="Nilai Kebutuhan Barang" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-2</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Nilai Kebutuhan Barang" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-3</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-4</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-5</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-6</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-7</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-8</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-9</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-10</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-11</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bulan Ke-12</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Unit</span>
                            </div>
                            <input type="number" class="form-control" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
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
    {{-- Modal Update --}}
    @foreach ($DaftarNilaiKebutuhan as $u)
        <div class="modal fade" id="ModalEditKebutuhan{{ $u->ID_SD }}" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    {{-- Judul Modal --}}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Data Kebutuhan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    {{-- Isi Modal --}}

                    <div class="modal-body">
                        {!! Form::open(['url' => '/ubahkebutuhanbarang', 'enctype' => 'multipart/form-data']) !!}

                        @csrf

                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="hidden" value="{{$u->ID_SD}}" name="ID_SD" id="barang" readonly required>
                            <input type="text" class="form-control"  value="{{$u->NAMA_BARANG}}" readonly required>
                            {{-- <select class="form-control" name="barang" id="barang" required>
                                <option value="" hidden>---- Pilih Barang ----</option>

                                @foreach ($DaftarNilaiKebutuhan as $db)
                                    <option value="{{ $db->ID_BARANG }}">{{ $db->NAMA_BARANG }}</option>
                                @endforeach
                            </select> --}}
                        </div>
                        <div class="form-group">
                            <label>Bulan Ke-1</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Unit</span>
                                </div>
                                <input type="number" class="form-control"  value="{{ $u->BULAN_1 }}" name="harga[]" placeholder="Nilai Kebutuhan Barang" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bulan Ke-2</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Unit</span>
                                </div>
                                <input type="number" class="form-control" value="{{ $u->BULAN_2 }}"name="harga[]" placeholder="Nilai Kebutuhan Barang" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bulan Ke-3</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Unit</span>
                                </div>
                                <input type="number" class="form-control" value="{{ $u->BULAN_3 }}" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bulan Ke-4</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Unit</span>
                                </div>
                                <input type="number" class="form-control" value="{{ $u->BULAN_4 }}" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bulan Ke-5</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Unit</span>
                                </div>
                                <input type="number" class="form-control" value="{{ $u->BULAN_5 }}" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bulan Ke-6</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Unit</span>
                                </div>
                                <input type="number" class="form-control" value="{{ $u->BULAN_6 }}" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bulan Ke-7</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Unit</span>
                                </div>
                                <input type="number" class="form-control" value="{{ $u->BULAN_7 }}" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bulan Ke-8</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Unit</span>
                                </div>
                                <input type="number" class="form-control"  value="{{ $u->BULAN_8 }}" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bulan Ke-9</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Unit</span>
                                </div>
                                <input type="number" class="form-control" value="{{ $u->BULAN_9 }}" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bulan Ke-10</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Unit</span>
                                </div>
                                <input type="number" class="form-control" value="{{ $u->BULAN_10 }}" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bulan Ke-11</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Unit</span>
                                </div>
                                <input type="number" class="form-control" value="{{ $u->BULAN_11 }}" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bulan Ke-12</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Unit</span>
                                </div>
                                <input type="number" class="form-control" value="{{ $u->BULAN_12 }}" name="harga[]" placeholder="Nilai Kebutuhan Barang">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status_nsd" required disabled>
                                <option value="" hidden>---- Pilih Status ----</option>
                                <option value="1" @if($u->STATUS_KB == 1) selected @endif>Aktif</option>
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
    @endforeach

    {{-- ModalHapus --}}
    @foreach ($DaftarNilaiKebutuhan as $h)
        <div class="modal fade" id="ModalHapusBarang{{ $h->ID_SD }}" tabindex="-1" role="dialog"
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

                        <input type="hidden" value="{{ $h->ID_SD }}" name="id" required>
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
