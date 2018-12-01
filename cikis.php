<?php
 session_start();
 session_destroy(); 
 header('Refresh:1.1; url=index.php');

 ?>