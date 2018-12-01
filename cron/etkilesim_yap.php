<?php


set_time_limit(0);
ob_start();
include("../db/index.php");
$bag = new db();
require '../vendor/autoload.php'; // kütüphaneyi çağırdık

session_start();

\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true; // sorumlulukları kabul ettik | etmessek çalışmaz

 $ekt_cek = $bag->cek("OBJ_ALL", "etkilesim", "kadi,toplam", "ORDER BY id ASC", array());
 foreach($ekt_cek as $cek_etk) {
 	$kadi = $cek_etk->kadi;
 	$sifre = $cek_etk->toplam;

 	$kul_bilgi = $bag->cek("OBJ_ALL", "hesap_list", "kadi,sifre", "WHERE kadi like ?", array($kadi));
   
    foreach($kul_bilgi as $kul_cek) {
    	$k_ = $kul_cek->kadi;
    	$s_ = $kul_cek->sifre;
    }
 
$ig = new InstagramAPI\Instagram(); // classımızı çağırıyoruz


try {
    $ig->login($k_, $s_); // ins giriş yapıyoruz

    $json = $ig->timeline->getTimelineFeed(); // anasayfamızdaki paylaşımları alıyoruz
$b = json_decode($json,true); //


$kac = count($b["feed_items"]);




echo "<br>$k_ <br><br>";
// for döngüsüne sokarak birdençok işlem yaptırıyoruz $kac' a ulaştığı zaman sistem duruyor
for ($i=0; $i < $kac; $i++) {

    $oneri = isset($b["feed_items"][$i]["suggested_users"]); // Anasayfamızdaki önerilen kullanıcı varmı sorgusu
    $netgeo = isset($b["feed_items"][$i]["stories_netego"]);  // Tam olarak bilmiyorum , sanırım anasayfadaki hikayeler

    if($netgeo == 0){ // hikayeleri es geçiyoruz
        if ($oneri == 0) { // önerilen kullanıcıları es geçiyoruz

            $p_id = $b["feed_items"][$i]["media_or_ad"]["id"]; // paylaşım id'lerini alıyoruz
            $varmi = isset($b["feed_items"][$i]["media_or_ad"]); // paylaşım varmı diye soruyoruz
            if ($varmi == 1) {

                $k = $b["feed_items"][$i]["media_or_ad"]["user"]["username"]; // paylaşanın kullanıcı adı
                $q = $b["feed_items"][$i]["media_or_ad"]["code"]; // paylaşanın post linki
                $b_sorgu = $b["feed_items"][$i]["media_or_ad"]["has_liked"]; // daha önceden beğendikmi sorgusu
                $sponsor_sorgu = isset($b["feed_items"][$i]["media_or_ad"]["injected"]); // sponsorlu mu sorgusu

                if($sponsor_sorgu == 0){ // sponsorluysa beğenme
                    if($b_sorgu != 1){	// önceden beğendiklerimizi es geçiyoruz
                        $begen = $ig->media->like($p_id); // Paylaşıma beğeni gönderiyoruz
                        if ($begen) { // işlemi sorguluyoruz

                            echo $k." Kullanıcısına Beğeni Gönderildi -> <a href='https://www.instagram.com/p/".$q."/'>link</a><br>";

                        }else{

                            echo "Beğeni Gönderlilemedi ".$k;
                        }
                    }else{
                        echo "Daha Önceden beğenilmiş Paylaşım $q<br>";
                    }
                }else{
                    echo "Sponsorlu İçerik Beğenilmedi<br>";
                }


            }else{
                echo "Kullanıcı Sıralanmadı<br>";
            }

        }else{
            echo "Önerilen Kullanıcı<br>";

        }
    }else{
        echo "Netgeo<br>";
    }
}
} catch (\Exception $e) {
    die('Giriş Yapılamadı: ' . $e->getMessage()); // ins giriş yapamazsak hata çıktısı alıyoruz
}


	




}





// injected -> sponsorlu Paylaşım










?>











