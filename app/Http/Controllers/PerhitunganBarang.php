<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class PerhitunganBarang extends Controller
{
    public function DaftarPerhitunganBarang(Request $request){

        $sd = DB::table('nilai_sd as sd')
        ->select('sd.ID_BARANG', 'sd.NILAI_NSD')
        ->where('sd.STATUS_NSD', '1');

        $ss = DB::table('safety_stock as ss')
        ->select('ss.ID_BARANG', 'ss.NILAI_SS')
        ->where('ss.STATUS_SS', '1');

        $rop = DB::table('rop')
        ->select('rop.ID_BARANG', 'rop.NILAI_ROP')
        ->where('rop.STATUS_ROP', '1');

        $eoq = DB::table('eoq')
        ->select('eoq.ID_BARANG', 'eoq.NILAI_EOQ')
        ->where('eoq.STATUS_EOQ', '1');

        $data = DB::table('barang as br')
        ->select('br.ID_BARANG', 'br.NAMA_BARANG', DB::raw('case when sd.NILAI_NSD is null then 0 else sd.NILAI_NSD end as NILAI_NSD'), DB::raw('case when ss.NILAI_SS is null then 0 else ss.NILAI_SS end as NILAI_SS'), DB::raw('case when rop.NILAI_ROP is null then 0 else rop.NILAI_ROP end as NILAI_ROP'), DB::raw('case when eoq.NILAI_EOQ is null then 0 else eoq.NILAI_EOQ end as NILAI_EOQ'))
        ->leftJoinSub($sd, 'sd', 'sd.ID_BARANG', '=', 'br.ID_BARANG')
        ->leftJoinSub($ss, 'ss', 'ss.ID_BARANG', '=', 'br.ID_BARANG')
        ->leftJoinSub($rop, 'rop', 'rop.ID_BARANG', '=', 'br.ID_BARANG')
        ->leftJoinSub($eoq, 'eoq', 'eoq.ID_BARANG', '=', 'br.ID_BARANG')
        ->where('NILAI_NSD', '!=', '0')
        ->orWhere('NILAI_SS', '!=', '0')
        ->orWhere('NILAI_ROP', '!=', '0')
        ->orWhere('NILAI_EOQ', '!=', '0');

        return View('gudang/operasibarang/perhitunganbarang/perhitungan')
        ->with('data', $data->get());
    }

    public function TambahPerhitunganBarang(Request $request){
        // $data = DB::table('barang as ba')
        // ->join('operasi as op', 'op.ID_BARANG', '=', 'ba.ID_BARANG')
        // ->join('safety_factor as sf', 'sf.ID_BARANG', '=', 'ba.ID_BARANG')
        // ->join('nilai_sd as nsd', 'nsd.ID_BARANG', '=', 'ba.ID_BARANG')
        // ->where('STATUS_OP', '=', 1)
        // ->where('STATUS_NSD', '=', 1)
        // ->where('STATUS_SAFE', '=', 1)
        // ->get();

        $mx = DB::table('standartd')
        ->select('ID_BARANG as id', DB::raw('MAX(TANGGAL) tgl'))
        ->groupBy('ID_BARANG');

        //ambil nilai 12 bulan terakhir
        $last12_data = DB::table('standartd as ss')
        ->select('ba.ID_BARANG', 'ba.NAMA_BARANG')
        ->join('barang as ba', 'ba.ID_BARANG' , '=', 'ss.ID_BARANG')
        ->joinSub($mx, 'mx', 'mx.id', '=', 'ss.ID_BARANG')
        ->whereRaw(DB::raw('TANGGAL > mx.tgl - interval 12 month'))
        ->groupBy('ba.ID_BARANG', 'ba.NAMA_BARANG')
        ->orderBy('ss.ID_BARANG', 'asc')
        ->orderBy('TANGGAL', 'desc');

        // dd($last12_data->get());

        return View('gudang/operasibarang/perhitunganbarang/tambahperhitungan')
        ->with('DataBarang', $last12_data->get());
    }

    public function AjaxPerhitunganBarang(Request $request){
        $ID_BARANG = $request->ID_BARANG;


        /// Perhitungan Nilai Kebutuhan

        $mx = DB::table('standartd')
        ->select('ID_BARANG as id', DB::raw('MAX(TANGGAL) tgl'))
        ->where('ID_BARANG', '=', $ID_BARANG)
        ->groupBy('ID_BARANG');

        //ambil nilai 12 bulan terakhir
        $last12_data = DB::table('standartd as ss')
        ->join('barang as ba', 'ba.ID_BARANG' , '=', 'ss.ID_BARANG')
        ->joinSub($mx, 'mx', 'mx.id', '=', 'ss.ID_BARANG')
        ->whereRaw(DB::raw('TANGGAL > mx.tgl - INTERVAL 12 month'))
        ->where('ba.ID_BARANG', '=', $ID_BARANG)
        ->orderBy('ss.ID_BARANG', 'asc')
        ->orderBy('TANGGAL', 'desc');

        $array_kebutuhan = [];
        foreach($last12_data->get() as $item){
            array_push($array_kebutuhan, $item->NOMINAL);
        }

        //hitung rata-rata
        $data = DB::table('standartd as ss')
        ->join('barang as ba', 'ba.ID_BARANG' , '=', 'ss.ID_BARANG')
        ->joinSub($mx, 'mx', 'mx.id', '=', 'ss.ID_BARANG')
        ->whereRaw(DB::raw('TANGGAL > mx.tgl - INTERVAL 12 month'))
        ->where('ba.ID_BARANG', '=', $ID_BARANG)
        ->orderBy('ss.ID_BARANG', 'asc')
        ->orderBy('TANGGAL', 'desc');

        $query_avg = $data->select('ss.ID_BARANG', 'ba.NAMA_BARANG', DB::raw('CEIL(AVG(ss.NOMINAL)) as AVG'))->groupBy('ss.ID_BARANG', 'ba.NAMA_BARANG');

        $Pengurang = $query_avg->first();
        $rata_rata = $Pengurang->AVG;

        //Pehitungan Standard Deviation

        $SigmaBalls = 0;
        for ($i=0; $i < count($array_kebutuhan); $i++) {
            $SigmaBalls += pow(($array_kebutuhan[$i] - $rata_rata), 2);
        }
        $SigmaBalls = round($SigmaBalls/(count($array_kebutuhan)-1), 2);
        $hasil_sd = sqrt($SigmaBalls);

        // Perhitungan Safety Stock

        //data safety factor
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

        $safetystock = ceil($data1->NILAI_SAFE * $hasil_sd);

        // Perhitungan Rorder Point
        $NilaiLeadtime = $data2->LEAD_TIME/30;
        $rop = ceil(($rata_rata * $NilaiLeadtime)) + $safetystock;

        // Perhitungan Metode MinMAX
        $minimal = ceil(($rata_rata * $NilaiLeadtime) + $safetystock);
        //Perhitungan Maksimal Stock
        $maksimal = ceil((2 * ($rata_rata * $NilaiLeadtime) + $safetystock));

        $nilaiq = $maksimal-$minimal;
        $barangsekalipesan = ceil((2 * $rata_rata * $NilaiLeadtime));

        return View('gudang/operasibarang/perhitunganbarang/ajax')
        ->with('nilaikebuthan', $rata_rata)
        ->with('nilaisd', $hasil_sd )
        ->with('nilaiss', $safetystock)
        ->with('nilairop', $rop)
        ->with('nilaimaksimal', $maksimal)
        ->with('nilaiminimal', $minimal)
        ->with('nilaiq', $nilaiq)
        ->with('nilaipesan', $barangsekalipesan);
    }

    public function OperasiTambahPerhitungan(Request $request)
    {
        //standard deviasi
        $data1 = array(
            'ID_BARANG' => $request->input('barang'),
            'TANGGAL_NSD' => date("Y-m-d"),
            'NILAI_NSD' => $request->input('nilai_sd'),
            'STATUS_NSD' => 1,
        );
        //end standard deviasi
        $data2 = array(
            'ID_BARANG' => $request->input('barang'),
            'TANGGAL_SS' => date("Y-m-d"),
            'NILAI_SS' => $request->input('nilai_ss'),
            'STATUS_SS' => 1,
        );

        $data3 = array(
            'ID_BARANG' => $request->input('barang'),
            'TANGGAL_ROP' => date("Y-m-d"),
            'NILAI_ROP' => $request->input('nilai_rop'),
            'STATUS_ROP' => 1,
        );

        $data4 = array(
            'ID_BARANG' => $request->input('barang'),
            'TANGGAL_EOQ' => date("Y-m-d"),
            'NILAI_EOQ' => $request->input('nilaiq'),
            'STATUS_EOQ' => 1,
        );

        $status1 = array(
            'STATUS_NSD' => 0
        );
        $status2 = array(
            'STATUS_SS' => 0
        );
        $status3 = array(
            'STATUS_ROP' => 0
        );
        $status4 = array(
            'STATUS_EOQ' => 0
        );

        DB::table('nilai_sd')->where('ID_BARANG', '=', $request->input('barang'))->update($status1);
        DB::table('safety_stock')->where('ID_BARANG', '=', $request->input('barang'))->update($status2);
        DB::table('rop')->where('ID_BARANG', '=', $request->input('barang'))->update($status3);
        DB::table('eoq')->where('ID_BARANG', '=', $request->input('barang'))->update($status4);
        DB::table('nilai_sd')->insert($data1);
        DB::table('safety_stock')->insert($data2);
        DB::table('rop')->insert($data3);
        DB::table('eoq')->insert($data4);
        Alert::success('Data Reorder Point', 'Data Berhasil Ditambahkan');
        return Redirect::to('PerhitunganBarang');
    }
}

