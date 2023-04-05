<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{

    public function ProsesTambahKategori(Request $request)
    {
        $data = array(
            'NAMA_KATEGORI' => $request->input('nama'),

        );
        DB::table('kategori')->insert($data);
        Alert::success('Data Kategori', 'Data Berhasil Ditambahkan');
        return Redirect::to('masterkategori');
    }

    public function ProsesEditKategori(Request $request)
    {
        $data = array(
            'NAMA_KATEGORI' => $request->input('nama'),
        );

        DB::table('kategori')->where('ID_KATEGORI', '=', $request->input('id'))->update($data);
        Alert::success('Data Kategori', 'Data Berhasil Diubah');
        return Redirect::to('masterkategori');
    }
    public function ProsesHapusKategori(Request $request)
    {
        DB::table('kategori')->where('ID_KATEGORI', '=', $request->input('id'))->delete();
        Alert::success('Data Kategori', 'Data Berhasil Dihapus');
        return Redirect::to('masterkategori');
    }
}
