<?php 
session_start();
if ($_SESSION) {

 ?>
 <html>	
	<head>
		<title>
			Takip Ekle
		</title>
	</head>
	<body>
		
	

		<?php 
		include("../db/index.php");
		$bag = new db();


		if ($_POST) {
			$k = $_POST["kadi"];

			$kr = $_POST["karsi"];

			$bak = $bag->cek("OBJ_ALL", "takip", "kadi", "WHERE kadi like ?", array($k));
			$varmi = count($bak);

			if ($varmi > 0) {
				$guncel = $bag->guncelle(0, "takip", "kadi,karsi_kadi", "WHERE kadi=?", array($k, $kr, $k));
					if ($guncel) {
						$max_guncelle = $bag->guncelle(0, "max_id", "max", "WHERE kadi=? AND tur=?", array('', $k, 'takip'));
						if ($max_guncelle) {
							echo "Guncellendi -> $k";
							header('Refresh:1.1; url=index.php');
						}else{
							echo "Hata -> $k";
							header('Refresh:1.1; url=index.php');
						}
						
					}else{
						echo "$k -> Bu hesap ekli";
						header('Refresh:1.1; url=index.php');
					}
			}else{
				$ekle = $bag->ekle("takip", "kadi,karsi_kadi,toplam_takip", array($k, $kr,0));
				if ($ekle){
				 	echo "$k -> takip listesine eklendi";
				 	$max = $bag->ekle("max_id", "max,kadi,tur", array('', $k,'takip'));
				 	if ($max) {
				 		echo " $k -> Max listesine eklendi";
				 	}
				 	header('Refresh:1.1; url=index.php');
				}else{
					echo "$k -> takip listesine Hataa";
					header('Refresh:1.1; url=index.php');
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
		width: 202px;
		border:1px dashed #8e44ad;
		box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
		padding: 10px;
	}
	.sec{
		border:1px dashed #8e44ad;
		width: 202px;
		
		box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
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
	<li class="menuLi "><a href="../hesap/" class="menuA ">HESAP İŞLEM</a></li>
	<li class="menuLi aktif"><a href="" class="menuA">TAKİP</a></li>
	<li class="menuLi"><a href="../unfollow/" class="menuA">UNFOLLOW</a></li>
	<li class="menuLi "><a href="../etkilesim/" class="menuA">ETKİLEŞİM</a></li>
	<li class="menuLi "><a href="../upload/" class="menuA">Zamanlı Paylaşım</a></li>
	<li class="menuLi "><a href="../ayarlar/" class="menuA">AYARLAR</a></li>
</ul>
	<center style="margin-top: -190px;">
		<form action="" method="post">
			<select class="sec" name="kadi" >
				<?php 
				$bak = $bag->cek("OBJ_ALL", "hesap_list", "kadi", "ORDER by id ASC", array());
				$varmi = count($bak);
				foreach ($bak as $ata) {
					
				
		 ?>
				<option class="op" value="<?php echo $ata->kadi; ?>"><?php echo $ata->kadi; ?></option>
			<?php } ?>
			</select><br><br>
			<input class="in"type="text" name="karsi" placeholder="Karşı Kadi"><br><br>
			<input class="bu" type="submit" value="İstek Ekle">
		</form>
</center>

<hr style="background-color: #3498db;">
<center>
	<h1>Takip Listesi</h1>
<table>
	
	<tbody>
		<?php 

		$cek = $bag->cek("OBJ_ALL", "takip", "id,kadi,karsi_kadi,toplam_takip", "ORDER BY id ASC", array());
		foreach($cek as $sat) {
			



		 ?>
		<tr>
			<td><?php echo $sat->kadi; ?></td>
			<td><?php echo $sat->karsi_kadi; ?></td>
			<td><?php echo $sat->toplam_takip; ?></td>
			<td>
			  <form action="sil.php" method="post">
				<input  class="in"type="hidden" name="id" value="<?php echo $sat->id; ?>">
				<input  class="in"type="hidden" name="kadi" value="<?php echo $sat->kadi; ?>">
			    <input style="border-radius: 100px;margin-top: -px;background-color: red;width: 50px;" class="bu" type="submit" value="SİL">
			  </form>
			</td>
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