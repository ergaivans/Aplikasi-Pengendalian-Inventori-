<label>ID Pemesanan</label>
<select required name="id_pemesanan" class="form-control js-example-basic-single" data-barang="{{$ID_BARANG}}" onchange="cari_jmlpesanan_barang(this)" id="id_pemesanan">
    <option value="" style="display: none;" disabled selected>Pilih--</option>
    @foreach ($DaftarPesanan as $q)
        <option value="{{$q->ID_PEMESANAN}}">{{$q->ID_PEMESANAN}}</option>
    @endforeach
</select>

<script>
    function cari_jmlpesanan_barang(val){
        const url = "carijmlpemesananbarangAjax"; // get the url of the view
        const ID_BARANG = val.getAttribute('data-barang');
        $.ajax({ // initialize an AJAX request
            url: url, // set the url of the request (=)
            data: {
                'ID_PEMESANAN': val.value, // add the country id to the GET parameters
                'ID_BARANG': ID_BARANG
            },
            success: function(data) { // `data` is the return of the view function
                console.log(data);
                document.getElementById("jml_masuk").max = data;
                document.getElementById("textpemesanan").innerHTML = "Jumlah Pemesanan Pada Pemesanan Ini Sebesar <b>"+data+" Unit  </b>";
            }
        });
    }

    $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
</script>
