<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class ROPController extends Controller
{
    public function TampilTambahROP(Request $request)
    {
        $data = DB::table('barang as ba')
            ->join('operasi as op', 'op.ID_BARANG', '=', 'ba.ID_BARANG')
            ->join('safety_stock as ss', 'ss.ID_BARANG', '=', 'ba.ID_BARANG')
            ->where('STATUS_OP', '=', 1)
            ->where('STATUS_SS', '=', 1)
            ->get();

        return View('gudang/operasibarang/rop/perhitunganrop')
            ->with('DataBarang', $data);
    }

    public function TampilOperasiROPAjax(Request $request)
    {
        $ID_BARANG = $request->ID_BARANG;

        $year = Carbon::now()->year;
        $data1 =  DB::table('operasi')
            ->where(DB::raw('date_format(TANGGAL_OP, "%Y")'), '=', $year)
            ->where('ID_BARANG', '=', $ID_BARANG)
            ->where('STATUS_OP', '=', 1)
            ->first();

        $data2 =  DB::table('safety_stock')
            ->where(DB::raw('date_format(TANGGAL_SS, "%Y")'), '=', $year)
            ->where('ID_BARANG', '=', $ID_BARANG)
            ->where('STATUS_SS', '=', 1)
            ->first();


            $data3 =  DB::table('standartd')
            ->select(DB::raw('(BULAN_1 + BULAN_2 + BULAN_3 +BULAN_4 +BULAN_5 +BULAN_6 +BULAN_7 +BULAN_8 +BULAN_9 +BULAN_10 +BULAN_11 +BULAN_12 ) as jumlah_kebutuhan '))
            ->where('ID_BARANG', '=', $ID_BARANG)
            ->where('STATUS_KB', '=', 1)
            ->first();
            // dd($data3);

         $DataKebutuhan = DB::table('standartd')
        ->where('ID_BARANG', '=', $_GET['ID_BARANG'])
        ->where('STATUS_KB', '=', 1)
        ->first();
        //s/asd

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

        if ($data1 && $data2) {
            // $kebutuhanbulan = round( $data3->jumlah_kebutuhan / 12);

            $perhitunganROP = ($Pengurang  * round($data1->LEAD_TIME)) + $data2->NILAI_SS;
            // dd($perhitunganROP);
            return View('gudang/operasibarang/rop/ajax')
                ->with('kebutuhanbulan', $Pengurang )
                ->with('DataOperasi', $data1)
                ->with('DataSS', $data2)
                ->with('hasilROP', $perhitunganROP);
        } else {
            Alert::Error('Data Tidak Ada', 'Mohon PAstikan Data Operasi Barang Terisi');
        }
    }

    public function OperasiTambahROP(Request $request)
    {
        $data = array(
            'ID_BARANG' => $request->input('barang'),
            'TANGGAL_ROP' => $request->input('tgl_rop'),
            'NILAI_ROP' => $request->input('nilai_rop'),
            'STATUS_ROP' => $request->input('status_rop'),
        );

        $data2 = array(
            'STATUS_ROP' => 0
        );

        DB::table('rop')->where('ID_BARANG', '=', $request->input('barang'))->update($data2);
        DB::table('rop')->insert($data);
        Alert::success('Data Reorder Point', 'Data Berhasil Ditambahkan');
        return Redirect::to('masterrop');
    }
}
