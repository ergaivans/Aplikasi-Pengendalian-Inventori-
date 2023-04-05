<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class EOQController extends Controller
{

    public function TampilTambahEOQ(Request $request)
    {
        $data = DB::table('barang as ba')
        ->join('operasi as op', 'op.ID_BARANG' , '=', 'ba.ID_BARANG' )
        ->where('STATUS_OP', '=', 1)
        ->get();
        return View('gudang/operasibarang/eoq/perhitunganeoq')
        ->with('DataBarang', $data);
    }

    public function TampilPerhitunganEOQAjax(Request $request)
    {
        $ID_BARANG = $request->ID_BARANG;

        $year = Carbon::now()->year;
        $data1 =  DB::table('operasi as op')
        ->join('barang as ba', 'ba.ID_BARANG' , '=', 'op.ID_BARANG' )
        ->where(DB::raw('date_format(TANGGAL_OP, "%Y")'), '=', $year)
        ->where('op.ID_BARANG', '=', $ID_BARANG)
        ->where('op.STATUS_OP', '=', 1)
        ->first();

        $data3 =  DB::table('standartd')
        ->select(DB::raw('(BULAN_1 + BULAN_2 + BULAN_3 +BULAN_4 +BULAN_5 +BULAN_6 +BULAN_7 +BULAN_8 +BULAN_9 +BULAN_10 +BULAN_11 +BULAN_12 ) as jumlah_kebutuhan '))
        ->where('ID_BARANG', '=', $ID_BARANG)
        ->where('STATUS_KB', '=', 1)
        ->first();

        $DataKebutuhan = DB::table('standartd')
        ->where('ID_BARANG', '=', $_GET['ID_BARANG'])
        ->where('STATUS_KB', '=', 1)
        ->first();
        $array_kebutuhan[] = $DataKebutuhan->BULAN_1;
        $array_kebutuhan[] = $DataKebutuhan->BULAN_2;
        $array_kebutuhan[] = $DataKebutuhan->BULAN_3;
        $array_kebutuhan[] = $DataKebutuhan->BULAN_4;
        $array_kebutuhan[] = $DataKebutuhan->BULAN_5;
        $array_kebutuhan[] = $DataKebutuhan->BULAN_6;
        $array_kebutuhan[] = $DataKebutuhan->BULAN_7;
        $array_kebutuhan[] = $DataKebutuhan->BULAN_8;
        $array_kebutuhan[] = $DataKebutuhan->BULAN_9;
        $array_kebutuhan[] = $DataKebutuhan->BULAN_10;
        $array_kebutuhan[] = $DataKebutuhan->BULAN_11;
        $array_kebutuhan[] = $DataKebutuhan->BULAN_12;

    $array_kebutuhan = array_filter($array_kebutuhan);

    $Pengurang =
    round(array_sum($array_kebutuhan)/count($array_kebutuhan), 2);

        // $hasil = $data2->KEBUTUHAN_BARANG_BL * $data1->NILAI_SAFE;

        $kebutuhanbulan = round( $data3->jumlah_kebutuhan / 12);

        return View('gudang/operasibarang/eoq/ajax')
        ->with('DataEOQ', $data1)
        ->with('kebutuhan', $Pengurang);
    }

    public function OperasiTambahEOQ(Request $request)
    {
            $data = array(
            'ID_BARANG' => $request->input('barang'),
            'TANGGAL_EOQ' => $request->input('tgl_eoq'),
            'PERSEN_SIMPAN' => $request->input('biaya_simpan'),
            'BIAYA_SIMPAN' => $request->input('nilai_simpan'),
            'NILAI_EOQ' => $request->input('nilai_eoq'),
            'STATUS_EOQ' => $request->input('status_EOQ'),
        );

        $data2 = array(
            'STATUS_EOQ' => 0
        );

        DB::table('eoq')->where('ID_BARANG','=', $request->input('barang'))->update($data2);
        DB::table('eoq')->insert($data);
        Alert::success('Data Economic Order Quantity', 'Data Berhasil Ditambahkan');
        return Redirect::to('mastereoq');

    }









}
