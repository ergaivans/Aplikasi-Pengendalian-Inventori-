@extends('layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Data Safety Stock</h4>
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
                            <a href="#">Safety Stock</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Daftar Data Safety Stock</a>
                        </li>
                    </ul>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Data Safety Stock Barang</h4>
                                    <a class="btn btn-primary btn-round ml-auto" href="tambahsafetystock">
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
                                                <th>Nilai Safety Stock</th>
                                                <th>Status</th>
                                                {{-- <th>Aksi</th> --}}
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($DataSafetyStock as $item)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td>{{ $item->NAMA_BARANG }}</td>
                                                    <td>{{ Carbon\Carbon::parse($item->TANGGAL_SS)->format('d / M / Y') }}</td>
                                                    <td>{{ $item->NILAI_SS }} Unit</td>
                                                   {{-- <td>@php echo date_format( $item->TANGGAL_MASUK," %D %M %Y ") @endphp</td> --}}
                                                   @if ($item->STATUS_SS == 0  )
                                                   <td><button class="btn btn-secondary">Non-Aktif</button></td>
                                                   @else
                                                   <td><button class="btn btn-warning">Aktif</button></td>
                                                   @endif


                                                    {{-- <td>
                                                        <a href="#ModalHapusSafetyStock{{ $item->ID_SS }}"
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
    @foreach ($DataSafetyStock as $h)
    <div class="modal fade" id="ModalHapusSafetyStock{{$h->ID_SS}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    {!! Form::open(['url' => '/HapusDataSafetyStock', 'enctype'=>'multipart/form-data']) !!}

                    @csrf

                    <input type="hidden" value="{{$h->ID_SS}}"  name="id" required>
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
