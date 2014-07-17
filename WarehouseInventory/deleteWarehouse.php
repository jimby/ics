<?php
  require_once("../Includes/db.php");
  
  WareDB::getInstance()->delete_warehouse ($_POST['warehouseID']);
  header('Location: editWishList.php' );
?>
