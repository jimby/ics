<?php
session_start();
//if (!array_key_exists("user", $_SESSION)) {
//    header('Location: ../index.php');
//    exit;
//}

/** Create a new database object */
require_once("../Includes/db.php");

/** Checks that the Request method is POST, which means that the data
 * was submitted from the form for entering the wish data on the editWish.php
 * page itself */
   if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $userID = filter_input(INPUT_POST,'userID',FILTER_SANITIZE_SPECIAL_CHARS);
        $back=filter_input(INPUT_POST,'back');
        
 //users table
        $name = filter_input(INPUT_POST,'name');
        $password = filter_input(INPUT_POST,'password');
    
    /** Checks whether the $_POST array contains an element with the "back" key */
    if ($back==="return") {
        /** The Back to the List key was pressed.
         * Code redirects the user to the index.php */
        header('Location: users.php');
        exit;
    }
        /** The "item" key in the $_POST array is NOT empty, so a item is entered.
     * Adds the street,city,province,etc  to the database via IcsDB.insert_customer
     */ 
      else if ($userID == ""){
        //CustDB::getInstance()->insert_user($userID,$name,$password); //registeruser!
        header('Location: registerUser.php');
        exit;
    } else if (userID != "") {
        UserDB::getInstance()->update_user($name,$password);
        header('Location: users.php');
        exit;
    }
}    

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>editUser.php</title>
        
    </head>
    <body>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user =  array("id" => $_POST['userID'],"name" => $_POST['name'],"password" => $_POST['password']);      
        }
        else if (array_key_exists("userID", $_GET)) {
            $user = mysqli_fetch_array(UserDB::getInstance()->get_user_by_user_id($_GET['userID']));
        } else {
            $user = array("id" => "", "name" => "", "password" => "");
        }
        ?>    

        <form name="editUsers" action="editUser.php" method="POST">
            <input type="hidden" name="userID" value="<?php echo $user['id']; ?>" />
            <div id="box1" style="height:100;width:1000 pix;background-color:#cbe3f3;float:left;">
            
            <b> User information: </b>
            <br>
            
            <label>Name: </label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>"/>
            <br>
            <label>Password: </label>
            <input type="text" name="password" value="<?php echo $user['password']; ?>"/>
            <br>
             </div>            
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div>
            <input type="submit" name="saveUser" value="save"/>
            <input type="submit" name="back" value="return"/>
            </div>
        </form>
    </body>
</html>
