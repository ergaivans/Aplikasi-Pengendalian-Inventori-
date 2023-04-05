<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SafetyController extends Controller
{
    public function TampilTambahSafetyStock(Request $request)
    {
        $data = DB::table('barang as ba')
            ->join('operasi as op', 'op.ID_BARANG', '=', 'ba.ID_BARANG')
            ->join('safety_factor as sf', 'sf.ID_BARANG', '=', 'ba.ID_BARANG')
            ->join('standartd as sd', 'sd.ID_BARANG', '=', 'ba.ID_BARANG')
            ->join('nilai_sd as nsd', 'nsd.ID_BARANG', '=', 'ba.ID_BARANG')
            ->where('STATUS_OP', '=', 1)
            ->where('STATUS_KB', '=', 1)
            ->where('STATUS_NSD', '=', 1)
            ->where('STATUS_SAFE', '=', 1)
            ->get();

        return View('gudang/operasibarang/safetystock/perhitungansafe')
            ->with('DataBarang', $data);
    }

    public function TampilSafetyStockAjax(Request $request)
    {
        $ID_BARANG = $request->ID_BARANG;


        $data1 = DB::table('safety_factor')
            ->select('NILAI_SAFE')
            ->where('ID_BARANG', '=', $ID_BARANG)
            ->where('STATUS_SAFE', '=', 1)
            ->first();

        $year = Carbon::now()->year;

        $data2 =  DB::table('operasi')
            ->where(DB::raw('date_format(TANGGAL_OP, "%Y")'), '=', $year)
            ->where('ID_BARANG', '=', $ID_BARANG)
            ->where('STATUS_OP', '=', 1)
            ->first();

        $data3 =  DB::table('nilai_sd')
        ->select('NILAI_NSD')
        ->where('ID_BARANG', '=', $ID_BARANG)
        ->where('STATUS_NSD', '=', 1)
        ->first();

        $safetystock = $data1->NILAI_SAFE * $data3->NILAI_NSD;

        // $hasil = $data2->KEBUTUHAN_BARANG_BL * $data1->NILAI_SAFE;
        // $kebutuhanbulan = $data2->KEBUTUHAN_BARANG_BL / 12;
        // $nilai_pangkat = 2;
        // $va = $data2->KEBUTUHAN_BARANG_BL - $kebutuhanbulan;
        // $hasilkuadrann = pow($va, $nilai_pangkat);
        // $fa = $hasilkuadrann / 11;
        // $hasil = sqrt($fa);

        return View('gudang/operasibarang/safetystock/ajax')
            ->with('DataSafetyFactor', $data1)
            ->with('DataSD', $data3)
            ->with('hasil', round($safetystock));
    }

    public function OperasiTambahSafetyStock(Request $request)
    {
        $data = array(
            'ID_BARANG' => $request->input('barang'),
            'TANGGAL_SS' => $request->input('tgl_ss'),
            'NILAI_SS' => $request->input('nilai_ss'),
            'NILAI_STANDARD' => $request->input('nilai_sd'),
            'STATUS_SS' => $request->input('status_ss'),
        );
        // dd($data);
        $data2 = array(
            'STATUS_SS' => 0
        );

        DB::table('safety_stock')->where('ID_BARANG', '=', $request->input('barang'))->update($data2);
        DB::table('safety_stock')->insert($data);
        Alert::success('Data Safety Stock', 'Data Berhasil Ditambahkan');
        return Redirect::to('masterss');
    }
}
