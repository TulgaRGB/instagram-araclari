<?php


set_time_limit(0);
ob_start();
include("../db/index.php");
$bag = new db();
require '../vendor/autoload.php'; // kütüphaneyi çağırdık

session_start();

\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true; // sorumlulukları kabul ettik | etmessek çalışmaz

$ekt_cek = $bag->cek("OBJ_ALL", "yorum", "id,kadi,yorum,islem,yapilan", "ORDER BY id ASC", array());

foreach($ekt_cek as $cek_etk) {
    $k = $cek_etk->kadi;
    $ya = $cek_etk->yapilan;
    $yo = $cek_etk->yorum;
    $is = $cek_etk->islem;
    $id = $cek_etk->id;

    $kul_bilgi = $bag->cek("OBJ_ALL", "hesap_list", "kadi,sifre", "WHERE kadi like ?", array($k));

    foreach($kul_bilgi as $kul_cek) {
        $k_ = $kul_cek->kadi;
        $s_ = $kul_cek->sifre;
    }
    $max_cekt = $bag->cek("OBJ_ALL", "max_id", "id,max", "WHERE kadi=? AND tur=?", array($k,'yorum'));
    foreach ($max_cekt as $cek_m) {
        $max_id = $cek_m->id;
        $max_max = $cek_m->max;
    }

    \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true; // sorumlulukları kabul ettik | etmessek çalışmaz


    $ig = new InstagramAPI\Instagram(); // classımızı çağırıyoruz


    try {
        $ig->login($k_, $s_); // ins giriş yapıyoruz
        //$ig->setProxy('http://157.230.1.220:8080');

        $o = 0;
        $baslangic = 0;
        if ($is == 'kesfet'){
            $json_kesfet = $ig->discover->getExploreFeed();
            $kesfet = json_decode($json_kesfet,true);

            foreach ($kesfet["items"] as $items) {

                if ($o < 5) {
                    $postId = $items["media"]["id"];
                    $code = $items["media"]["code"];
                    $durum = $ig->media->comment($postId, $yo);

                    if ($durum) {
                        echo "Yorum Atıldı -> " . $code . "<br>";
                        $baslangic++;
                    } else {
                        echo "Hata " . $code . "<br>";
                    }
                    $o++;
                } else {
                    $ya = $ya + $baslangic;
                    $guncel = $bag->guncelle(0, "yorum", "yapilan", "WHERE kadi=?", array($ya, $k));
                    return "<br>İşlem Bitti -> " . $k;
                    break;
                }

            }



        }else{
            $json_kesfet = $ig->timeline->getTimelineFeed($max_max);
            $kesfet = json_decode($json_kesfet,true);
            $max_id_al_guncelle = $kesfet["next_max_id"];
            foreach ($kesfet["feed_items"] as $items) {
                $v = isset($items["media_or_ad"]);
                if ($v){

                    if ($o < 5) {
                        $postId = $items["media_or_ad"]["id"];
                        $code = $items["media_or_ad"]["code"];
                        $durum = $ig->media->comment($postId, $yo);

                        if ($durum) {
                            echo "Yorum Atıldı -> " . $code . "<br>";
                            $baslangic++;
                        } else {
                            echo "Hata " . $code . "<br>";
                        }
                        $o++;
                    } else {
                        $ya = $ya + $baslangic;
                        $mag = $bag->guncelle(0, "max_id", "max", "WHERE kadi=? AND tur=?", array($max_id_al_guncelle,$k,'yorum'));
                        $guncel = $bag->guncelle(0, "yorum", "yapilan", "WHERE kadi=?", array($ya, $k));
                        return "<br>İşlem Bitti -> " . $k;
                        break;
                    }

                }else{
                    echo "Değil<br>";
                }
            }
        }

    } catch (\Exception $e) {
        $ya = $ya + $baslangic;
        $guncel = $bag->guncelle(0, "yorum", "yapilan", "WHERE kadi=?", array($ya, $k));
        echo "Hata " . $e->getMessage();
    }





}



?>











