<?php 
session_start();
if ($_SESSION) {

 ?>

<html>	
	<head>
		<title>
			Etkileşim
		</title>
	</head>
	<body>
		
	

		<?php 
		include("../db/index.php");
		$bag = new db();


		if ($_POST) {
			$k_ = $_POST["kadi"];
			$s_ = $_POST["sifre"];
			$guncel = $bag->guncelle(0, "admin", "kadi,sifre", "WHERE id=?", array($k_,$s_, 1));
			header('Refresh:1.1; url=index.php');
			

		}

		 ?>
<style>
*{
	
	margin:0px;
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
	.bu{
		border:0px;
		b
		font-weight: 550;
		color: white;
		box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
		
		background-color: #27ae60;
		width:202px;
		height: 45px;
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
	<li class="menuLi"><a href="../takip/" class="menuA">TAKİP</a></li>
	<li class="menuLi"><a href="../unfollow/" class="menuA">UNFOLLOW</a></li>
	<li class="menuLi "><a href="../etkilesim/" class="menuA">ETKİLEŞİM</a></li>
	<li class="menuLi aktif"><a href="" class="menuA">AYARLAR</a></li>
	
</ul>
	<center style="margin-top: -170px;">
		<?php 
				$bak = $bag->cek("OBJ_ALL", "admin", "kadi,sifre", "ORDER by id ASC", array());
				$varmi = count($bak);
				foreach ($bak as $ata) {?>
				<form action="" method="post">
					<input type="text" class="in"name="kadi" value="<?php echo $ata->kadi; ?>">
					<input type="text" class="in"name="sifre" value="<?php echo $ata->sifre; ?>">
					<input type="submit" class="bu" value="GÜNCELLE">
				</form>
				
					
				
<?php
		
			     }
		  ?>
			
</center>












	</body>
</html>
<?php }else{
	echo "Yasaklı Site";
	 header('Refresh:1.1; url=../index.php');
} ?>