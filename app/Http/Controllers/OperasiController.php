<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class OperasiController extends Controller
{


    public function ProsesTambahDataOperasi(Request $request)
    {

        $data = array(
            'ID_BARANG' => $request->input('barang'),
            'TANGGAL_OP' => $request->input('tgl_masuk'),
            'LEAD_TIME' => $request->input('nilai_lead'),
            'BIAYA_PEMESANAN' => $request->input('nilai_biayapem'),
            'STATUS_OP' => $request->input('status'),
        );

        $data2 = array(
            'STATUS_OP' => 0
        );

        DB::table('operasi')->where('ID_BARANG','=', $request->input('barang'))->update($data2);
        DB::table('operasi')->insert($data);
        Alert::success('Data Operasi', 'Data Berhasil Ditambahkan');
        return Redirect::to('masteroperasi');

    }


    public function ProsesHapusDataOperasi(Request $request)
    {
        DB::table('operasi')->where('ID_OPERASI', '=', $request->input('id'))->delete();
        Alert::success('Data Operasi', 'Data Berhasil Dihapus');
        return Redirect::to('masteroperasi');
    }
}
