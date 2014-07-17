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
        $customerID = filter_input(INPUT_POST,'customerID',FILTER_SANITIZE_SPECIAL_CHARS);
        $back=filter_input(INPUT_POST,'back');
        
 //customers table
    $lname = filter_input(INPUT_POST,'lname');$fname = filter_input(INPUT_POST,'fname');
    $mi = filter_input(INPUT_POST,'mi');$name = filter_input(INPUT_POST,'name');$street = filter_input(INPUT_POST,'street');
    $city = filter_input(INPUT_POST,'city');$province = filter_input(INPUT_POST,'province');
    $country = filter_input(INPUT_POST,'country');$postal_code = filter_input(INPUT_POST,'postal_code');
    $phone = filter_input(INPUT_POST,'phone');$email = filter_input(INPUT_POST,'email');        
    $ship_name = filter_input(INPUT_POST,'ship_name');$ship_street = filter_input(INPUT_POST,'ship_street');
    $ship_city = filter_input(INPUT_POST,'ship_city');$ship_province = filter_input(INPUT_POST,'ship_province');
    $ship_country = filter_input(INPUT_POST,'ship_country');$ship_postal_code = filter_input(INPUT_POST,'ship_postal_code');
    $ship_phone = filter_input(INPUT_POST,'ship_phone');$ship_email = filter_input(INPUT_POST,'ship_email');
    
    /** Checks whether the $_POST array contains an element with the "back" key */
    if (array_key_exists($back)) {
        /** The Back to the List key was pressed.
         * Code redirects the user to the index.php */
        header('Location: ../customer/findCustomer.php');
        exit;
    }
        /** The "item" key in the $_POST array is NOT empty, so a item is entered.
     * Adds the street,city,province,etc  to the database via IcsDB.insert_customer
     */ 
      else if ($customerID == ""){
        CustDB::getInstance()->insert_customer($customerID,$lname,$fname,$mi,$name,$street,$city,$province,$country,$postal_code,$phone,$email,$ship_name,$ship_street,$ship_city,$ship_province,$ship_country,$ship_postal_code,$ship_phone,$ship_email);
        header('Location: customer.php');
        //exit;
    } else if (customerID != "") {
        CustDB::getInstance()->update_customer($customerID,$lname,$fname,$mi,$name,$street,$city,$province,$country,$postal_code,$phone,$email,$ship_name,$ship_street,$ship_city,$ship_province,$ship_country,$ship_postal_code,$ship_phone,$ship_email);
        header('Location: customer.php');
        exit;
    }
}    

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>editCustomer.php</title>
        <style>
            div.ex1 {
            width: 600px;
            padding: 10px;
            border: 1px solid blue;
            margin: 0px;
            float: left;
            }
            div.ex2 {
            width: 600px;
            padding: 10px;
            border: 1px solid blue;
            margin: 0px;
            float: right;
            }
            .text_line {
            clear: both;
            margin-bottom: 2px;
}
</style>
        
    </head>
    <body>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $customer =  array("id" => $_POST['customerID'],"lname" => $_POST['lname'],
                "fname" => $_POST['fname'],"mi" => $_POST['mi'],"name" => $_POST['name'],      
                "street" => $_POST['street'],"city" => $_POST['city'],
                "province" => $_POST['province'],"country" => $_POST['country'],
                "postal_code" => $_POST['postal_code'],"phone" => $_POST['phone'],
                "email" => $_POST['email'],"ship_name" => $_POST['ship_name'],
                "ship_street" => $_POST['ship_street'],"ship_province" => $_POST['ship_province'],
                "ship_country" => $_POST['ship_country'],"ship_postal_code" => $_POST['ship_postal_code'],
                "ship_phone" => $_POST['ship_phone'],"ship_email" => $_POST['ship_email']);
        }
        else if (array_key_exists("customerID", $_GET)) {
            $customer = mysqli_fetch_array(CustDB::getInstance()->get_customer_by_customer_id($_GET['customerID']));
        } else {
            $customer = array("id" => "", "lname" => "", "fname" => "","mi" => "","name" => "",
                "street" => "","city" => "","province" => "", "country" => "",
                "postal_code" => "","phone" => "", "email" => "", "ship_name" => "",
                "ship_street" => "", "ship_city" => "", "ship_province" => "",
                "ship_country" => "", "ship_postal_code" => "", "ship_phone" => "",
                "ship_email" => "");
        }
        ?>    

        <form name="editCustomers" action="editCustomer.php" method="POST">
            <input type="hidden" name="customerID" value="<?php echo $customer['id']; ?>" />
            <div class="ex1">
            
            <b> Customer information: </b>
            <br>
            
            <label>LName: </label>
            <input type="text" name="lname" value="<?php echo $customer['lname']; ?>"/>
            <br>
            <label>FName: </label>
            <input type="text" name="fname" value="<?php echo $customer['fname']; ?>"/>
            <br>
            <label>MI: </label>
            <input type="text" name="mi" value="<?php echo $customer['mi']; ?>"/>
            <br>
            <label>Name: </label>
            <input type="text" name="name" value="<?php echo $customer['name']; ?>"/>
            <br>
            <label>Telephone number: </label>
            <input type="text" name="phone" value="<?php echo $customer['phone']; ?>"/>
            <br>
            <label>Email: </label>
            <input type="text" name="email" value="<?php echo $customer['email']; ?>"/>
            <br>
            <label>Street:</label>
            <input type="text" name="street"  value="<?php echo $customer['street']; ?>"/>
            <br>
            <label>City: </label>
            <input type="text" name="city" value="<?php echo $customer['city']; ?>"/>
            <br>
            <label>Province/state: </label>
            <input type="text" name="province" value="<?php echo $customer['province'];?>"/>
            <br>
            <label>Country: </label>
            <input type="text" name="country" value="<?php echo $customer['country']; ?>"/>
            <br>
            <label>Postal code: </label>
            <input type="text" name="postal_code" value="<?php echo $customer['postal_code']; ?>"/>
            </div>
            
            <div class="ex2">
            <b> Shipping address</b>
            <br>
            
            <label>Ship to name: </label>
            <input type="text" name="ship_name" value="<?php echo $customer['ship_name']; ?>"/>
            <br>
            <label>Ship to telephone number: </label>
            <input type="text" name="ship_phone" value="<?php echo $customer['ship_phone']; ?>"/>
            <br>
            <label>Ship to email: </label>
            <input type="text" name="ship_email" value="<?php echo $customer['ship_email']; ?>"/>
            <br>
            <label>Ship to street: </label>
            <input type="text" name="ship_street" value="<?php echo $customer['ship_street']; ?>"/>
            <br>
            <label>Ship to city: </label>
            <input type="text" name="ship_city" value="<?php echo $customer['ship_city']; ?>"/>            
            <br>
            <label>Ship to province/state: </label>
            <input type="text" name="ship_province" value="<?php echo $customer['ship_province']; ?>"/>
            <br>
            <label>Ship to country: </label>
            <input type="text" name="ship_country" value="<?php echo $customer['ship_country']; ?>"/>            
            <br>
            <label>Ship to postal code: </label>
            <input type="text" name="ship_postal_code" value="<?php echo $customer['ship_postal_code']; ?>"/>
            </div>            
            <!--<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>-->
            <div>
            <p class="text_line"> <input type="submit" name="saveCustomer" value="Save Changes"/></p>
            <a class="text_line"> <input type="submit" name="back" value="return"/></a>
            </div>
        </form>
    </body>
</html>