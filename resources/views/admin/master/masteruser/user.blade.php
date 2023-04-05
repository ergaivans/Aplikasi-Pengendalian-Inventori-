@extends('layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Data Master Karyawan</h4>
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
                            <a href="#">Master Karyawan</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Daftar Master Karyawan</a>
                        </li>
                    </ul>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Data Master Karyawan</h4>
                                    <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#ModalTambahUser">
                                        <i class="fa fa-plus"></i>
                                        Tambah Karyawan
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Jabatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($DaftarKaryawan as $item)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td>{{ $item->NAMA_KAR }}</td>
                                                    <td>{{ $item->EMAIL }}</td>
                                                    <td>{{ $item->TGL_LAHIR_KAR }}</td>

                                                    @if ($item->JABATAN == 0)
                                                        <td> Bagian Gudang </td>
                                                    @elseif ($item->JABATAN == 1)
                                                        <td> Bagian Administrasi </td>
                                                    @else
                                                        <td> Pemilik </td>
                                                    @endif

                                                    <td>
                                                        <a href="#ModalEditUser{{ $item->ID_KAR }}" data-toggle="modal" class="btn btn-primary btn-xs"> <i class="fa fa-edit"> Edit</i></a>
                                                        <a href="#ModalHapusUser{{ $item->ID_KAR }}" data-toggle="modal" class="btn btn-danger btn-xs"> <i class="fa fa-trash"> Hapus</i></a>
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
    <div class="modal fade" id="ModalTambahUser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {{-- Judul Modal --}}

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Isi Modal --}}

                <div class="modal-body">
                    {!! Form::open(['url' => '/TambahKaryawan', 'enctype'=>'multipart/form-data']) !!}

                    @csrf

                    <div class="form-group">
                        <label >Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama" required>
                    </div>
                    <div class="form-group">
                        <label >Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Masukkan Email" required >
                    </div>
                    <div class="form-group">
                        <label >Kata Sandi</label>
                        <input type="password" class="form-control" name="password" placeholder="Masukkan Kata Sandi" required>
                    </div>
                    <div class="form-group">
                        <label >Alamat</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan Alamat" required>
                    </div>
                    <div class="form-group">
                        <label >Nomor Tlp</label>
                        <input type="text" class="form-control" name="no_tlp" placeholder="Masukkan No Tlp" required>
                    </div>
                    <div class="form-group">
                        <label >Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir" placeholder="Masukkan Tanggal Lahir" required>
                    </div>
                    <div class="form-group">
                        <label >Jabatan</label>
                        <select class="form-control" name="jabatan" required>
                            <option value="" hidden>---- Pilih Jabatan ----</option>
                            <option value="2">Pemilik</option>
                            <option value="1">Bagian Administrasi</option>
                            <option value="0">Bagian Gudang</option>
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

    {{-- Modal Update --}}
    @foreach ($DaftarKaryawan as $u)
    <div class="modal fade" id="ModalEditUser{{$u->ID_KAR}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {{-- Judul Modal --}}

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Isi Modal --}}

                <div class="modal-body">
                    {!! Form::open(['url' => '/EditKaryawan', 'enctype'=>'multipart/form-data']) !!}

                    @csrf

                    <input type="hidden" value="{{$u->ID_KAR}}"  name="id" required>
                    <div class="form-group">
                        <label >Nama</label>
                        <input type="text" value="{{$u->NAMA_KAR}}" class="form-control" name="nama" placeholder="Masukkan Nama" required>
                    </div>
                    <div class="form-group">
                        <label >Email</label>
                        <input type="text" value="{{$u->EMAIL}}" class="form-control" name="email" placeholder="Masukkan Email" required > </div>

                        <div class="form-group">
                        <label >Kata Sandi</label>
                        <div>

                        </div>
                        <input type="password" value="{{$u->PASSWORD}}" class="form-control" name="password" placeholder="Masukkan Kata Sandi" required><div class="show-password">
                            <i class="flaticon-interface"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label >Alamat</label>
                        <input type="text" value="{{$u->ALAMAT_KAR}}" class="form-control" name="alamat" placeholder="Masukkan Alamat" required>
                    </div>
                    <div class="form-group">
                        <label >Nomor Tlp</label>
                        <input type="text" value="{{$u->TLP_KAR}}" class="form-control" name="no_tlp" placeholder="Masukkan No Tlp" required>
                    </div>
                    <div class="form-group">
                        <label >Tanggal Lahir</label>
                        <input type="date" value="{{$u->TGL_LAHIR_KAR}}" class="form-control" name="tgl_lahir" placeholder="Masukkan Tanggal Lahir" required>
                    </div>
                    <div class="form-group">
                        <label >Jabatan</label>
                        <select class="form-control" name="jabatan" required>
                            <option @php  if ($u->JABATAN == 2 ) echo "cheked";  @endphp  value="2">Pemilik</option>
                            <option @php  if ($u->JABATAN == 1 ) echo "cheked";   @endphp  value="1">Bagian Administrasi</option>
                            <option @php  if ($u->JABATAN == 0 ) echo "cheked";  @endphp  value="0">Bagian Gudang</option>
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
    @endforeach

    {{-- ModalHapus --}}
    @foreach ($DaftarKaryawan as $h)
    <div class="modal fade" id="ModalHapusUser{{$h->ID_KAR}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {{-- Judul Modal --}}

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Isi Modal --}}

                <div class="modal-body">
                    {!! Form::open(['url' => '/HapusKaryawan', 'enctype'=>'multipart/form-data']) !!}

                    @csrf

                    <input type="hidden" value="{{$h->ID_KAR}}"  name="id" required>
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
