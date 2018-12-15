<?php
set_time_limit(0);
ob_start();
date_default_timezone_set('Europe/Istanbul');


$saat = date('H');
$dakika = date('i');
$tarih = $saat.":".$dakika;

include("../db/index.php");
$bag = new db();
require '../vendor/autoload.php'; // kütüphaneyi çağırdık


$t_bilgi_cek = $bag->cek("OBJ_ALL", "post", "id,resim,kadi,aciklama", "WHERE tarih=? AND durum=?", array($tarih,0));

foreach($t_bilgi_cek as $t_cek) {
    $Id = $t_cek->id;
    $Resim = $t_cek->resim;
    $Kadi = $t_cek->kadi;
    $Aciklama = $t_cek->aciklama;


    $t_sifre = $bag->cek("OBJ_ALL", "hesap_list", "kadi,sifre", "WHERE kadi like ?", array($Kadi));
    foreach ($t_sifre as $s_cek) {
        $k_ = $s_cek->kadi;
        $s_ = $s_cek->sifre;
    }


    \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true; // sorumlulukları kabul ettik | etmessek çalışmaz


    $ig = new InstagramAPI\Instagram(); // classımızı çağırıyoruz

    try{
        $ig->login($k_,$s_);

        $photo = '../upload/resimler/'.$Resim;
        $metadata = [
            'caption' => $Aciklama
        ];

        $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($photo);
        $a = $ig->timeline->uploadPhoto($photo->getFile(), $metadata);
        if ($a){
            $guncel = $bag->guncelle(0, "post", "durum", "WHERE id=?", array(1, $Id));

            if ($guncel){
                echo ": Post Atıldı";
             }else{
             echo "Post Atılamadı";
             }
        }




    }catch (Exception $e){
        echo "Hata: ". $e->getMessage();
    }












    /*
    for ($i=0; $i < 20; $i++) {


    }
    */








}






?>