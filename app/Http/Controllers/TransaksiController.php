<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class TransaksiController extends Controller
{

    public function ProsesTransaksiBarangMasukTambah(Request $request)
    {

        $data = array(
            'ID_BARANG' => $request->input('barang'),
            'ID_SUPPLIER' => $request->input('supplier'),
            'ID_KAR' => $request->input('karyawan'),
            'ID_PEMESANAN' => $request->input('id_pemesanan'),
            'TANGGAL_MASUK' => $request->input('tgl_masuk'),
            'JML_BARANG_MSK' => $request->input('jml_masuk'),
            'HARGA_BARANG_MASUK' => $request->input('hrg_masuk'),

        );

        //cek jml barang masuk & jml pesanan
        $cek_jmlbarang_masuk = DB::table('masuk')
            ->select(DB::raw('SUM(JML_BARANG_MSK) JML_BARANG_MSK'))
            ->where('ID_PEMESANAN', $request->input('id_pemesanan'))
            ->where('ID_BARANG', $request->input('barang'))
            ->groupBy('ID_BARANG', 'ID_PEMESANAN')
            ->first();

        if($cek_jmlbarang_masuk === null){
            $cek_jmlbarang_masuk = (object) array('JML_BARANG_MSK'=>0);
        }

        $cek_jmlbarang_pembelian = DB::table('pembelian')
            ->select('JML_PESAN')
            ->where('ID_PEMESANAN', $request->input('id_pemesanan'))
            ->where('ID_BARANG', $request->input('barang'))
            ->where('STATUS', 0)
            ->first();

        $pengurangan_jmlbarang = $cek_jmlbarang_pembelian->JML_PESAN - $cek_jmlbarang_masuk->JML_BARANG_MSK - $request->input('jml_masuk');

        if($pengurangan_jmlbarang == 0){
            $status_selesai = array('STATUS' => 1);
            DB::table('pembelian')
            ->where('ID_PEMESANAN', $request->input('id_pemesanan'))
            ->where('ID_BARANG', $request->input('barang'))
            ->where('STATUS', 0)
            ->update($status_selesai);
        }

        //akhir cek jml barang masuk & jml pesanan

        $data1 = $request->input('jml_masuk');

        $data2 = DB::table('barang')
        ->select('STOCK_BARANG')
        ->where('ID_BARANG', '=', $request->input('barang'))
        ->first();

        $data3 = array(
          'STOCK_BARANG' =>  $data2->STOCK_BARANG + $data1
        );


        DB::table('masuk')->insert($data);
        DB::table('barang')->where('ID_BARANG', '=', $request->input('barang') )->update($data3);
        Alert::success('Data Barang Masuk', 'Data Berhasil Ditambahkan');
        return Redirect::to('transaksibarangmasuk');
    }

    public function ProsesTransaksiBarangMasukHapus(Request $request)
    {
        DB::table('masuk')->where('ID_MASUK', '=', $request->input('id'))->delete();
        Alert::success('Data Barang Masuk', 'Data Berhasil Dihapus');
        return Redirect::to('transaksitambahbarangmasuk');
    }

    public function ProsesTransaksiBarangKeluarTambah(Request $request)
    {

        $barangKeluar = $request->input('barangKeluar');
        $barangPending = $request->input('barangPending');

        $data2 = DB::table('barang')
        ->select('STOCK_BARANG')
        ->where('ID_BARANG', '=', $request->input('barang'))
        ->first();

        $data = array(
            'TGL_INFORMASI' => Carbon::now()->format('Y-m-d')
        );

        //insert data
        $last_id = DB::table('keluar')->insertGetId($data);

        $sts_pending = $request->input('pending');

        if($sts_pending == 1){
            $data_detailPending = array(
                'ID_BARANG' => $request->input('barang'),
                'ID_KELUAR' => $last_id,
                'ID_KAR' => $request->input('karyawan'),
                'TANGGAL_KELUAR' => $request->input('tgl_keluar'),
                'JML_UNIT' => $barangPending,
                'HARGA_BARANG_KELUAR' => $request->input('harga_keluar'),
                'KET_KELUAR' => $request->input('keterangan'),
                'STATUS_PENDING' => 1
            );
            $data_detailKeluar = array(
                'ID_BARANG' => $request->input('barang'),
                'ID_KELUAR' => $last_id,
                'ID_KAR' => $request->input('karyawan'),
                'TANGGAL_KELUAR' => $request->input('tgl_keluar'),
                'JML_UNIT' => $barangKeluar,
                'HARGA_BARANG_KELUAR' => $request->input('harga_keluar'),
                'KET_KELUAR' => $request->input('keterangan'),
                'STATUS_PENDING' => 0
            );
            DB::table('detail_keluar')->insert($data_detailPending);
            DB::table('detail_keluar')->insert($data_detailKeluar);
        } else {
            $data_detailKeluar = array(
                'ID_BARANG' => $request->input('barang'),
                'ID_KELUAR' => $last_id,
                'ID_KAR' => $request->input('karyawan'),
                'TANGGAL_KELUAR' => $request->input('tgl_keluar'),
                'JML_UNIT' => $barangKeluar,
                'HARGA_BARANG_KELUAR' => $request->input('harga_keluar'),
                'KET_KELUAR' => $request->input('keterangan'),
                'STATUS_PENDING' => 0
            );
            DB::table('detail_keluar')->insert($data_detailKeluar);
        }

        $data3 = array(
            'STOCK_BARANG' =>  $data2->STOCK_BARANG - $barangKeluar
        );
        //pengurangan stok data
        DB::table('barang')->where('ID_BARANG', '=', $request->input('barang') )->update($data3);

        Alert::success('Data Barang Keluar', 'Data Berhasil Ditambahkan');
        return Redirect::to('transaksibarangkeluar');
    }

    public function ProsesTransaksiBarangKeluarHapus(Request $request)
    {
        DB::table('keluar')->where('ID_KELUAR', '=', $request->input('id'))->delete();
        Alert::success('Data Barang Keluar', 'Data Berhasil Dihapus');
        return Redirect::to('transaksibarangkeluar');
    }

    public function TampilBarangPending(Request $request)
    {
        $data = DB::table('detail_keluar as kl')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'kl.ID_BARANG')
            ->join('karyawan as ka', 'ka.ID_KAR', '=', 'kl.ID_KAR')
            ->where('STATUS_PENDING', 1)
            ->get();

        $data1 = DB::table('barang')
            ->get();
        $data2 = DB::table('karyawan')
            ->get();

        return View('gudang/transaksipending/pending')
            ->with('DaftarBarangKeluar', $data);
    }

    public function ProsesUpdatePending (Request $request){
        $data = DB::table('detail_keluar')
            ->where('ID_DETILKEL', $request->input('id'))
            ->first();

        $stok_barang = DB::table('barang')
            ->where('ID_BARANG', $data->ID_BARANG)
            ->first();

        $stok_akhir = $stok_barang->STOCK_BARANG - $data->JML_UNIT;

        $updated_detail_keluar = array(
            'STATUS_PENDING' => 0,
            'TANGGAL_KELUAR' => Carbon::now()->format('Y-m-d')
        );

        $updated_stok_barang = array(
            'STOCK_BARANG' => $stok_akhir
        );

        DB::table('detail_keluar')->where('ID_DETILKEL', $request->input('id'))->update($updated_detail_keluar);
        DB::table('barang')->where('ID_BARANG', $data->ID_BARANG)->update($updated_stok_barang);
        Alert::success('Data Transaksi Pending', 'Data Berhasil Diupdate');
        return redirect('transaksibarangpending');
    }
}
