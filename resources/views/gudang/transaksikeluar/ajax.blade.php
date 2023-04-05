<div class="form-group"><label >Harga Keluar</label>
<div class="input-group ">
    <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Rp</span>
    </div>
    <input type="number" id="harga_keluar" class="form-control" name="harga_keluar" value="{{$DaftarBarang->HARGA_BARANG}}" readonly required>
</div></div>

<div class="form-group">
    <label>Jumlah Keluar</label>
    <input type="number" onkeyup="perkalian(this.value)" id="jml_keluar" class="form-control" name="jml_keluar" placeholder="Masukkan Jumlah Keluar Barang" min="0" max="{{$DaftarBarang->STOCK_BARANG }}" data-beli="{{$DaftarBarang->STOCK_BARANG - $safety_stock->NILAI_SS}}" required>
    <input type="hidden" name="barangKeluar" id="barangKeluar">
    <input type="hidden" name="barangPending" id="barangPending">
    <small  class="form-text text-muted">Jumlah Maksimal Transaksi Barang Keluar Sebesar <b>{{$DaftarBarang->STOCK_BARANG - $safety_stock->NILAI_SS}} Unit</b> dari <b>{{$DaftarBarang->STOCK_BARANG}} unit</b> </small>
</div>

<div class="form-group">
    <label>Total Harga Keluar Keluar</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Rp</span>
        </div>
        <input type="number" id="tot_keluar" class="form-control" name="tot_keluar" placeholder="Masukkan Jumlah Keluar Barang" readonly required>
    </div>
</div>

<script>
     function perkalian(val) {
        document.getElementById("tot_keluar").value = document.getElementById("harga_keluar").value * val;
    }


    document.getElementById('jml_keluar').oninput = function () {
        var max = parseInt(this.max);

        if (parseInt(this.value) > max) {
            this.value = max;
        }
    }
</script>

