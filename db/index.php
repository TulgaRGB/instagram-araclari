<?php 

ob_start();
	
$dbhost = "localhost"; //Veritabanın bulunduğu host
$dbuser = "root"; //Veritabanı Kullanıcı Adı
$dbpass = ""; //Veritabanı Şifresi
$dbdata = "instagram"; //Veritabanı Adı

include("dbclass.php"); //veritabani class dosyamızı dahil ediyoruz
$bag = new db(); // db class'imizla $bag nesnemizi olusturduk



// veri çekmek => $sonuc = $bag->cek("OBJ_ALL", "hesap", "kadi,resim,id", "ORDER BY id ASC", array());
// foreach($sonuc as $satir) {
// echo "Haber id: ".$satir->resim;
// echo "<hr>";
// }


 // veri ekleme => $ekle = $bag->ekle("ayarlar", "kadi,sifre,key1,key_secret", array("sasada", "asdasdad", "sadasddas","sad"));
 //$ekle bize yeni kaydın id no yu verecektir false dönerse kayıt varsa gibi durumlar için kontrolu yapalım 
 // if ($ekle){
 //  echo "Haber " .$ekle. " nolu id'e eklendi";
 // }else{
 // echo "Kayit eklenmedi";
 // }

// veri güncelleme =>  $guncel = $bag->guncelle(0, "ayarlar", "kadi,sifre", "WHERE id=?", array("sssss","sif", 3));
// if ($guncel){
//  echo $guncel. ": haber guncellendi";
// }else{
//  echo "haber guncellenmedi";
// }

// veri silme => $sil = $bag->sil("ayarlar", "WHERE id=?", array(3));
// if ($sil){
//  echo $sil. ": haber silindi";
// }else{
//  echo "kayit YOK";
// }


$bag->kapat();// $bag nesnemizi kapattik

ob_end_flush();





?>