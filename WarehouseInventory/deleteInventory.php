<?php
  require_once("../Includes/db.php");
  
  WarInvDB::getInstance()->delete_item ($_POST['itemID']);
  header('Location: editWarehouseInventory.php' );
?>
