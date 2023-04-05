<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Svg\Tag\Rect;

class HomeController extends Controller
{

    public function dashboard()
    {
        $barangMasuk = DB::table('masuk as ms')
            ->select('ba.NAMA_BARANG', DB::raw('CAST(SUM(ms.JML_BARANG_MSK) as INT) as JML_BARANG_MSK'))
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'ms.ID_BARANG')
            ->join('karyawan as ka', 'ka.ID_KAR', '=', 'ms.ID_KAR')
            ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ms.ID_SUPPLIER')
            ->where(DB::raw('DATE_FORMAT(ms.TANGGAL_MASUK, "%Y-%m")'), date("Y-m"))
            ->groupBy('ba.NAMA_BARANG')
            ->orderBy(DB::raw('SUM(ms.JML_BARANG_MSK)'), 'desc')
            ->get();
        //dd($barangMasuk);
        $a = [];
        foreach ($barangMasuk as $data) {

            array_push($a, $data->JML_BARANG_MSK);
        }
        // dd($a);
        $c = [];
        foreach ($barangMasuk as $data) {
            $x['NAMA_BARANG'] = $data->NAMA_BARANG;

            array_push($c, $data->NAMA_BARANG);
        }


        $barangKeluar = DB::table('detail_keluar as kl')
            ->select('ba.NAMA_BARANG', DB::raw('CAST(SUM(kl.JML_UNIT) as INT) as JML_KELUAR'))
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'kl.ID_BARANG')
            ->join('karyawan as ka', 'ka.ID_KAR', '=', 'kl.ID_KAR')
            ->where(DB::raw('DATE_FORMAT(kl.TANGGAL_KELUAR, "%Y-%m")'), date("Y-m"))
            ->where('STATUS_PENDING', 0)
            ->groupBy('ba.NAMA_BARANG')
            ->orderBy(DB::raw('SUM(kl.JML_UNIT)'), 'desc')
            ->get();

        $b = [];
        foreach ($barangKeluar as $data) {
            $x['JML_KELUAR'] = $data->JML_KELUAR;

            array_push($b, $data->JML_KELUAR);
        }

        $dataKurang = DB::table('barang as br')
            ->join('rop as rp', 'rp.ID_BARANG', '=', 'br.ID_BARANG')
            ->where('rp.STATUS_ROP', 1)
            ->get();
        // dd($dataKurang);

        // foreach ($dataKurang as $item) {
        //     dd($item->NAMA_BARANG);
        //     if ($item->STOCK_BARANG < $item->NILAI_ROP) {
        //         toast('Stock ' . $item->NAMA_BARANG . ' Kurang dari rop', 'warning');
        //     }
        // }

        return view('admin.dashboard', [
            'barangMasuk'   => $a,
            'barangKeluar'  => $b,
            'namaBarang' => $c,
            'dataKurang' => $dataKurang
        ]);
    }

    public function tampilanawal(Request $request)
    {
        return View('home')->with('success', 'Login Berhasil');
    }

    public function TampilMasterKaryawan(Request $request)
    {
        $data = DB::table('karyawan')->get();
        return View('admin/master/masteruser/user')->with('DaftarKaryawan', $data);
    }

    public function TampilMasterSupplier(Request $request)
    {
        $data = DB::table('supplier')->get();
        return View('admin/master/mastersupplier/supplier')->with('DaftarSupplier', $data);
    }
    public function TampilMasterKategori(Request $request)
    {
        $data = DB::table('kategori')->get();
        return View('admin/master/masterkategori/kategori')->with('DaftarKategori', $data);
    }

    public function TampilMasterFactor(Request $request)
    {
        $data = DB::table('safety_factor as sf')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'sf.ID_BARANG')
            ->get();
        $data1 = DB::table('barang')
            ->get();
        $data2 = DB::table('safety_factor')
            ->get();
        return View('admin/master/mastersafety/factor')
            ->with('DaftarFactor', $data)
            ->with('DaftarBarang', $data1)
            ->with('DaftarCek', $data2);
    }

    public function TampilMasterOperasi(Request $request)
    {
        $data = DB::table('operasi as op')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'op.ID_BARANG')
            ->where('op.STATUS_OP', '=', 1)
            ->get();
        $data1 = DB::table('barang')
            ->get();
        return View('admin/master/masteroperasi/operasi')
            ->with('DaftarOperasi', $data)
            ->with('DaftarBarang', $data1);
    }

    public function TampilMasterBarang(Request $request)
    {
        $exclude = DB::table('barang as ba')
        ->select('ba.ID_BARANG', 'sp.ID_SUPPLIER', 'ka.ID_KATEGORI', 'NAMA_BARANG', 'HARGA_BARANG', 'STOCK_BARANG', 'NAMA_KATEGORI', 'NAMA_SUPPLIER', 'ALAMAT_SUPPLIER', 'TLP_SUPPLIER', 'KOTA_SUPPLIER', 'ID_SS', 'TANGGAL_SS', 'NILAI_SS', 'STATUS_SS', 'ID_ROP', 'TANGGAL_ROP', 'NILAI_ROP', 'STATUS_ROP')
            ->join('kategori as ka', 'ka.ID_KATEGORI', '=', 'ba.ID_KATEGORI')
            ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ba.ID_SUPPLIER')
            ->leftJoin('safety_stock as ss', 'ss.ID_BARANG', '=', 'ba.ID_BARANG')
            ->leftJoin('rop as rp', 'rp.ID_BARANG', '=', 'ba.ID_BARANG')
            ->where('ss.STATUS_SS', 1)
            ->where('rp.STATUS_ROP', 1);

        $not_in = [];

        foreach ($exclude->get() as $temp) {
            array_push($not_in, $temp->ID_BARANG);
        }


        $data = DB::table('barang as ba')
        ->select('ba.ID_BARANG', 'sp.ID_SUPPLIER', 'ka.ID_KATEGORI', 'NAMA_BARANG', 'HARGA_BARANG', 'STOCK_BARANG', 'NAMA_KATEGORI', 'NAMA_SUPPLIER', 'ALAMAT_SUPPLIER', 'TLP_SUPPLIER', 'KOTA_SUPPLIER', 'ID_SS', 'TANGGAL_SS', 'NILAI_SS', 'STATUS_SS', 'ID_ROP', 'TANGGAL_ROP', 'NILAI_ROP', 'STATUS_ROP')
            ->join('kategori as ka', 'ka.ID_KATEGORI', '=', 'ba.ID_KATEGORI')
            ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ba.ID_SUPPLIER')
            ->leftJoin('safety_stock as ss', 'ss.ID_BARANG', '=', 'ba.ID_BARANG')
            ->leftJoin('rop as rp', 'rp.ID_BARANG', '=', 'ba.ID_BARANG')
            ->whereNotIn('ba.ID_BARANG', $not_in)
            ->union($exclude)
            ->orderBy('ID_BARANG')
            ->get();

            // dd($data);

        $data1 = DB::table('kategori')
            ->get();
        $data2 = DB::table('supplier')
            ->get();

        return View('admin/master/masterbarang/barang')
            ->with('DaftarBarang', $data)
            ->with('DaftarKategori', $data1)
            ->with('DaftarSupplier', $data2);
    }

    public function pdfBarangRop()
    {
        $data = DB::table('rop as rp')
            ->select('rp.ID_ROP', 'ss.ID_BARANG', 'ss.NAMA_BARANG', 'ss.HARGA_BARANG', 'eq.NILAI_EOQ', 'ss.STOCK_BARANG', 'rp.NILAI_ROP', 'sp.NAMA_SUPPLIER')
            ->join('barang as ss', 'rp.ID_BARANG', '=', 'ss.ID_BARANG')
            ->join('eoq as eq', 'eq.ID_BARANG', '=', 'ss.ID_BARANG')
            ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ss.ID_SUPPLIER')
            ->where('rp.STATUS_ROP', 1)
            ->where('eq.STATUS_EOQ', 1)
            ->groupBy('rp.ID_ROP', 'ss.ID_BARANG', 'ss.NAMA_BARANG', 'ss.HARGA_BARANG', 'ss.STOCK_BARANG', 'rp.NILAI_ROP', 'eq.NILAI_EOQ', 'sp.NAMA_SUPPLIER')
            ->get();
        // dd($data);

        // $pdf = PDF::loadView('gudang/operasibarang/databarangrop/pdf', [
        //     'DataBarangRop' => $data
        // ])->setPaper('a4', 'landscape');

        //dd($data);

        $jumlah_row = DB::table('pembelian')->select(DB::raw('COUNT(*) as JML'))->first();
        if ($jumlah_row->JML == 0) {
            $id_kategori = (object) array('MAX_ID_NUMBER' => 'KP_001');
        } else {
            $id_t = 0;
            $id = DB::table('pembelian')
                ->select(DB::raw('CONVERT(SUBSTRING(ID_PEMESANAN, 4), DECIMAL) AS ID_TIPE'))
                ->orderBy(DB::raw('CONVERT(SUBSTRING(ID_PEMESANAN, 4), DECIMAL)'), 'desc')
                ->first();
            for ($i = 1; $i <= ($id->ID_TIPE + 1); $i++) {
                $id_t++;
                $idb = DB::table('pembelian')
                    ->select(DB::raw('count(CONVERT(SUBSTRING(ID_PEMESANAN, 4), DECIMAL)) as jumlah'))
                    ->where(DB::raw('CONVERT(SUBSTRING(ID_PEMESANAN, 4), DECIMAL)'), '=', $id_t)
                    ->first();
                if ($idb->jumlah == 0) {
                    $i = $id->ID_TIPE + 1;
                }
            }
            $id_kategori = DB::table('pembelian')->select(DB::raw('CONCAT("KP_", LPAD(' . $id_t . ', 3, "0")) AS MAX_ID_NUMBER'))->first();
        }

        //dd($data);

        foreach ($data as $q) {
                if($q->STOCK_BARANG < $q->NILAI_ROP){
                    $insertToDB = array(
                        'ID_BARANG' => $q->ID_BARANG,
                        // 'TANGGAL_PEMBELIAN' => $q->TANGGAL_ROP,
                        'ID_PEMESANAN' => $id_kategori->MAX_ID_NUMBER,
                        'JML_PESAN' => $q->NILAI_EOQ,
                        'STATUS' => 0,
                        'TANGGAL_PEMBELIAN' => date('d-m-Y H:i:s'),
                    );
                    DB::table('pembelian')->insert($insertToDB);
                }
        }

        // return $pdf->download('Laporan-transaksi-barang-rop.pdf');
        return View('gudang/operasibarang/databarangrop/pdf', ['DataBarangRop' => $data]);
    }

    public function pdf()
    {
        $data = DB::table('barang as ss')
            ->select('ss.ID_BARANG', 'ss.NAMA_BARANG', 'ss.HARGA_BARANG', 'st.NILAI_SS', 'ss.STOCK_BARANG', 'rp.NILAI_ROP', 'sp.NAMA_SUPPLIER')
            ->join('rop as rp', 'rp.ID_BARANG', '=', 'ss.ID_BARANG')
            ->join('safety_stock as st', 'st.ID_BARANG', '=', 'ss.ID_BARANG')
            ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ss.ID_SUPPLIER')
            ->where('rp.STATUS_ROP', '=', '1')
            ->groupBy('ss.ID_BARANG', 'ss.NAMA_BARANG', 'ss.HARGA_BARANG', 'ss.STOCK_BARANG', 'rp.NILAI_ROP', 'st.NILAI_SS', 'sp.NAMA_SUPPLIER')
            ->get();


        return view('gudang/operasibarang/databarangrop/pdf', [
            'DataBarangRop' => $data
        ]);
    }

    public function exportBarangMasuk(Request $request)
    {
        $fromDate = $request->get('fromFilterDate');
        $toDate = $request->get('toFilterDate');
        $namaBarang = $request->get('namaBarang');

        $data = DB::table('masuk as ms')
            ->select('ba.NAMA_BARANG', 'sp.NAMA_SUPPLIER', 'ms.TANGGAL_MASUK', 'pb.ID_PEMESANAN', 'ms.JML_BARANG_MSK', 'ms.HARGA_BARANG_MASUK', 'ms.ID_MASUK', 'pb.TANGGAL_PEMBELIAN', 'ka.NAMA_KAR')
            ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ms.ID_SUPPLIER')
            ->join('pembelian as pb', 'ms.ID_PEMESANAN', '=', 'pb.ID_PEMESANAN')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'ms.ID_BARANG')
            ->join('karyawan as ka', 'ka.ID_KAR', '=', 'ms.ID_KAR')
            ->where('ba.NAMA_BARANG', 'like', '%' . $namaBarang . '%')
            ->whereBetween('ms.TANGGAL_MASUK', [$fromDate, $toDate])
            ->groupBy('ba.NAMA_BARANG', 'sp.NAMA_SUPPLIER', 'ms.TANGGAL_MASUK', 'pb.ID_PEMESANAN', 'ms.JML_BARANG_MSK', 'ms.HARGA_BARANG_MASUK', 'ms.ID_MASUK', 'pb.TANGGAL_PEMBELIAN', 'ka.NAMA_KAR')
            ->get();

        // dd($data);

        return View('gudang/transaksimasuk/filter', [
            'DaftarBarangMasuk' => $data,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'namaBarang' => $namaBarang
        ]);
    }

    public function exportBarangMasukLaporan(Request $request)
    {
        $fromDate = $request->get('fromFilterDate');
        $toDate = $request->get('toFilterDate');
        $namaBarang = $request->get('namaBarang');

        $data = DB::table('masuk as ms')
            ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ms.ID_SUPPLIER')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'ms.ID_BARANG')
            ->join('karyawan as ka', 'ka.ID_KAR', '=', 'ms.ID_KAR')
            ->where('ba.NAMA_BARANG', 'like', '%' . $namaBarang . '%')
            ->whereBetween('ms.TANGGAL_MASUK', [$fromDate, $toDate])
            ->get();

        // dd($data);

        return View('gudang/transaksimasuk/filterLaporan', [
            'DaftarBarangMasuk' => $data,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'namaBarang' => $namaBarang
        ]);
    }

    public function pdfBarangMasuk(Request $request)
    {

        $fromDate = $request->from;
        $toDate = $request->to;
        $namaBarang = $request->search;

        $data = DB::table('masuk as ms')
        ->select('ba.NAMA_BARANG', 'sp.NAMA_SUPPLIER', 'ms.TANGGAL_MASUK', 'pb.ID_PEMESANAN', 'ms.JML_BARANG_MSK', 'ms.HARGA_BARANG_MASUK', 'ms.ID_MASUK', 'pb.TANGGAL_PEMBELIAN', 'ka.NAMA_KAR')
        ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ms.ID_SUPPLIER')
        ->join('pembelian as pb', 'ms.ID_PEMESANAN', '=', 'pb.ID_PEMESANAN')
        ->join('barang as ba', 'ba.ID_BARANG', '=', 'ms.ID_BARANG')
        ->join('karyawan as ka', 'ka.ID_KAR', '=', 'ms.ID_KAR')
        ->where('ba.NAMA_BARANG', 'like', '%' . $namaBarang . '%')
        ->whereBetween('ms.TANGGAL_MASUK', [$fromDate, $toDate])
        ->groupBy('ba.NAMA_BARANG', 'sp.NAMA_SUPPLIER', 'ms.TANGGAL_MASUK', 'pb.ID_PEMESANAN', 'ms.JML_BARANG_MSK', 'ms.HARGA_BARANG_MASUK', 'ms.ID_MASUK', 'pb.TANGGAL_PEMBELIAN', 'ka.NAMA_KAR')
        ->orderBy( 'ms.TANGGAL_MASUK', 'ASC')
        ->get();

        // $data = DB::table('masuk as ms')
        //     ->join('barang as ba', 'ba.ID_BARANG', '=', 'ms.ID_BARANG')
        //     ->join('karyawan as ka', 'ka.ID_KAR', '=', 'ms.ID_KAR')
        //     ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ms.ID_SUPPLIER')
        //     ->where('ba.NAMA_BARANG', 'like', '%' . $namaBarang . '%')
        //     ->whereBetween('ms.TANGGAL_MASUK', [$fromDate, $toDate])
        //     ->get();

        // $pdf = PDF::loadView('gudang/transaksimasuk/pdf', [
        //     'from' => $fromDate,
        //     'to' => $toDate,
        //     'DaftarBarangMasuk' => $data
        // ])->setPaper('landscape');

        // return $pdf->download('Laporan-transaksi-barang-masuk.pdf');

        return View('gudang/transaksimasuk/pdf')
        ->with('from', $fromDate)
        ->with('to', $toDate)
        ->with('DaftarBarangMasuk', $data);
        // return view('gudang/transaksimasuk/pdf', [
        //    'from' => $fromDate,
        //     'to' => $toDate,
        //     'DaftarBarangMasuk' => $data
        //  ]);
    }

    // TampilDetailPembelian
    public function TampilDetailPembelian($id)
    {
        // $data = DB::table('pembelian as pb')
        //     ->select('pb.ID_PEMBELIAN', 'pb.TANGGAL_PEMBELIAN', 'br.NAMA_BARANG', 'br.STOCK_BARANG', 'sp.NAMA_SUPPLIER', 'eq.NILAI_EOQ')
        //     ->join('barang as br', 'br.ID_BARANG', '=', 'pb.ID_BARANG')
        //     ->join('eoq as eq', 'eq.ID_BARANG', '=', 'pb.ID_BARANG')
        //     ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'br.ID_SUPPLIER')
        //     ->where('pb.TANGGAL_PEMBELIAN', $id)
        //     ->where('eq.STATUS_EOQ', '=', 1)
        //     ->groupBy('pb.ID_PEMBELIAN', 'pb.TANGGAL_PEMBELIAN', 'br.NAMA_BARANG', 'br.STOCK_BARANG', 'sp.NAMA_SUPPLIER', 'eq.NILAI_EOQ')
        //     ->get();

        $data = DB::select("SELECT pb.ID_PEMBELIAN, br.NAMA_BARANG, sp.NAMA_SUPPLIER, br.STOCK_BARANG, pb.TANGGAL_PEMBELIAN, pb.JML_PESAN as NILAI_EOQ, pb.ID_PEMESANAN, CASE WHEN SUM(ms.JML_BARANG_MSK) IS NULL THEN 0 ELSE SUM(ms.JML_BARANG_MSK) END AS JML_DITERIMA FROM `pembelian` pb LEFT JOIN masuk ms ON ms.ID_PEMESANAN = pb.ID_PEMESANAN AND ms.ID_BARANG = pb.ID_BARANG JOIN barang br ON br.ID_BARANG = pb.ID_BARANG JOIN supplier sp ON sp.ID_SUPPLIER = br.ID_SUPPLIER JOIN eoq ON eoq.ID_BARANG = pb.ID_BARANG WHERE eoq.STATUS_EOQ = 1 AND pb.TANGGAL_PEMBELIAN = '$id' GROUP BY pb.ID_PEMBELIAN, br.NAMA_BARANG, sp.NAMA_SUPPLIER, br.STOCK_BARANG, pb.TANGGAL_PEMBELIAN, pb.JML_PESAN, pb.ID_BARANG, pb.ID_PEMESANAN");
        //dd($data);
        return View('gudang/pembelian/detailpembelian')
            ->with('data', $data);
    }

    public function pdfDetailPembelian($id)
    {
        $data = DB::table('pembelian as pb')
            ->select('pb.ID_PEMBELIAN', 'pb.TANGGAL_PEMBELIAN', 'br.NAMA_BARANG', 'br.STOCK_BARANG', 'sp.NAMA_SUPPLIER', 'rp.NILAI_ROP', 'eq.NILAI_EOQ', 'br.HARGA_BARANG')
            ->join('barang as br', 'br.ID_BARANG', '=', 'pb.ID_BARANG')
            ->join('rop as rp', 'rp.ID_BARANG', '=', 'pb.ID_BARANG')
            ->join('eoq as eq', 'eq.ID_BARANG', '=', 'pb.ID_BARANG')
            ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'br.ID_SUPPLIER')
            ->where('pb.TANGGAL_PEMBELIAN', $id)
            ->where('rp.STATUS_ROP', '=', 1)
            ->where('eq.STATUS_EOQ', '=', 1)
            ->groupBy('pb.ID_PEMBELIAN', 'pb.TANGGAL_PEMBELIAN', 'br.NAMA_BARANG', 'br.STOCK_BARANG', 'sp.NAMA_SUPPLIER', 'rp.NILAI_ROP', 'eq.NILAI_EOQ', 'br.HARGA_BARANG')
            ->get();

        $pdf = PDF::loadView('gudang/pembelian/pdf', [
            'DataBarangRop' => $data
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Cetak-Rencana-Pembelian-Barang.pdf');
    }

    public function TampilPembelian()
    {
        $data = DB::table('pembelian')
            ->select('ID_PEMESANAN', 'TANGGAL_PEMBELIAN','ACC')
            ->where('ACC', 1)
            ->groupBy('ID_PEMESANAN','TANGGAL_PEMBELIAN','ACC')
            ->orderBy('ACC', 'desc')
            ->get();

        $dataBarang = DB::table('pembelian as pb')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'pb.ID_BARANG')
            ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ba.ID_SUPPLIER')
            ->get();

        // dd($data);
        return View('gudang/pembelian/pembelian', [
            'countData' => $data,
            'dataBarang' => $dataBarang
        ]);
    }



    public function TampilBarangMasuk(Request $request)
    {
        $filter = $request->get('filterDate');
        if ($filter) {
            $data = DB::table('masuk as ms')
                ->join('barang as ba', 'ba.ID_BARANG', '=', 'ms.ID_BARANG')
                ->join('karyawan as ka', 'ka.ID_KAR', '=', 'ms.ID_KAR')
                ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ms.ID_SUPPLIER')
                ->where('ms.TANGGAL_MASUK', 'like', '%' . $filter . '%')
                ->get();
        } else {
            $data = DB::table('masuk as ms')
                ->select('ba.NAMA_BARANG', 'sp.NAMA_SUPPLIER', 'ms.TANGGAL_MASUK', 'pb.ID_PEMESANAN', 'ms.JML_BARANG_MSK', 'ms.HARGA_BARANG_MASUK', 'ms.ID_MASUK', 'pb.TANGGAL_PEMBELIAN', 'ka.NAMA_KAR')
                ->join('barang as ba', 'ba.ID_BARANG', '=', 'ms.ID_BARANG')
                ->join('pembelian as pb', 'ms.ID_PEMESANAN', '=', 'pb.ID_PEMESANAN')
                ->join('karyawan as ka', 'ka.ID_KAR', '=', 'ms.ID_KAR')
                ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ms.ID_SUPPLIER')
                ->groupBy('ba.NAMA_BARANG', 'sp.NAMA_SUPPLIER', 'ms.TANGGAL_MASUK', 'pb.ID_PEMESANAN', 'ms.JML_BARANG_MSK', 'ms.HARGA_BARANG_MASUK', 'ms.ID_MASUK', 'pb.TANGGAL_PEMBELIAN', 'ka.NAMA_KAR')
                ->get();
        }
        $data1 = DB::table('barang')
            ->get();
        $data2 = DB::table('supplier')
            ->get();
        $data3 = DB::table('karyawan')
            ->get();

        return View('gudang/transaksimasuk/masuk')
            ->with('DaftarBarangMasuk', $data);
    }

    public function exportBarangKeluar(Request $request)
    {
        $fromDate = $request->get('fromFilterDate');
        $toDate = $request->get('toFilterDate');
        $namaBarang = $request->get('namaBarang');

        $data = DB::table('detail_keluar as kl')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'kl.ID_BARANG')
            ->join('karyawan as ka', 'ka.ID_KAR', '=', 'kl.ID_KAR')
            ->where('ba.NAMA_BARANG', 'like', '%' . $namaBarang . '%')
            ->where('STATUS_PENDING', 0)
            ->whereBetween('kl.TANGGAL_KELUAR', [$fromDate, $toDate])
            ->get();

        // dd($data);

        return View('gudang/transaksikeluar/filter', [
            'DaftarBarangKeluar' => $data,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'namaBarang' => $namaBarang
        ]);
    }

    public function exportBarangKeluarLaporan(Request $request)
    {
        $fromDate = $request->get('fromFilterDate');
        $toDate = $request->get('toFilterDate');
        $namaBarang = $request->get('namaBarang');

        $data = DB::table('keluar as kl')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'kl.ID_BARANG')
            ->join('karyawan as ka', 'ka.ID_KAR', '=', 'kl.ID_KAR')
            ->where('ba.NAMA_BARANG', 'like', '%' . $namaBarang . '%')
            ->whereBetween('kl.TANGGAL_KELUAR', [$fromDate, $toDate])
            ->get();

        // dd($data);

        return View('gudang/transaksikeluar/filterLaporan', [
            'DaftarBarangKeluar' => $data,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'namaBarang' => $namaBarang
        ]);
    }

    public function pdfBarangKeluar(Request $request)
    {
        $fromDate = $request->from;
        $toDate = $request->to;
        $namaBarang = $request->search;

        $data = DB::table('detail_keluar as kl')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'kl.ID_BARANG')
            ->join('karyawan as ka', 'ka.ID_KAR', '=', 'kl.ID_KAR')
            ->where('ba.NAMA_BARANG', 'like', '%' . $namaBarang . '%')
            ->where('STATUS_PENDING', 0)
            ->whereBetween('kl.TANGGAL_KELUAR', [$fromDate, $toDate])
            ->orderBy('kl.TANGGAL_KELUAR','ASC')
            ->get();


        // $pdf = PDF::loadView('gudang/transaksikeluar/pdf', [
        //     'from' => $fromDate,
        //     'to' => $toDate,
        //     'DaftarBarangKeluar' => $data
        // ])->setPaper('a4', 'landscape');

        // foreach ($data as  $q) {

        //     $insertToDB = array(
        //         'TANGGAL_PEMBELIAN' => $q->TANGGAL_KELUAR,
        //     );

        //     DB::table('pembelian')->insert($insertToDB);
        // }


        return View('gudang/transaksikeluar/pdf')
            ->with('from', $fromDate)
            ->with('to', $toDate)
            ->with('DaftarBarangKeluar', $data);

        // return $pdf->stream('Laporan-transaksi-barang-keluar.pdf');
    }

    public function TampilBarangKeluar(Request $request)
    {
        $data = DB::table('detail_keluar as kl')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'kl.ID_BARANG')
            ->join('karyawan as ka', 'ka.ID_KAR', '=', 'kl.ID_KAR')
            ->where('STATUS_PENDING', 0)
            ->get();

        $data1 = DB::table('barang')
            ->get();
        $data2 = DB::table('karyawan')
            ->get();

        return View('gudang/transaksikeluar/keluar')
            ->with('DaftarBarangKeluar', $data);
    }

    public function tampilExportBarangKeluar()
    {
        $data = DB::table('detail_keluar as kl')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'kl.ID_BARANG')
            ->join('karyawan as ka', 'ka.ID_KAR', '=', 'kl.ID_KAR')
            ->where('STATUS_PENDING', 0)
            ->get();

        $data1 = DB::table('barang')
            ->get();
        $data2 = DB::table('karyawan')
            ->get();

        return View('gudang/transaksikeluar/exportBarangKeluar')
            ->with('DaftarBarangKeluar', $data);
    }

    public function TampilTambahBarangMasuk(Request $request)
    {

        $data1 = DB::table('barang')
            ->get();
        $data2 = DB::table('supplier')
            ->get();
        $data3 = DB::table('karyawan')
            ->get();

        return View('gudang/transaksimasuk/barangmasuk')
            ->with('DaftarBarang', $data1)
            ->with('DaftarSupplier', $data2)
            ->with('DaftarKaryawan', $data3);
    }

    public function TampilTambahBarangKeluar(Request $request)
    {

        $data1 = DB::table('barang as ba')
            ->join('safety_stock as ss', 'ss.ID_BARANG', '=', 'ba.ID_BARANG')
            ->where('ss.STATUS_SS', '1')
            ->whereColumn('ba.STOCK_BARANG', '>', 'ss.NILAI_SS')
            ->get();

        return View('gudang/transaksikeluar/barangkeluar')
            ->with('DaftarBarang', $data1);
    }
    public function TampilTambahBarangKeluarAjax(Request $request)
    {
        $ID_BARANG = $request->ID_BARANG;
        $data1 = DB::table('barang')
            ->where('ID_BARANG', '=', $ID_BARANG)
            ->first();
        $safety_stock = DB::table('safety_stock')
            ->where('STATUS_SS', '=', '1')
            ->where('ID_BARANG', '=', $ID_BARANG)
            ->first();

        return View('gudang/transaksikeluar/ajax')
            ->with('DaftarBarang', $data1)
            ->with('safety_stock', $safety_stock);
    }

    public function TampilTambahBarangMasukAjax(Request $request)
    {
        $ID_BARANG = $request->ID_BARANG;
        $data1 = DB::table('supplier as sp')
            ->join('barang as ba', 'ba.ID_SUPPLIER', '=', 'sp.ID_SUPPLIER')
            ->where('ID_BARANG', '=', $ID_BARANG)
            ->first();
        return View('gudang/transaksimasuk/ajax')
            ->with('DaftarSupplier', $data1);
    }

    public function cariidpemesananbarangmasukAjax(Request $request)
    {
        $ID_BARANG = $request->ID_BARANG;
        $data1 = DB::table('pembelian')
            ->where('ID_BARANG', $ID_BARANG)
            ->where('STATUS', 0)
            ->get();
        return View('gudang/transaksimasuk/ajax_idpemesanan')
            ->with('DaftarPesanan', $data1)
            ->with('ID_BARANG', $ID_BARANG);
    }

    public function carijmlpemesananbarangAjax(Request $request)
    {
        $ID_PEMESANAN = $request->ID_PEMESANAN;
        $ID_BARANG = $request->ID_BARANG;
        $data1 = DB::table('pembelian')
            ->where('ID_PEMESANAN', $ID_PEMESANAN)
            ->where('ID_BARANG', $ID_BARANG)
            ->where('STATUS', 0)
            ->first();
        $data2 = DB::table('masuk')
            ->select(DB::raw('SUM(JML_BARANG_MSK) JML_BARANG_MSK'))
            ->where('ID_PEMESANAN', $ID_PEMESANAN)
            ->where('ID_BARANG', $ID_BARANG)
            ->groupBy('ID_BARANG', 'ID_PEMESANAN')
            ->first();
        if ($data2 === null) {
            $data2 = (object) array('JML_BARANG_MSK' => 0);
        }
        return ($data1->JML_PESAN - $data2->JML_BARANG_MSK);
    }

    public function tampilExportBarangMasuk(Request $request)
    {
        $filter = $request->get('filterDate');
        if ($filter) {
            $data = DB::table('masuk as ms')
                ->join('barang as ba', 'ba.ID_BARANG', '=', 'ms.ID_BARANG')
                ->join('karyawan as ka', 'ka.ID_KAR', '=', 'ms.ID_KAR')
                ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ms.ID_SUPPLIER')
                ->where('ms.TANGGAL_MASUK', 'like', '%' . $filter . '%')
                ->get();
        } else {
            $data = DB::table('masuk as ms')
                ->join('barang as ba', 'ba.ID_BARANG', '=', 'ms.ID_BARANG')
                ->join('karyawan as ka', 'ka.ID_KAR', '=', 'ms.ID_KAR')
                ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ms.ID_SUPPLIER')
                ->get();
        }
        $data1 = DB::table('barang')
            ->get();
        $data2 = DB::table('supplier')
            ->get();
        $data3 = DB::table('karyawan')
            ->get();

        return View('gudang/transaksimasuk/exportTransaksiMasuk')
            ->with('DaftarBarangMasuk', $data);
    }

    public function TampilDataSafetyStock(Request $request)
    {
        $data = DB::table('safety_stock as ss')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'ss.ID_BARANG')
            ->where('STATUS_SS', '=', 1)
            ->get();
        // dd($data);
        return View('gudang/operasibarang/safetystock/safestock')
            ->with('DataSafetyStock', $data);
    }
    public function TampilDataROP(Request $request)
    {
        $data = DB::table('rop as rop')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'rop.ID_BARANG')
            // ->where('STOCK_BARANG', '<', 'NILAI_ROP')
            ->where('STATUS_ROP', '=', 1)
            ->get();
        // dd($data);

        return View('gudang/operasibarang/rop/datarop')
            ->with('DataROP', $data);
    }
    public function TampilDataEOQ(Request $request)
    {
        $data = DB::table('eoq as eoq')
            ->join('barang as ba', 'ba.ID_BARANG', '=', 'eoq.ID_BARANG')
            ->where('STATUS_EOQ', '=', 1)
            ->get();

        return View('gudang/operasibarang/eoq/dataeoq')
            ->with('DataEOQ', $data);
    }

    public function TampilDataBarangROP()
    {
        $data = DB::table('rop as rp')
            ->select('rp.ID_ROP', 'ss.ID_BARANG', 'ss.NAMA_BARANG', 'eq.NILAI_EOQ', 'ss.STOCK_BARANG', 'rp.NILAI_ROP', 'sp.NAMA_SUPPLIER')
            ->join('barang as ss', 'rp.ID_BARANG', '=', 'ss.ID_BARANG')
            ->join('eoq as eq', 'eq.ID_BARANG', '=', 'ss.ID_BARANG')
            ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ss.ID_SUPPLIER')
            ->where('rp.STATUS_ROP', 1)
            ->groupBy('rp.ID_ROP', 'ss.ID_BARANG', 'ss.NAMA_BARANG', 'ss.STOCK_BARANG', 'rp.NILAI_ROP', 'eq.NILAI_EOQ', 'sp.NAMA_SUPPLIER')
            ->get();
        //dd($data);

        $status = [
            'STATUS_ROP' => 0
        ];

        if ($data[0]->STOCK_BARANG >= $data[0]->NILAI_ROP) {
            DB::table('rop')->where('ID_ROP', '=', $data[0]->ID_ROP)->update($status);
        }

        return View('gudang/operasibarang/databarangrop/databarangrop')
            ->with('DataBarangRop', $data);
    }

    public function barangKurang()
    {
        $data = DB::table('rop as rp')
            ->select('rp.ID_ROP', 'ss.ID_BARANG', 'ss.NAMA_BARANG', 'eq.NILAI_EOQ', 'ss.STOCK_BARANG', 'rp.NILAI_ROP', 'sp.NAMA_SUPPLIER')
            ->join('barang as ss', 'rp.ID_BARANG', '=', 'ss.ID_BARANG')
            ->join('eoq as eq', 'eq.ID_BARANG', '=', 'ss.ID_BARANG')
            ->join('supplier as sp', 'sp.ID_SUPPLIER', '=', 'ss.ID_SUPPLIER')
            ->where('rp.STATUS_ROP', 1)
            ->where('eq.STATUS_EOQ', 1)
            ->groupBy('rp.ID_ROP', 'ss.ID_BARANG', 'ss.NAMA_BARANG', 'ss.STOCK_BARANG', 'rp.NILAI_ROP', 'eq.NILAI_EOQ', 'sp.NAMA_SUPPLIER')
            ->get();

            // dd($data);

        return View('gudang/operasibarang/databarangrop/dataBarangKurang')
            ->with('DataBarangRop', $data);
    }
}
