<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DevisiasiStandard extends Controller
{

    public function TampilDataSD(Request $request)
    {
        $data = DB::table('nilai_sd as ss')
        ->join('barang as ba', 'ba.ID_BARANG' , '=', 'ss.ID_BARANG')
        ->where('STATUS_NSD', '=', 1)
        ->get();

        $data2 = DB::table('barang')
        ->get();

        return View('gudang/operasibarang/standarddev/kebutuhan')
        ->with('DaftarNilaiNSD', $data)
        ->with('DaftarBarang', $data2);

    }

    public function OperasiTambahkebutuhan(Request $request)
    {
        $array_bulan = $request->input('harga');
        //dd(count($array_bulan));

        $data = array(
            'ID_BARANG' => $request->input('barang'),
            'BULAN_1' => $array_bulan[0],
            'STATUS_KB' => $request->input('status_nsd')
        );

        $data2 = array(
            'STATUS_KB' => 0
        );

        DB::table('standartd')->where('ID_BARANG','=', $request->input('barang'))->update($data2);
        $dt_inserted = DB::table('standartd')->insertGetId($data);
        //dd($dt_inserted);
        for ($i=1; $i < count($array_bulan); $i++) {
            if($array_bulan[$i] != null){
                $text ='BULAN_'.$i+1;
                DB::table('standartd')->where('ID_SD','=', $dt_inserted)->update(array($text => $array_bulan[$i]));
            }
        }
        Alert::success('Data Kebutuhan', 'Data Berhasil Ditambahkan');
        return Redirect::to('kebutuhanbarang');

    }

    public function TampilNilaiStandard(Request $request)
    {
        $data = DB::table('barang as ba')
        ->join('standartd as op', 'op.ID_BARANG' , '=', 'ba.ID_BARANG' )
        ->where('STATUS_KB', '=', 1)
        ->get();
        return View('gudang/operasibarang/standarddev/perhitunganstandard')
        ->with('DataBarang', $data);
    }

    public function perhitunganstandard(Request $request)
    {
        $data = DB::table('standartd')
        ->where('ID_BARANG', '=', $_GET['ID_BARANG'])
        ->where('STATUS_KB', '=', 1)
        ->first();
        return View('gudang/operasibarang/standarddev/ajax')
        ->with('DataKebutuhan', $data);
    }

    public function OperasiTambahStandardevisiasi(Request $request)
    {
            $data = array(
            'ID_BARANG' => $request->input('barang'),
            'TANGGAL_NSD' => $request->input('tgl_nsd'),
            'NILAI_NSD' => $request->input('nilai_sda'),
            'STATUS_NSD' => $request->input('status_nsd'),
        );

        $data2 = array(
            'STATUS_NSD' => 0
        );

        DB::table('nilai_sd')->where('ID_BARANG','=', $request->input('barang'))->update($data2);
        DB::table('nilai_sd')->insert($data);
        Alert::success('Nilai Standard Deviation', 'Data Berhasil Ditambahkan');
        return Redirect::to('mastersd');

    }

    public function TampilDataKebutuhan(Request $request)
    {

        $barang = DB::table('barang')
        ->get();

        // $data = DB::table('standartd as ss')
        // ->join('barang as ba', 'ba.ID_BARANG' , '=', 'ss.ID_BARANG')
        // ->where('STATUS_KB', '=', 1)
        // ->get();

        $mx = DB::table('standartd')
        ->select('ID_BARANG as id', DB::raw('MAX(TANGGAL) tgl'))
        ->groupBy('ID_BARANG');

        $data = DB::table('standartd as ss')
        ->join('barang as ba', 'ba.ID_BARANG' , '=', 'ss.ID_BARANG')
        ->joinSub($mx, 'mx', 'mx.id', '=', 'ss.ID_BARANG')
        ->whereRaw(DB::raw('TANGGAL > mx.tgl - INTERVAL 12 month'))
        ->orderBy('ss.ID_BARANG', 'asc')
        ->orderBy('TANGGAL', 'desc');

        $query_avg = $data->select('ss.ID_BARANG', 'ba.NAMA_BARANG', DB::raw('CEIL(AVG(ss.NOMINAL)) as AVG'))->groupBy('ss.ID_BARANG', 'ba.NAMA_BARANG');

        $exclude =[];
        foreach($query_avg->get() as $item){
            array_push($exclude, $item->ID_BARANG);
        }

        $excluded = DB::table('standartd as ss')
        ->select('ba.ID_BARANG', 'ba.NAMA_BARANG', DB::raw('case when ss.NOMINAL is null then 0 end AVG'))
        ->rightJoin('barang as ba', 'ba.ID_BARANG' , '=', 'ss.ID_BARANG')
        ->whereNotIn('ba.ID_BARANG', $exclude)
        ->union($query_avg)
        ->orderBy('ID_BARANG', 'asc');

        return View('gudang/operasibarang/kebutuhan/kebutuhanbaru')
        ->with('DaftarNilaiKebutuhan', $excluded->get())
        ->with('barang', $barang);

    }

    public function TampilDetailDataKebutuhan($ID_BARANG){
        $barang = DB::table('standartd as ss')
        ->join('barang as ba', 'ba.ID_BARANG' , '=', 'ss.ID_BARANG')
        ->where('ss.ID_BARANG', '=', $ID_BARANG)
        ->orderBy('TANGGAL', 'desc')
        ->get();

        $ket_barang = DB::table('standartd as ss')
        ->rightJoin('barang as ba', 'ba.ID_BARANG' , '=', 'ss.ID_BARANG')
        ->where('ba.ID_BARANG', '=', $ID_BARANG)
        ->first();

        // dd($ket_barang);

        return View('gudang/operasibarang/kebutuhan/detail_kebutuhan')
        ->with('barang', $barang)
        ->with('keterangan', $ket_barang);
    }

    public function ProsesTambahKebutuhanBaru(Request $request)
    {
        $data = array(
            'ID_BARANG' => $request->input('id'),
            'NOMINAL' => $request->input('nilai'),
            'TANGGAL'=> $request->input('tgl_masuk').'-01',

        );
        DB::table('standartd')->insert($data);
        Alert::success('Data Kebutuhan', 'Data Berhasil Ditambahkan');
        return Redirect::to('/detail-kebutuhan/'.$request->input('id'));
    }

    public function importExcel(Request $request){


        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($request->filexcel);
        $arr_xcl = $spreadsheet->getSheet(0)->toArray();

        $filtered = [];
        for($i = 0; $i < count($arr_xcl); $i++){
            $fltr = array_filter($arr_xcl[$i]);
            array_push($filtered, $fltr);
        }
        $filtered = array_values(array_filter($filtered));

        $barang = DB::table('barang')->get();
        for($i = 0; $i < count($filtered) ; $i++){
            for($j = 0; $j < count($barang); $j++){
                if($barang[$j]->NAMA_BARANG == $filtered[$i][1]){
                    $filtered[$i][1] = $barang[$j]->ID_BARANG;
                }
            }
        }

        for($i = 1; $i < count($filtered); $i++){
            $data = array(
                'ID_BARANG' => $filtered[$i][1],
                'NOMINAL' => $filtered[$i][3],
                'TANGGAL'=> $filtered[$i][2],
            );
            $chk = DB::table('standartd')
            ->where('ID_BARANG', $filtered[$i][1])
            ->where('TANGGAL', $filtered[$i][2])
            ->get();
            if(count($chk) == 0){
                DB::table('standartd')->insert($data);
            }
        }
        return redirect('/kebutuhanbarang');
    }

    public function UbahDataKebutuhan(Request $request)
    {
        $array_bulan = $request->input('harga');

        $data = array(
            'BULAN_1' => $array_bulan[0]
        );

        DB::table('standartd')->where('ID_SD','=', $request->input('ID_SD'))->update($data);

        for ($i=1; $i < count($array_bulan); $i++) {
            if($array_bulan[$i] != null){
                $text ='BULAN_'.$i+1;
                DB::table('standartd')->where('ID_SD','=', $request->input('ID_SD'))->update(array($text => $array_bulan[$i]));
            }
        }
        Alert::success('Nilai Kebutuhan', 'Data Berhasil Diubah');
        return Redirect::to('kebutuhanbarang');

    }


}
