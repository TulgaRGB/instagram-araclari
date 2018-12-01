<?php 					
set_time_limit(0);
ob_start();
include("../db/index.php");
$bag = new db();
require '../vendor/autoload.php'; // kütüphaneyi çağırdık


$t_bilgi_cek = $bag->cek("OBJ_ALL", "takip", "kadi,toplam_takip", "ORDER BY id ASC", array());
foreach($t_bilgi_cek as $t_cek) {
	$c_k = $t_cek->kadi;
	$t_t = $t_cek->toplam_takip;

	$t_sifre = $bag->cek("OBJ_ALL", "hesap_list", "kadi,sifre", "WHERE kadi like ?", array($c_k));
	foreach ($t_sifre as $s_cek) {
		$k_ = $s_cek->kadi;
		$s_ = $s_cek->sifre;
	}







echo "<br> $c_k <br>";
\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true; // sorumlulukları kabul ettik | etmessek çalışmaz


$ig = new InstagramAPI\Instagram(); // classımızı çağırıyoruz


try {
    $ig->login($k_, $s_); // ins giriş yapıyoruz
    $d = 1;
} catch (\Exception $e) {

    die('Giriş Yapılamadı: ' . $e->getMessage()); // ins giriş yapamazsak hata çıktısı alıyoruz
    $d = 3;
}


if ($d != 3) {
	
	$sonuc = $bag->cek("OBJ_ALL", "takip_list", "kadi,pk,durum", "WHERE istek_kadi=? AND durum=? ORDER by id DESC limit 0,20", array($c_k,0));
	$s = 0;
	 foreach($sonuc as $satir) {
		 	

		 $pk = $satir->pk;
		 $kadi = $satir->kadi;

		 $bilgi = $ig->people->follow($pk);

		if ($bilgi) {
			echo "Takip Edildi -> <a href='https://www.instagram.com/".$kadi."/'> $kadi ->  </a><br>";
			$s++;
			
		}else{
			echo "Takip Edilemedi <a href='https://www.instagram.com/".$kadi."/'> $kadi<br>";
		}

		 $guncel = $bag->guncelle(0, "takip_list", "durum", "WHERE pk=? AND istek_kadi=?", array(1, $pk,$c_k));
	 }
	 $toplam = $t_t + $s;
	 $guncel = $bag->guncelle(0, "takip", "toplam_takip", "WHERE kadi=?", array($toplam, $c_k));
}







/*
for ($i=0; $i < 20; $i++) { 
	
	
}
*/








}






 ?>