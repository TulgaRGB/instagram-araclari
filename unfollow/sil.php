<?php 

include("../db/index.php");
$bag = new db();


if ($_POST) {
	$id = $_POST["id"];
	$k = $_POST["kadi"];
	$sil = $bag->sil("unfollow", "WHERE id=?", array($id));
	if ($sil){
	  
	  	$max_sil = $bag->sil("max_id", "WHERE kadi=? AND tur=?", array($k,'unfollow'));
	  	if ($max_sil) {
	  		echo "Başarılı";
	  		header('Refresh:1.1; url=index.php');
	  	}else{
	  		echo "Max id silinemedi";
	  	}
	 
	}else{
	  echo "Hata";
	  header('Refresh:1.1; url=index.php');

	}
}






 ?>