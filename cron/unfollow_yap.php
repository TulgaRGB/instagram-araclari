<?php 

set_time_limit(0);
ob_start();
include("../db/index.php");
$bag = new db();
require '../vendor/autoload.php'; // kütüphaneyi çağırdık


$unf_bilgi_cek = $bag->cek("OBJ_ALL", "unfollow", "kadi,toplam_unfollow", "ORDER BY id ASC", array());
foreach($unf_bilgi_cek as $unf_cek) {
	$unf_kadi = $unf_cek->kadi;
	$unf_unf = $unf_cek->toplam_unfollow;

	$unf_sifre = $bag->cek("OBJ_ALL", "hesap_list", "kadi,sifre", "WHERE kadi like ?", array($unf_kadi));
	foreach ($unf_sifre as $unf_bilgi) {
		$k_ = $unf_bilgi->kadi;
		$s_ = $unf_bilgi->sifre;
	}


		\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true; // sorumlulukları kabul ettik | etmessek çalışmaz


		$ig = new InstagramAPI\Instagram(); // classımızı çağırıyoruz


		try {
		    $ig->login($k_, $s_); // ins giriş yapıyoruz
		    
		    $cek_list = $bag->cek("OBJ_ALL", "unfollow_list", "kadi,pk,durum", "WHERE istek_kadi=? AND durum=? ORDER by id ASC limit 0,20", array($unf_kadi,'0'));
			$s = 0;

		/////////////////////////////////
		//							   //
		// Tüm takip ettiklerimizi çek.//
		//							   //
		/////////////////////////////////

		    foreach($cek_list as $cek_pk) {
		    	$pk = $cek_pk->pk;
		    	$k_adi = $cek_pk->kadi;
		    	$b = $ig->people->getFriendship($pk);
		    	$a = json_decode($b,true);
		    	$sorgu = $a["followed_by"];
							
		/////////////////////////////////
		//							   //
		// Bizi Takip ediyor mu ?????  //
		//							   //
		/////////////////////////////////

			    	if ($sorgu != 1) {

		/////////////////////////////////
		//							   //
		// Takip etmiyorsa Unf atıyoz  //
		//							   //
		/////////////////////////////////

			    		$inf = $ig->people->unfollow($pk);
			    		if ($inf) {
			    			$s++;

		/////////////////////////////////
		//							   //
		// Analiz ettiklerimizi vt sil //
		//							   //
		/////////////////////////////////
			    			
			    			echo "<a href='https://www.instagram.com/".$k_adi."/'>".$k_adi."</a> -> Unf Atıldı<br>";
			    			$sil = $bag->sil("unfollow_list", "WHERE pk=?", array($pk));
			    		}else{
			    			echo "Hataaaaaa -> $k_adi";
			    		}
			    	}else{

		/////////////////////////////////
		//							   //
		// Analiz ettiklerimizi vt sil //
		//							   //
		/////////////////////////////////

			    		echo "<a href='https://www.instagram.com/".$k_adi."/'>".$k_adi."</a> -> Sizi Takip Ediyor<br>";
			    		$sil = $bag->sil("unfollow_list", "WHERE pk=?", array($pk));
			    	}
		    	
		    }

		/////////////////////////////////
		//							   //
		// Attığımız unf güncelliyoz   //
		//							   //
		/////////////////////////////////

		    $unf_unf = $unf_unf + $s;
		    $bag->guncelle(0, "unfollow", "toplam_unfollow", "WHERE kadi=?", array($unf_unf,$unf_kadi));








		} catch (\Exception $e) {

		    die('Giriş Yapılamadı: ' . $e->getMessage()); // ins giriş yapamazsak hata çıktısı alıyoruz
		    
		}













}










 ?>