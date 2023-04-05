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
                                                <th>Jumlah Pesanan</th>
                                                <th>Jumlah Barang Diterima</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if (!empty($data))
                                                @foreach ($data as $item)
                                                    <tr>
                                                        <td>{{ $item->NAMA_BARANG }}</td>
                                                        <td>{{ $item->NAMA_SUPPLIER }}</td>
                                                        <td>{{ $item->NILAI_EOQ }}</td>
                                                        <td>{{ $item->JML_DITERIMA }}</td>
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

                                <div class="btn-export mt-3">
                                    <a href="/pdf-detailpembelian/{{ $data[0]->TANGGAL_PEMBELIAN }}"
                                        class="btn btn-block btn-primary">Cetak Barang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
