<?php
  require_once("../Includes/db.php");
  $userID = filter_input(INPUT_POST,'userID',FILTER_SANITIZE_SPECIAL_CHARS);
  UserDB::getInstance()->delete_user($userID);
  header('Location: users.php' );
  exit;
?>
