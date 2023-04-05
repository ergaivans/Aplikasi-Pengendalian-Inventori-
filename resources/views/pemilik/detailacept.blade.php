@extends('layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header row">
                    <div class="col-10">
                        <h4 class="page-title">Daftar Pembelian Barang</h4>

                    </div>
                    <div class="col flo">
                        <p><b>{{ Session::get('user')[1] }}</b></p>
                        <p><b>Tanggal : {{  Carbon\Carbon::parse($data[0]->TANGGAL_PEMBELIAN)->format('d / M / Y') }}</b></p>
                        <p><b>ID Pembelian : {{ $data[0]->ID_PEMESANAN }}</b></p>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Nama Supplier</th>
                                                <th style="width: 25%;">Jumlah Pesanan</th>
                                                {{-- <th>Jumlah Barang Diterima</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($data))
                                                @foreach ($data as $index => $item)
                                                    <tr>
                                                        <td>{{ $item->NAMA_BARANG }}</td>
                                                        <td>{{ $item->NAMA_SUPPLIER }}</td>

                                                        <td>
                                                            <div class="input-group">
                                                                <input type="number" min="1" class="form-control" data-id="{{ $item->ID_PEMBELIAN }}" onchange="gantiNilai(this)" value="{{ $item->NILAI_EOQ }}" required @if($item->ACC == 1) disabled @endif>
                                                                <span class="input-group-text">Unit</span>
                                                            </div>
                                                        </td>
                                                        {{-- <td>{{ $item->NILAI_EOQ }}</td> --}}
                                                        {{-- <td>{{ $item->JML_DITERIMA }}</td> --}}
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>Data Kosong</td>
                                                </tr>
                                            @endif


                                        </tbody>
                                    </table>
                                </div>

                                {!! Form::open(['method'=>'POST']) !!}
                                <div class="btn-export mt-3">
                                    @foreach ($data as $index => $item)
                                    <input type="hidden" name="nama[]" value="{{$item->NAMA_BARANG}}" required>
                                    <input type="hidden" name="id[]" value="{{$item->ID_PEMBELIAN}}" required>
                                    <input type="hidden" min="1" class="form-control" name="nilai[]" id="val{{$item->ID_PEMBELIAN}}" value="{{ $item->NILAI_EOQ }}" required>
                                    @endforeach
                                    <input type="submit" class="btn btn-block btn-success" value="Setuju Dengan Daftar Rencana Pembelian" @if($item->ACC == 1) style="display: none;" @endif>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function gantiNilai(elm){
            let id = parseInt(elm.getAttribute('data-id'));
            let value = parseInt(elm.value);
            document.getElementById('val'+id).value = value;
        }
    </script>
@endsection
