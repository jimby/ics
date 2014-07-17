<?php
  require_once("../Includes/db.php");
  $customerID = filter_input(INPUT_POST,'customerID',FILTER_SANITIZE_SPECIAL_CHARS);
  CustDB::getInstance()->delete_customer($customerID);
  header('Location: ../customer/findCustomer.php' );
  exit;
?>
