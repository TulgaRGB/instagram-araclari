<?php

include("../db/index.php");
$bag = new db();


if ($_POST) {
    $id = $_POST["id"];
    $k = $_POST["kadi"];
    $sil = $bag->sil("yorum", "WHERE id=?", array($id));
    if ($sil){
        $max_sil = $bag->sil("max_id", "WHERE kadi=? AND tur=?", array($k,'yorum'));
        if ($max_sil) {
            echo "Başarılı";
            header('Refresh:1.1; url=index.php');
        }else{
            echo "Max id silinemedi";
        }
        echo "Silindi";
        header('Refresh:1.1; url=index.php');

    }else{
        echo "Hata";
        header('Refresh:1.1; url=index.php');

    }
}






?>