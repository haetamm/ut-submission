<?php 
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $name = "united";
    $link = mysqli_connect($dbhost, $dbuser, $dbpass, $name);

    if(!$link){
        die ("Koneksi dengan database gagal: ".mysqli_connect_errno().
             " - ".mysqli_connect_error());
      }
?>