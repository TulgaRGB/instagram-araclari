<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 15.12.2018
 * Time: 21:25
 */

include("../db/index.php");
$bag = new db();

 if(isset($_FILES['dosya'])){
    $v = $_POST["kadi"];
    $t = $_POST["tarih"];
    $a = $_POST["aciklama"];
    $video_name = $_FILES["dosya"]["name"];
    $tip = $_FILES["dosya"]["type"];
    $rand = rand(5, 10005);
    if (strstr($tip, "jpeg") || strstr($tip, "jpg") || strstr($tip, "png")){
        $newname="resimler/".$v."_".$rand.".jpeg";
        $orig = isset($_FILES['dosya']) && isset($_FILES['dosya']['tmp_name']) ? $_FILES['dosya']['tmp_name'] : '';
        if (empty($orig)) {
            echo "Uploaded file doesn't exist.";
        }
        $copied = move_uploaded_file($orig, $newname);



        $r_1 = $v.'_'.$rand.'.jpeg';

        $ekle = $bag->ekle("post", "resim,durum,tarih,kadi,aciklama", array($r_1, 0, $t,$v,$a));
        if ($ekle){
          echo "Post " .$ekle. " nolu id'e eklendi";
            header('Refresh:1.1; url=index.php');
        }else{
          echo "Kayit eklenmedi";
            header('Refresh:1.1; url=index.php');
        }
    }

}
