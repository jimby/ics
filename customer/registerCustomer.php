<?php
require_once("../Includes/db.php");

/**other variables */
$nameIsUnique = true;
$nameIsEmpty = false;
$emailaddressIsUnique = true;
$passwordIsValid = true;

$passwordIsEmpty = false;
$password2IsEmpty = false;

/** Check that the page was requested from itself via the POST method. */
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    /** Check whether the user has filled in the wisher's name in the text field "user" */
    $name = filter_input(INPUT_POST,'name');
    if ($name ===""){
        $nameIsEmpty = true;
    }

    /** Create database connection */
    $email = filter_input(INPUT_POST,'email');
    $result = CustDB::getInstance()->get_customer_id_by_email ($email);
    if ($result) {
        $emailaddressIsUnique = false;
    }

    /** Check whether a password was entered and confirmed correctly */
   /** Check whether a password was entered and confirmed correctly */
    $password = filter_input(INPUT_POST,'password');
    if ($password ==="") {
        $passwordIsEmpty = true;
    }
    $password2 = filter_input(INPUT_POST,'password2');
    if ($password2 ==="") {
        $password2IsEmpty = true;
    }
    
    if ($password !=$password2) {
        $passwordIsValid = false;
    }

    /** Check whether the boolean values show that the input data was validated successfully.
     * If the data was validated successfully, add it as a new entry in the "wishers" database.
     * After adding the new entry, close the connection and redirect the application to editWishList.php.
     */
    if (!$nameIsEmpty && $emailaddressIsUnique && !$passwordIsEmpty && !$password2IsEmpty && $passwordIsValid) {
        //$name = filter_input(INPUT_POST,'user');
        //$email = filter_input(INPUT_POST,'email');
        //$password = filter_input(INPUT_POST,'password');
        CustDB::getInstance()->create_customer($name,$email,$password);
        session_start();
        $_SESSION['email'] = $email;
        header('Location: ../index.php' );
        exit;
    }
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Register customer</title>
        <link href="wishlist.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
        <h1>Welcome!</h1>
        
        <form action="registerCustomer.php" method="POST" id="registerCustomer">
            <label>Your name:</label>
            <input type="text" name="name" autofocus/><br/>
            <label>Email:</label>
            <input type="text" name="email"/><br/>
            <?php
            /** Display error messages if "user" field is empty or there is already a user with that name*/
            if ($nameIsEmpty) {
                echo ('<div class="error">Please, enter your email address</div>');
            }
            if (!$emailaddressIsUnique) {
                echo ('<div class="error">The email address is already on file. Please check the spelling and try again</div>');
                echo $customerID;
            }
            ?>
            <label>Password:</label>
            <input type="password" name="password"/><br/>
            <?php
             /** Display error messages if the "password" field is empty */
            if ($passwordIsEmpty) {
                echo ('<div class="error">Enter the password, please</div>');
            }
            ?>
            <label>Password (Again):</label>
            <input type="password" name="password2"/><br/>
            <?php
            /**
             * Display error messages if the "password2" field is empty
             * or its contents do not match the "password" field
             */
            if ($password2IsEmpty) {
                echo ('<div class="error">Confirm your password, please</div>');
            }
            if (!$password2IsEmpty && !$passwordIsValid) {
                echo ('<div class="error">The passwords do not match.</div>');
            }
            ?>
            <br />
            <input type="submit" value="Register"/>

        </form>

    </body>
</html>