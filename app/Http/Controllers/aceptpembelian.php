<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class aceptpembelian extends Controller
{

    public function TampilPersetujuanPembelian(Request $request){
        $data = DB::table('pembelian')
        ->select('ID_PEMESANAN', 'TANGGAL_PEMBELIAN','ACC')
        ->groupBy('ID_PEMESANAN','TANGGAL_PEMBELIAN','ACC')
        ->orderBy('ID_PEMESANAN', 'DESC')
        ->get();

        $dataBarang = DB::table('pembelian as pb')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'pb.ID_BARANG')
            ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ba.ID_SUPPLIER')
            ->get();

        // dd($data);
        return View('pemilik/acept', [
            'countData' => $data,
            'dataBarang' => $dataBarang
        ]);
    }

    public function TampilDetilPersetujuanPembelian($id)
    {
        $data = DB::select("SELECT pb.ID_PEMBELIAN, br.NAMA_BARANG, sp.NAMA_SUPPLIER, br.STOCK_BARANG, pb.TANGGAL_PEMBELIAN, pb.JML_PESAN as NILAI_EOQ, pb.ID_PEMESANAN, CASE WHEN SUM(ms.JML_BARANG_MSK) IS NULL THEN 0 ELSE SUM(ms.JML_BARANG_MSK) END AS JML_DITERIMA, pb.ACC FROM `pembelian` pb LEFT JOIN masuk ms ON ms.ID_PEMESANAN = pb.ID_PEMESANAN AND ms.ID_BARANG = pb.ID_BARANG JOIN barang br ON br.ID_BARANG = pb.ID_BARANG JOIN supplier sp ON sp.ID_SUPPLIER = br.ID_SUPPLIER JOIN eoq ON eoq.ID_BARANG = pb.ID_BARANG WHERE eoq.STATUS_EOQ = 1 AND pb.TANGGAL_PEMBELIAN = '$id' GROUP BY pb.ID_PEMBELIAN, br.NAMA_BARANG, sp.NAMA_SUPPLIER, br.STOCK_BARANG, pb.TANGGAL_PEMBELIAN, pb.JML_PESAN, pb.ID_BARANG, pb.ACC, pb.ID_PEMESANAN");
        // dd($data);
        return View('pemilik/detailacept')
            ->with('data', $data);
    }

    public function TambahPersetujuan(Request $request){
        $id = $request->input('id');
        $nilai = $request->input('nilai');
        for ($i=0; $i < count($id); $i++) {
            $data = [
                'JML_PESAN' => $nilai[$i],
                'ACC' => 1
            ];
            DB::table('pembelian')->where('ID_PEMBELIAN', '=', $id[$i])->update($data);
        }
        Alert::success('Data Pembelian Yang Telah Diajukan ', 'Telah Disetujui');
        return Redirect::back();

    }

}
