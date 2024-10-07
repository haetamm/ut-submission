<?php 
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$link   = mysqli_connect($dbhost,$dbuser,$dbpass);

if(!$link){
  die ("Koneksi dengan database gagal: ".mysqli_connect_errno().
       " - ".mysqli_connect_error());
}

$query = "CREATE DATABASE IF NOT EXISTS united";
$result = mysqli_query($link, $query);

if(!$result){
  die ("Query Error: ".mysqli_errno($link).
       " - ".mysqli_error($link));
}
else {
  echo "Database <b>'united'</b> berhasil dibuat... <br>";
}

$result = mysqli_select_db($link, "united");

if(!$result){
  die ("Query Error: ".mysqli_errno($link).
       " - ".mysqli_error($link));
}
else {
  echo "Database <b>'united'</b> berhasil dipilih... <br>";
}

$query = "DROP TABLE IF EXISTS produk";
$hasil_query = mysqli_query($link, $query);

if(!$hasil_query){
  die ("Query Error: ".mysqli_errno($link).
       " - ".mysqli_error($link));
}
else {
  echo "Tabel <b>'produk'</b> berhasil dihapus... <br>";
}

$query  = "CREATE TABLE produk (id_produk SMALLINT UNSIGNED PRIMARY KEY, nama_produk VARCHAR(100))";

$hasil_query = mysqli_query($link, $query);

if(!$hasil_query){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
}
else {
  echo "Tabel <b>'produk'</b> berhasil dibuat... <br>";
}

$query  = "INSERT INTO produk VALUES ";
$query .= "(1, 'Cipta Residence 2'), ";
$query .= "(2, 'The Rich'), ";
$query .= "(3, 'Namorambe City'), ";
$query .= "(4, 'Grand Banten'), ";
$query .= "(5, 'Turi Mansion'), ";
$query .= "(6, 'Cipta Residence 1')";

$hasil_query = mysqli_query($link, $query);

if(!$hasil_query){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
}
else {
  echo "Tabel <b>'produk'</b> berhasil diisi... <br>";
}

$query = "DROP TABLE IF EXISTS sales";
$hasil_query = mysqli_query($link, $query);

if(!$hasil_query){
  die ("Query Error: ".mysqli_errno($link).
       " - ".mysqli_error($link));
}
else {
  echo "Tabel <b>'sales'</b> berhasil dihapus... <br>";
}

$query  = "CREATE TABLE sales (id_sales SMALLINT UNSIGNED PRIMARY KEY, nama_sales VARCHAR(50))";

$hasil_query = mysqli_query($link, $query);

if(!$hasil_query){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
}
else {
  echo "Tabel <b>'sales'</b> berhasil dibuat... <br>";
}

$query  = "INSERT INTO sales VALUES ";
$query .= "(1, 'Sales 1'), ";
$query .= "(2, 'Sales 2'), ";
$query .= "(3, 'Sales 3')";


$hasil_query = mysqli_query($link, $query);

if(!$hasil_query){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
}
else {
  echo "Tabel <b>'sales'</b> berhasil diisi... <br>";
}

$query = "DROP TABLE IF EXISTS leads";
$hasil_query = mysqli_query($link, $query);

if(!$hasil_query){
  die ("Query Error: ".mysqli_errno($link).
       " - ".mysqli_error($link));
}
else {
  echo "Tabel <b>'leads'</b> berhasil dihapus... <br>";
}

$query  = "CREATE TABLE leads (id_leads INT(3) ZEROFILL, ";
$query .= "tanggal DATE, ";
$query .= "id_sales SMALLINT UNSIGNED, ";
$query .= "id_produk SMALLINT UNSIGNED, ";
$query .= "no_wa VARCHAR(20), ";
$query .= "nama_lead VARCHAR(50), ";
$query .= "kota VARCHAR(50), ";
$query .= "id_user SMALLINT AUTO_INCREMENT PRIMARY KEY, ";
$query .= "FOREIGN KEY (`id_sales`) REFERENCES `sales` (`id_sales`), ";
$query .= "FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`))";


$hasil_query = mysqli_query($link, $query);

if(!$hasil_query){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
}
else {
  echo "Tabel <b>'leads'</b> berhasil dibuat... <br>";
}

mysqli_close($link);
?>