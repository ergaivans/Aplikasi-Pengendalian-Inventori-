<div class="form-group">

    @php

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

    @endphp

    <label >Nilai Pengurang</label>
    <input type="number" id="nilai_sd" class="form-control" name="nilai_sp" placeholder="Masukkan Jumlah Keluar Barang" value="{{$Pengurang}}" readonly required>
</div>

<div class="form-group">

    @php
    $SigmaBalls = 0;
    for ($i=0; $i < count($array_kebutuhan); $i++) {
        $SigmaBalls += pow(($array_kebutuhan[$i] - $Pengurang), 2);
    }
    $SigmaBalls = round($SigmaBalls/(count($array_kebutuhan)-1), 2);

    @endphp

    <label >Nilai Akhir </label>
    <input type="number" id="nilai_sd" class="form-control" name="nilai_sa" placeholder="Masukkan Jumlah Keluar Barang" value="{{$SigmaBalls}}" readonly required>

</div>

<div class="form-group">

    @php

    $Squirt = round(sqrt($SigmaBalls), 2);

    @endphp

    <label >Nilai Standard Deviation</label>
    <input type="number" id="nilai_sd" class="form-control" name="nilai_sda" placeholder="Masukkan Jumlah Keluar Barang" value="{{$Squirt}}" readonly required>

</div>

