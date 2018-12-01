<?php 
session_start();
include("db/index.php");
$bag = new db();

if ($_POST) {
   $k_ = $_POST["kadi"];
   $s_ = $_POST["sifre"];
   $sonuc = $bag->cek("OBJ_ALL", "admin", "kadi,sifre", "WHERE kadi=? AND sifre=?", array($k_,$s_));

   $var = count($sonuc);

   if ($var > 0) {
      $_SESSION["giris"] = 1;
      header('Refresh:1.1; url=hesap/');
   }else{
      echo "Başka Kapıya";
      header('Refresh:1.1; url=index.php');
   }







}
if ($_SESSION) {
   
 header('Refresh:1.1; url=hesap/');

 ?>

   <?php
}else{?>

<html>
    <head>
        <title>
            Giriş
        </title>
    </head>
    <body>
        
<style>
*{
    padding: 10px;
    margin:0px;
    font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
    .bu{
        border:0px;
        border-radius: 0px 0px 10px 10px;
        font-weight: 550;
        color: white;
        box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
        padding: 10px;
        background-color: #9b59b6;
        width:202px;
    }
    .in{
        width: 202px;
        border:1px dashed #8e44ad;
        box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
        padding: 10px;
    }
.menuUl{
        list-style-type: none;
        width: 200px;
    }
    .menuLi{
        padding: 5px;
        background-color: red;
        border-bottom: 1px dashed white;
    }
    .menuA{
        text-decoration: none;
        font-weight: 600;
        color:white;

    }
    .aktif{
        background-color: #c0392b;
    }
</style>
<br><br><br>
<center>
    <form action="" method="post">
        <input class="in" type="text" placeholder="Kullanıcı Adınız" name="kadi"><br><br>
        <input class="in"type="password" placeholder="Şifreniz" name="sifre"><br><br>
        <input class="bu"type="submit" value="Giriş Yap">
    </form>


</center>




    </body>
</html>
    <?php

    
}
