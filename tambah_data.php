<?php
    include("connection.php");
  
    if (isset($_GET["pesan"])) {
        $pesan = $_GET["pesan"];
    }
     
    if (isset($_GET["submit"])) {
        
        $tanggal = htmlentities(strip_tags(trim($_GET["tanggal"])));
        $id_sales = htmlentities(strip_tags(trim($_GET["id_sales"])));
        $nama_lead = htmlentities(strip_tags(trim($_GET["nama_lead"])));
        $id_produk = htmlentities(strip_tags(trim($_GET["id_produk"])));
        $no_wa = htmlentities(strip_tags(trim($_GET["no_wa"])));
        $kota = htmlentities(strip_tags(trim($_GET["kota"])));

        $pesan_erorr = "";

        if (empty($tanggal)) {
            $pesan_erorr .= "Tanggal harus diisi <br>";
        }
        
        if (empty($id_sales)) {
            $pesan_erorr .= "Sales harus diisi <br>";
        }

        if (empty($nama_lead)) {
            $pesan_erorr .= "Lead harus diisi <br>";
        }

        if (empty($id_produk)) {
            $pesan_erorr .= "Produk harus diisi <br>";
        }
        
        if (empty($no_wa)) {
            $pesan_erorr .= "No. Whatsapp harus diisi <br>";
        }
        elseif (!preg_match("/^[0-9]{1,16}$/", $no_wa)) {
            $pesan_erorr .= "No. Whatsapp harus berupa karakter numerik dan tidak boleh lebih dari 16 digit. <br>";
        }
        
        if (empty($kota)) {
            $pesan_erorr .= "Kota harus diisi <br>";
        }

        if ($pesan_erorr === "") {
            $tanggal          = mysqli_real_escape_string($link,$tanggal);
            $id_sales          = mysqli_real_escape_string($link,$id_sales);
            $nama_lead          = mysqli_real_escape_string($link,$nama_lead);
            $id_produk          = mysqli_real_escape_string($link,$id_produk);
            $no_wa          = mysqli_real_escape_string($link,$no_wa);
            $kota          = mysqli_real_escape_string($link,$kota);

            $id_leads;

            $get_id_lead = "SELECT id_leads FROM leads ORDER BY id_leads DESC LIMIT 1";
            $result_id_lead = mysqli_query($link, $get_id_lead);

            if ($result_id_lead->num_rows > 0) {
                $row = $result_id_lead->fetch_assoc();
                $last_is_leads = intval($row['id_leads']);
                $id_leads = $last_is_leads + 1;
            } else {
                $id_leads = 1;
            }

            $query = "INSERT INTO leads (id_leads, tanggal, id_sales, id_produk, no_wa, nama_lead, kota) VALUES ";
            $query .= "('$id_leads', '$tanggal', '$id_sales', '$id_produk', '$no_wa', '$nama_lead', '$kota')";

            $result = mysqli_query($link, $query);

            if ($result) {
                $pesan = "Data berhasil ditambahkan";
                $pesan = urldecode($pesan);
                header("Location: list.php?pesan={$pesan}");
            } 
            else {
                die ("Query gagal dijalankan: ".mysqli_errno($link).
                        " - ".mysqli_error($link));
            }
        }
    }
    else {
        $pesan_erorr = "";
        $tanggal = "";
        $nama_lead = "";
        $no_wa = "";
        $kota = "";
    }
?>

<?php 
    include("layout/head.php")
?>

<div class="container">
    <?php 
        include("layout/header.php")
    ?>
    <div class="wrap">
        <?php 
            include("layout/navbar.php")
        ?>
    </div>
    <h2>Tambah Data</h2>

    <form action=""  class="form-custom">
        <?php
            if ($pesan_erorr !== "") {
                echo "<div class=\"error\">$pesan_erorr</div>";
            }
        ?>
        <div class="wrap-form">
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" name="tanggal" id="date" class="input-custom">
            </div>
        
            <div class="form-group">
                <label for="sales">Sales:</label>
                <select name="id_sales" id="sales" class="input-custom">
                    <option value="">--Pilih Sales--</option>
                    <?php
                        $query_sales = "SELECT * FROM sales";
                        $result_sales = mysqli_query($link, $query_sales);

                        while ($row = mysqli_fetch_assoc($result_sales)) {
                            echo "<option value='" . $row['id_sales'] . "'>" . $row['nama_sales'] . "</option>";
                        }
                    ?>
                </select>
            </div>
        
            <div class="form-group">
                <label for="nama_lead">Nama Lead:</label>
                <input type="text" name="nama_lead" id="nama_lead" class="input-custom" placeholder="Nama Lead">
            </div>
        
            <div class="form-group">
                <label for="produk">Produk:</label>
                <select name="id_produk" id="produk" class="input-custom">
                    <option value="">--Pilih Produk--</option>
                    <?php 
                        $query_produk = "SELECT * FROM produk";
                        $result_produk = mysqli_query($link, $query_produk);

                        while ($row = mysqli_fetch_assoc($result_produk)) {
                            echo "<option value='" . $row['id_produk'] . "'>" . $row['nama_produk'] . "</option>";
                        }
                    ?>
                </select>
            </div>
        
            <div class="form-group">
                <label for="no_wa">No. Whatsapp:</label>
                <input type="text" name="no_wa" id="no_wa" class="input-custom" placeholder="No. Whatsapp">
            </div>
        
            <div class="form-group">
                <label for="kota">Asal Kota:</label>
                <input type="text" name="kota" id="kota" class="input-custom" placeholder="Asal Kota">
            </div>
        </div>

        <div class="wrap-button">
            <button name="submit" class="submit-custom" style="background-color: rgb(128, 128, 221);">Simpan</button>
            <a href="list.php" class="submit-custom" style="background-color: #eff163;">Cancel</a>
        </div>
    </form>

</div>
<?php 
    include("layout/footer.php")
?>
