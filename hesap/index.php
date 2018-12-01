<?php 
session_start();
if ($_SESSION) {

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Hesap ekle</title>
</head>
<body>


<?php 
include("../db/index.php");
$bag = new db();

require '../vendor/autoload.php';


if ($_POST) {
	

	\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true; // sorumlulukları kabul ettik | etmessek çalışmaz


	$ig = new InstagramAPI\Instagram(); // classımızı çağırıyoruz


	try {
		$kadi = $_POST["kadi"];
		$sifre = $_POST["sifre"];
	    $ig->login($kadi, $sifre); // ins giriş yapıyoruz
	    
	    
$d =222;

	   




	} catch (\Exception $e) {
	    die('Giriş Yapılamadı: ' . $e->getMessage()); // ins giriş yapamazsak hata çıktısı alıyoruz
	    $d = 1;
	}

	if ($d != 1) {


		$bak = $bag->cek("OBJ_ALL", "hesap_list", "id,kadi", "WHERE kadi like ?", array($kadi));
		$varmi = count($bak);
		foreach ($bak as $ata) {
			$id = $ata->id;
		}
		if ($varmi > 0) {
			$current = $ig->account->getCurrentUser();
			$d = json_decode($current,true);
			
			$pk = $d["user"]["pk"];
			$kadi = $d["user"]["username"];
			$name = $d["user"]["full_name"];
			$resim = $d["user"]["profile_pic_url"];

			$guncel = $bag->guncelle(0, "hesap_list", "sifre,ad,resim", "WHERE id=?", array($sifre, $name,$resim, $id));
			if ($guncel) {
				echo "Guncellendi -> $kadi";
				header('Refresh:1.1; url=index.php');
			}else{
				echo "$kadi -> Bu hesap ekli";
				header('Refresh:1.1; url=index.php');
			}


		}else{
			$current = $ig->account->getCurrentUser();
			$d = json_decode($current,true);
			
			$pk = $d["user"]["pk"];
			$kadi = $d["user"]["username"];
			$name = $d["user"]["full_name"];
			$resim = $d["user"]["profile_pic_url"];


		 $ekle = $bag->ekle("hesap_list", "kadi,sifre,ad,resim", array($kadi, $sifre, $name,$resim));

		 if ($ekle) {
		 	echo "$kadi -> Eklendi";
		 	header('Refresh:1.1; url=index.php');

		 }else{
		 	echo "$kadi -> eklenemedi";
		 	header('Refresh:1.1; url=index.php');
		 }
		}
			

	}
		}
	










	



 ?>

<style>
*{
	padding: 10px;
	margin:0px;
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
	.bu{
		border:0px;
		border-radius: 0px 0px 10px 10px;
		font-weight: 550;
		color: white;
		box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
		padding: 10px;
		background-color: #9b59b6;
		width:202px;
	}
	.in{
		width: 180px;
		border:1px dashed #8e44ad;
		box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
		padding: 10px;
	}
.menuUl{
		list-style-type: none;
		width: 200px;
	}
	.menuLi{
		padding: 5px;
		background-color: red;
		border-bottom: 1px dashed white;
	}
	.menuA{
		text-decoration: none;
		font-weight: 600;
		color:white;

	}
	.aktif{
		background-color: #c0392b;
	}
</style>

<ul class="menuUl">
	<li class="menuLi aktif"><a href="" class="menuA ">HESAP İŞLEM</a></li>
	<li class="menuLi "><a href="../takip/" class="menuA">TAKİP</a></li>
	<li class="menuLi"><a href="../unfollow/" class="menuA">UNFOLLOW</a></li>
	<li class="menuLi "><a href="../etkilesim/" class="menuA">ETKİLEŞİM</a></li>
	<li class="menuLi "><a href="../ayarlar/" class="menuA">AYARLAR</a></li>
</ul>
	<center style="margin-top: -170px;">
<form action="" method="post">
	<input class="in" type="text" name="kadi" placeholder="Kullanıcı adı"><br><br>
    <input class="in"type="text" name="sifre" placeholder="Şifre"><br><br>
	<button class="bu" type="submit"   placeholder="Şifre"> Giriş Yap</button>

</form>
</center>

<br>
<hr style="background-color: #27ae60;">


<center>
	<h1>Ekli Hesaplar</h1>
<table>
	
	<tbody>
		<?php 

		$cek = $bag->cek("OBJ_ALL", "hesap_list", "id,kadi,sifre,ad,resim", "ORDER BY id ASC", array());
		foreach($cek as $sat) {
			



		 ?>
		<tr>
			<td><img style="height: 60px;width: 60px;border-radius: 100px;" src="<?php echo $sat->resim; ?>" alt=""></td>
			<td><font style="font-weight: 550;font-size: 20px;"><?php echo $sat->ad; ?></font></td>
			<td><?php echo $sat->kadi; ?></td>
			<td><?php echo $sat->sifre; ?></td>
			<td>
			  <form action="sil.php" method="post">
				<input  class="in"type="hidden" name="id" value="<?php echo $sat->id; ?>">
				<input  class="in"type="hidden" name="kadi" value="<?php echo $sat->kadi; ?>">
			    <input style="border-radius: 100px;margin-top: -px;background-color: red;width: 50px;" class="bu" type="submit" value="SİL">
			  </form>
			</td
		</tr>
	<?php } ?>
	</tbody>
</table>



</center>



</body>
</html>
<?php }else{
	echo "Yasaklı Site";
	 header('Refresh:1.1; url=../index.php');
} ?>