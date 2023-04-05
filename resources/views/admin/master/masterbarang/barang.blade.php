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
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Data Master Barang</h4>
                                    <button class="btn btn-primary btn-round ml-auto" data-toggle="modal"
                                        data-target="#ModalTambahBarang">
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
                                                <th>Nama Barang</th>
                                                <th>Kategori Barang</th>
                                                <th>Harga Barang</th>
                                                <th>Stock Barang</th>
                                                <th>Safety Stock</th>
                                                <th>Informasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($DaftarBarang as $item)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td>{{ $item->NAMA_BARANG }}</td>
                                                    <td>{{ $item->NAMA_KATEGORI }}</td>

                                                    <td> @php   echo "Rp " . number_format( $item->HARGA_BARANG ,2,',','.');;  @endphp </td>

                                                    @if ($item->STOCK_BARANG == 0)
                                                        <td>Stock Kosong</td>
                                                    @else
                                                        <td>{{ $item->STOCK_BARANG }} Unit</td>
                                                    @endif
                                                    @if($item->NILAI_SS)
                                                        <td>{{ $item->NILAI_SS }} Unit</td>
                                                    @else
                                                        <td>T/A</td>
                                                    @endif
                                                    <td style="text-align: center;">
                                                    @if ($item->STOCK_BARANG < $item->NILAI_SS && $item->STOCK_BARANG < $item->NILAI_ROP )
                                                        <span class="badge badge-danger w-75">Stock Habis</span>

                                                    @elseif ($item->STOCK_BARANG < $item->NILAI_ROP )
                                                    <span class="badge badge-warning w-75">Nilai Dibawah ROP</span>
                                                    @elseif($item->NILAI_SS == null || $item->NILAI_ROP == null)
                                                    <span class="badge badge-secondary w-75">Variabel Kosong</span>
                                                    @else
                                                    <span class="badge badge-success w-75">Stock Aman</span>
                                                    @endif
                                                </td>




                                                    <td>
                                                        <a href="#ModalEditBarang{{ $item->ID_BARANG }}" data-toggle="modal"
                                                            class="btn btn-primary btn-xs"> <i class="fa fa-edit">
                                                                Edit</i></a>
                                                        {{-- <a href="#ModalHapusBarang{{ $item->ID_BARANG }}"
                                                            data-toggle="modal" class="btn btn-danger btn-xs"> <i
                                                                class="fa fa-trash"> Hapus</i></a> --}}
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
    <div class="modal fade" id="ModalTambahBarang" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {{-- Judul Modal --}}

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Isi Modal --}}

                <div class="modal-body">
                    {!! Form::open(['url' => '/TambahBarang', 'enctype' => 'multipart/form-data']) !!}

                    @csrf

                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Barang"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Kategori Barang</label>
                        <select class="form-control" name="kategori" required>
                            <option value="" hidden>---- Pilih Kategori ----</option>

                            @foreach ($DaftarKategori as $dk)
                                <option value="{{ $dk->ID_KATEGORI }}">{{ $dk->NAMA_KATEGORI }}</option>
                            @endforeach

                        </select>

                    </div>
                    <div class="form-group">
                        <label>Harga Barang</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                            </div>
                            <input type="number" class="form-control" name="harga" placeholder="Harga Barang" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Stock Barang</label>
                        <br>
                        <button id="bt1" type="button" class="btn btn-default"><span class="btn-label"><i
                                    class="fa fa-archive"></i></span>
                            Tanpa Stok
                        </button>
                        <button id="bt2" type="button" class="btn btn-secondary"> <span class="btn-label"> <i
                                    class="fa fa-plus"></i> </span>
                            Dengan Stok
                        </button>

                        <input id="inputstock" type="number" class="form-control" name="stock"
                            placeholder="Masukkan Stock" style='display: none; margin-top: 10px' value="0"
                            min="0" required>
                        <script>
                            document.getElementById("bt2").onclick = function() {
                                document.getElementById('inputstock').style.display = '';
                                document.getElementById("bt2").style.display = 'none';
                            }
                            document.getElementById("bt1").onclick = function() {
                                document.getElementById('inputstock').value = '0';
                                document.getElementById('inputstock').style.display = 'none';
                                document.getElementById("bt2").style.display = '';
                            }
                        </script>
                    </div>
                    <div class="form-group">
                        <label>Supplier Barang</label>
                        <select class="form-control" name="supplier" required>
                            <option value="" hidden>---- Pilih Supplier ----</option>

                            @foreach ($DaftarSupplier as $ds)
                                <option value="{{ $ds->ID_SUPPLIER }}">{{ $ds->NAMA_SUPPLIER }}</option>
                            @endforeach

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
    @foreach ($DaftarBarang as $u)
        <div class="modal fade" id="ModalEditBarang{{ $u->ID_BARANG }}" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    {{-- Judul Modal --}}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Data Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    {{-- Isi Modal --}}

                    <div class="modal-body">
                        {!! Form::open(['url' => '/EditBarang', 'enctype' => 'multipart/form-data']) !!}

                        @csrf

                        <input type="hidden" value="{{ $u->ID_BARANG }}" name="id" required>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" value="{{ $u->NAMA_BARANG }}" name="nama"
                                placeholder="Masukkan Nama" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori Barang</label>
                            <select class="form-control" name="kategori">
                                @foreach ($DaftarKategori as $dk)
                                    <option value="{{ $dk->ID_KATEGORI }}">{{ $dk->NAMA_KATEGORI }}</option>
                                @endforeach

                            </select>

                        </div>
                        <div class="form-group">
                            <label>Harga Barang</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                </div>
                                <input type="number" class="form-control" value="{{ $u->HARGA_BARANG }}"
                                    name="harga" placeholder="Harga Barang" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Supplier Barang</label>
                            <select class="form-control" name="supplier">

                                @foreach ($DaftarSupplier as $ds)
                                    <option value="{{ $ds->ID_SUPPLIER }}">{{ $ds->NAMA_SUPPLIER }}</option>
                                @endforeach

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
    @foreach ($DaftarBarang as $h)
        <div class="modal fade" id="ModalHapusBarang{{ $h->ID_BARANG }}" tabindex="-1" role="dialog"
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

                        <input type="hidden" value="{{ $h->ID_BARANG }}" name="id" required>
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
