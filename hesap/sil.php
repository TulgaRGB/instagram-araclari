<?php 

include("../db/index.php");
$bag = new db();


if ($_POST) {
	$id = $_POST["id"];
	$k = $_POST["kadi"];
	$sil = $bag->sil("hesap_list", "WHERE id=?", array($id));
	if ($sil){
	  echo "Başarılı";
	  	header('Refresh:1.1; url=index.php');
	 
	}else{
	  echo "Hata";
	  header('Refresh:1.1; url=index.php');

	}
}






 ?>