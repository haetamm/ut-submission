<?php

    include("connection.php");
  
    if (isset($_GET["pesan"])) {
        $pesan = $_GET["pesan"];
    }

    if (isset($_GET["submit"])) {

        $nama = htmlentities(strip_tags(trim($_GET["nama"])));

        $nama = mysqli_real_escape_string($link,$nama);

        $query = "SELECT l.id_user, l.id_leads, l.tanggal, s.nama_sales, p.nama_produk, l.nama_lead, l.no_wa, l.kota ";
        $query .= "FROM leads l ";
        $query .= "LEFT JOIN sales s ON l.id_sales = s.id_sales ";
        $query .= "LEFT JOIN produk p ON l.id_produk = p.id_produk ";
        $query .= "WHERE s.nama_sales LIKE '%$nama%' OR p.nama_produk LIKE '%$nama%';";

        $pesan = "Hasil pencarian <b>\"$nama\" </b>:";
    } 
    else {
        $query = "SELECT l.id_user, l.id_leads, l.tanggal, s.nama_sales, p.nama_produk, l.nama_lead, l.no_wa, l.kota ";
        $query .= "FROM leads l ";
        $query .= "LEFT JOIN sales s ON l.id_sales = s.id_sales ";
        $query .= "LEFT JOIN produk p ON l.id_produk = p.id_produk ";
        $query .= "WHERE MONTH(l.tanggal) = MONTH(CURRENT_DATE()) AND YEAR(l.tanggal) = YEAR(CURRENT_DATE());";
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
    
        <form id="search" action="list.php" method="get">
            <p>
                <input type="text" name="nama" id="nama" placeholder="search nama produk/sales" class="custome-input" style="width: 230px;">
                <input type="submit" name="submit" value="Search" class="button-custom">
            </p>
        </form>
    </div>

    <h2>Daftar Data</h2>
    <?php
        if (isset($pesan)) {
            echo "<div class=\"pesan\">$pesan</div>";
        }
    ?>
    <div class="table-container">
        <table border="1">
            <tr>
                <th>No.</th>
                <th>ID Input</th>
                <th>Tanggal</th>
                <th>Sales</th>
                <th>Produk</th>
                <th>Nama Leads</th>
                <th>No Wa</th>
                <th>Kota</th>
            </tr>
            <?php
                $result = mysqli_query($link, $query);
                
                if(!$result){
                    die ("Query Error: ".mysqli_errno($link).
                        " - ".mysqli_error($link));
                }
            
                while($data = mysqli_fetch_assoc($result))
                { 
                    $tanggal_php = strtotime($data["tanggal"]);
                    $tanggal = date("d - m - Y", $tanggal_php);
                    
                    echo "<tr>";
                    echo "<td>$data[id_user]</td>";
                    echo "<td>$data[id_leads]</td>";
                    echo "<td>$tanggal</td>";
                    echo "<td>$data[nama_sales]</td>";
                    echo "<td>$data[nama_produk]</td>";
                    echo "<td>$data[nama_lead]</td>";
                    echo "<td>$data[no_wa]</td>";
                    echo "<td>$data[kota]</td>";
                    echo "</tr>";
                }
            
                mysqli_free_result($result);
            
                mysqli_close($link);
            ?>
        </table>
    </div>
</div>
<?php 
    include("layout/footer.php")
?>