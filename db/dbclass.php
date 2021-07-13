<?php


class db {
 
protected $baglan;
//veritabanına bağlantı
public function __construct() {
    global $dbhost, $dbuser, $dbpass, $dbdata;
	   try {
    $this->baglan = new PDO("mysql:host={$dbhost};dbname={$dbdata}",$dbuser,$dbpass,
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	   } catch (PDOException $e) {
	   echo "<b>HATA:Baglantı hatası</b> ". $e->getMessage();
	   $this->kapat(); exit;
	   }
}

//veritabanı bağlantıyı kapat __destruct
public function kapat() {
    if($this->baglan) { $this->baglan = null; }
}

//doğrudan sorgu çalıstır
public function sorgu($sql, $degerler) {
	   try {
    $sonuc = $this->baglan->prepare($sql);
	$sonuc->execute($degerler);
    if ($sonuc) { return $sonuc; }else{ return false; }
	   } catch (PDOException $e) {
	   echo $this->hatabul($e->getTrace(), $e->getCode(), $e->getMessage(), $sql);
	   $this->kapat(); exit;
	   }
}

//veritabanından bilgi çek
public function cek($tip, $tabloAdi, $sutunlar, $kosul, $degerler) {
	   try {
    $sql = "SELECT " . $sutunlar . " FROM " . $tabloAdi . " " . $kosul;
    $sonuc = $this->baglan->prepare($sql);
	$sonuc->execute($degerler);
    if($tip==""){ return $sonuc; }
    if($tip=="ASSOC"){ return $sonuc->fetch(PDO::FETCH_ASSOC); }
    if($tip=="OBJ"){ return $sonuc->fetch(PDO::FETCH_OBJ); }
    if($tip=="NUM"){ return $sonuc->fetch(PDO::FETCH_NUM); }
    if($tip=="ASSOC_ALL"){ return $sonuc->fetchAll(PDO::FETCH_ASSOC); }
    if($tip=="OBJ_ALL"){ return $sonuc->fetchAll(PDO::FETCH_OBJ); }
    if($tip=="NUM_ALL"){ return $sonuc->fetchAll(PDO::FETCH_NUM); }
    if($tip=="KAYITSAY"){ return $sonuc->fetchColumn(); }
	   } catch (PDOException $e) {
	   echo $this->hatabul($e->getTrace(), $e->getCode(), $e->getMessage(), $sql);
	   $this->kapat(); exit;
	   }
}

//Tablodaki belirli kayıtları güncelle
public function guncelle($tip, $tabloAdi, $sutunlar, $kosul, $degerler) {
	$sutunlar=explode(",", $sutunlar);
    $sutundeger="";
    foreach ($sutunlar as $sutun) {
      if($tip==0){ $sutundeger .= ($sutundeger == "") ? "" : ", "; $sutundeger .= $sutun . "=?"; }
      if($tip==1){ $sutundeger .= ($sutundeger == "") ? "" : ", "; $sutundeger .= $sutun . "=$sutun+?"; }
    }
	   try {
    $sql = "UPDATE " . $tabloAdi . " SET " . $sutundeger . " " . $kosul;
	$sonuc = $this->baglan->prepare($sql);
	$sonuc->execute($degerler);
    if ($sonuc) { return $sonuc->rowCount(); }else{ return false; }
	   } catch (PDOException $e) {
	   echo $this->hatabul($e->getTrace(), $e->getCode(), $e->getMessage(), $sql);
	   $this->kapat(); exit;
	   }
}

//tabloya kayıt ekle
public function ekle($tabloAdi, $sutunlar, $degerler) {
	$deger = "";
    foreach ($degerler as $d) {
      $deger .= ($deger == "") ? "" : ","; $deger .= "?";
    }
	   try {
    $sql = "INSERT INTO $tabloAdi ($sutunlar) VALUES ($deger)";
	$sonuc = $this->baglan->prepare($sql);
	$sonuc->execute($degerler);
    if($sonuc) { return $this->baglan->lastInsertId(); }else{ return false; }
	   } catch (PDOException $e) {
	   echo $this->hatabul($e->getTrace(), $e->getCode(), $e->getMessage(), $sql);
	   $this->kapat(); exit;
	   }
}

//tablodan kayıt silme
public function sil($tabloAdi, $kosul, $degerler) {
	   try {
    $sql = "DELETE FROM " . $tabloAdi . " " . $kosul;
	$sonuc = $this->baglan->prepare($sql);
	$sonuc->execute($degerler);
    if ($sonuc) { return $sonuc->rowCount(); }else{ return false; }
	   } catch (PDOException $e) {
	   echo $this->hatabul($e->getTrace(), $e->getCode(), $e->getMessage(), $sql);
	   $this->kapat(); exit;
	   }
}

//sayfalama yapan function
public function sayfala($tip, $tabloAdi, $sutunlar, $kosul, $degerler, $toplamkayit, $sayfa, $link, $x) {
  if(empty($sayfa)) { $sayfa = 1; }
  if($sayfa < 1) $sayfa = 1; 
  $countdizi = explode(",", $sutunlar);
$kayitSayisi = $this->cek("KAYITSAY", $tabloAdi, "COUNT(".$countdizi[0].")", $kosul, $degerler);
  $toplamsayfa = ceil($kayitSayisi / $toplamkayit);
  if($sayfa > $toplamsayfa) { $sayfa = 1; }
  $baslangic = ($sayfa-1)*$toplamkayit;
$sonuc = $this->cek($tip, $tabloAdi, $sutunlar, "$kosul LIMIT $baslangic,$toplamkayit", $degerler);
  $sayfala = "";
if($kayitSayisi > $toplamkayit) {
  if($sayfa > 1){ $onceki = $sayfa-1;
	 $sayfala .="<center><ul  class='sayfalama '><li ><a style='color:green;'class='ik'href=\"".$link."1\">«</a></li>";
	 $sayfala .=""; }
  if($sayfa==1){ $sayfala .="<center><ul class='sayfalama '><li class='seciliSayfaNo'><a class=\"current\">1</a></li>";
  }elseif($sayfa-$x < 2){ $sayfala .="<li><a href=\"".$link."1\">1</a></li>"; }   
  if($sayfa-$x > 2){ $i = $sayfa-$x; }else{ $i = 2; } 
  if($sayfa-$x-10 > 0){ $sayfala .="<li><a class=\"current\" href=\"".$link.($sayfa-$x-10)."\">[".($sayfa-$x-10)."]</a></li>"; }
  for($i; $i<=$sayfa+$x; $i++) { 
    if($i==$sayfa){ $sayfala .="<li class='seciliSayfaNo'><a >$i</a></li>"; }else{ $sayfala .="<li><a href=\"".$link.$i."\">$i</a></li>"; }
    if($i==$toplamsayfa) break; 
  } 
  if($sayfa+$x+10 < $toplamsayfa){ $sayfala .="<li><a class=\"current\" href=\"".$link.($sayfa+$x+10)."\">[".($sayfa+$x+10)."]</a></li>"; }
  if($sayfa < $toplamsayfa){
	 $sonraki = $sayfa+1; $sayfala .="";
	 $sayfala .="<li ><a style='color:green;' href=\"".$link.$toplamsayfa."\">»</a></li></center>"; } 
}
  return array("veriler"=>$sonuc, "sayfalar"=>$sayfala, "toplamsayfa"=>$toplamsayfa, "toplamkayit"=>$kayitSayisi);
}

//hata detayları
private function hatabul($hata, $kodu, $mesaj, $sql) {
	$htmsj = "<b>PHP PDO HATA:</b> " . strval($kodu) . "<br><br>";
	$i=0;
    foreach ($hata as $a){
	if($i==0){ $htmsj .="<b>Class tarafı hata bilgileri</b><br>"; }else{ $htmsj .="<b>Dosya tarafı hata bilgileri</b><br>"; }
	$htmsj .= "Hatalı SQL: ". htmlspecialchars($sql) ."<br>";
	$htmsj .= "Hatalı Function: ". $a["function"] . "<br>";
	$htmsj .= "Hatalı Dosya: ". $a["file"] . "<br>";
	$htmsj .= "Hatalı Satır: ". $a["line"] . "<br><br>";
	$i++;
    }
	$htmsj .= "<b>Hata MSJ:</b> " . $mesaj;
	return $htmsj;
}

}//class db sonu
?>
