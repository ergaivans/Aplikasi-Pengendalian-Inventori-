<div class="form-group">
    <label >Niai Kebutuhan Barang Perbulan</label>
    <input type="number" id="nilai_kb" class="form-control" name="nilai_kb" value="{{$kebutuhanbulan}}" readonly required>
</div>

<div class="form-group">
    <label >Niai Lead Time</label>
    <input type="number" id="nilai_lt" class="form-control" name="nilai_lt" value="{{$DataOperasi->LEAD_TIME}}" readonly required>
</div>

<div class="form-group">
<label >Nilai Safety Stock</label>
<input type="number" id="nilai_ss" class="form-control" name="nilai_ss" value="{{$DataSS->NILAI_SS}}" readonly required>
</div>

<div class="form-group">
    <label >Nilai Perhitungan Reorder Point</label>
    <input type="number" id="nilai_rop" class="form-control" name="nilai_rop" value="{{$hasilROP}}" readonly required>
</div>
