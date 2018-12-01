<?php 


ob_start();

include("../db/index.php");
$bag = new db();
require '../vendor/autoload.php'; // kütüphaneyi çağırdık



 \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true; // sorumlulukları kabul ettik | etmessek çalışmaz


$ig = new InstagramAPI\Instagram(); // classımızı çağırıyoruz

		/////////////////////////////////
		//							   //
		//  Unfollow listesini çektik  //
		//							   //
		/////////////////////////////////

$unf_cek = $bag->cek("OBJ_ALL", "unfollow", "kadi,durum", "ORDER BY id ASC", array());
foreach($unf_cek as $al_unf) {
	$unf_kadi = $al_unf->kadi;
	$unf_durum = $al_unf->durum;



		/////////////////////////////////
		//							   //
		// İlgili hesabın kadi ve pass //
		//			Çektik			   //
		/////////////////////////////////

	$hsp_cek = $bag->cek("OBJ_ALL", "hesap_list", "kadi,sifre", "WHERE kadi like ?", array($unf_kadi));
	foreach($hsp_cek as $hsp_al) {
		$username = $hsp_al->kadi;
		$password = $hsp_al->sifre;
	}
	try {
		if ($unf_durum == 0) {
			# code...
			    
		/////////////////////////////////
		//							   //
		//        Giriş Yaptık         //
		//							   //
		/////////////////////////////////

		    $a = $ig->login($username,$password); 
		    
		/////////////////////////////////
		//							   //
		// Takip Ettiklerimizi Çektik  //
		//							   //
		/////////////////////////////////

		    $takip_liste_cek = $ig->people->getSelfFollowing(\InstagramAPI\Signatures::generateUUID());
		    $coz = json_decode($takip_liste_cek,true);
		    
		    $kac_var = count($coz["users"]);
		    
		/////////////////////////////////
		//							   //
		// Takip Edilenleri vt etledik //
		//							   //
		/////////////////////////////////

		    for ($i=0; $i < $kac_var; $i++) { 
		    	$k_id = $coz["users"][$i]["pk"];
		    	$k_kadi = $coz["users"][$i]["username"];

		    	$ekle = $bag->ekle("unfollow_list", "kadi,pk,durum,istek_kadi", array($k_kadi, $k_id,0,$unf_kadi));

		    }

	   		// durumu güncelleyerek bir sonraki sayfa yenilemede aynı verileri yazdırmasını engelledik
		    $guncel = $bag->guncelle(0, "unfollow", "durum", "WHERE kadi=?", array(1,$unf_kadi));
		}else{

		/////////////////////////////////
		//							   //
		// Tüm takip edilenler çekildi //
		//							   //
		/////////////////////////////////

			echo $unf_kadi." Bu kullanıcı daha önce analiz edildi . <br>";
		}
	    
	 
	    




	




	} catch (\Exception $e) {
	    die('Giriş Yapılamadı: ' . $e->getMessage()); // ins giriş yapamazsak hata çıktısı alıyoruz
	   
	}

}

		/////////////////////////////////
		//							   //
		//		     Bitiş			   //
		//							   //
		/////////////////////////////////




 ?>