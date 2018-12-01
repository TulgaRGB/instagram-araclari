<?php 
set_time_limit(0);
ob_start();
include("../db/index.php");
$bag = new db();
require '../vendor/autoload.php'; // kütüphaneyi çağırdık



$list = $bag->cek("OBJ_ALL", "takip", "kadi,karsi_kadi", "ORDER BY id ASC", array());
 foreach($list as $satir) {

		$c_k = $satir->kadi;
		$karsi = $satir->karsi_kadi;
		
		$giris = $bag->cek("OBJ_ALL", "hesap_list", "kadi,sifre", "WHERE kadi like ?", array($c_k));
 		foreach ($giris as $bilgi) {
 			$g_kadi = $bilgi->kadi;
 			$g_sifre = $bilgi->sifre;
 		}
 		$max_cekt = $bag->cek("OBJ_ALL", "max_id", "id,max,kadi,tur", "WHERE kadi=? AND tur=?", array($c_k,'takip'));
		foreach ($max_cekt as $cek_m) {
 			$max_id = $cek_m->id;
 			$max_max = $cek_m->max;
 			$max_kadi = $cek_m->kadi;

 		}



 	\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true; // sorumlulukları kabul ettik | etmessek çalışmaz


$ig = new InstagramAPI\Instagram(); // classımızı çağırıyoruz


try {
    $ig->login($g_kadi, $g_sifre); // ins giriş yapıyoruz
    $d = 2;
} catch (\Exception $e) {
    die('Giriş Yapılamadı: ' . $e->getMessage()); // ins giriş yapamazsak hata çıktısı alıyoruz
    $d = 0;
}

if ($d != 0) {
	$k_id = $ig->people->getInfoByName($karsi);
$k_id_al = json_decode($k_id,true);

$kullanici_id = $k_id_al["user"]["pk"];











	if ($max_max != 2) {
		$listele = $ig->people->getFollowers($kullanici_id, \InstagramAPI\Signatures::generateUUID(),null,$max_max);

		$listele_decode = json_decode($listele,true);

		$kac_var = count($listele_decode["users"]);

		$b = 1;
		for ($b=0; $b < $kac_var; $b++) { 
			
				 // kullanıcı id
				 $pk = $listele_decode["users"][$b]["pk"];

				 // kullanıcı adı 
				 $kadi = $listele_decode["users"][$b]["username"];

				 // kullanıcı profil resmi
				 $resim = $listele_decode["users"][$b]["profile_pic_url"];

				 // veritabanına kayır
				 $ekle = $bag->ekle("takip_list", "kadi,pk,resim,durum,istek_kadi", array($kadi, $pk, $resim, 0,$c_k));

				 if ($ekle){
				    echo "$kadi -> veritabanına eklendi $b<br>";
				 }else{
				    echo "$kadi -> Hataaaa<br>";
				 }
		}

		$bittimi_sorgu = isset($listele_decode["next_max_id"]);
			if ($bittimi_sorgu == 1) {
				// max_id güncelliyoruz
				$max_guncelle = $listele_decode["next_max_id"];
				$guncel = $bag->guncelle(0, "max_id", "max", "WHERE kadi=? AND tur=?", array($max_guncelle,$c_k,'takip'));
			}else{
				$guncel = $bag->guncelle(0, "max_id", "max", "WHERE kadi=? AND tur=?", array(2,$c_k,'takip'));
			}
		
	}else{

		echo "Tüm takipçi listesini veri tabanına eklediniz";

	}

}else{
	echo "Kullanıcı adı yada şifre hatalı";
}




	














/*
for ($i=0; $i < $kac_var; $i++) { 
	$id_al = $listele_decode["users"][$i]["pk"];
	$kadi = $listele_decode["users"][$i]["username"];
	$bilgi = $ig->people->follow($id_al);

	if ($bilgi) {
		echo "Takip Edildi -> <a href='https://www.instagram.com/".$kadi."/'>$kadi -> $b </a><br>";
		$b++;
	}else{
		echo "Takip Edilemedi<br>";
	}
}
*/








 }
















 ?>