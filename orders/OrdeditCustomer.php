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
 
 //order table
    $onumber;
    $odate;
    $custOrdNo;
    $custOrderDt;
    $oSubt;
    $oTax;
    $oShipChg;
    $oTot;
    
 //order detail table
    $orderID;
    $inventoryID;
    $itemNo;
    $itemPrice;
    $itemDisc;
    $itemTot;
    
    /** Checks whether the $_POST array contains an element with the "back" key */
    if (array_key_exists($back)) {
        /** The Back to the List key was pressed.
         * Code redirects the user to the index.php */
        header('Location: ../orders/Orders.php');
        exit;
    }
        /** The "item" key in the $_POST array is NOT empty, so a item is entered.
     * Adds the street,city,province,etc  to the database via IcsDB.insert_customer
     */ 
      else if ($customerID == ""){
        CustDB::getInstance()->insert_customer($customerID,$lname,$fname,$mi,$name,$street,$city,$province,$country,$postal_code,$phone,$email,$ship_name,$ship_street,$ship_city,$ship_province,$ship_country,$ship_postal_code,$ship_phone,$ship_email);
        header('Location: ../orders/Orders.php');
        //exit;
    } else if (customerID != "") {
        CustDB::getInstance()->update_customer($customerID,$lname,$fname,$mi,$name,$street,$city,$province,$country,$postal_code,$phone,$email,$ship_name,$ship_street,$ship_city,$ship_province,$ship_country,$ship_postal_code,$ship_phone,$ship_email);
        header('Location: ../orders/Orders.php');
        exit;
    }
}    

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>OrdeditCustomer.php</title>
        <style> 
div.container {
    width: 60em;
    border: .1em solid;
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

        <form name="editCustomers" action="OrdeditCustomer.php" method="POST">
            <input type="hidden" name="customerID" value="<?php echo $customer['id']; ?>" />
            
            
            <b> Customer information: </b>
            <br>
            
            <div class="ex1">
            <b>Billing address </b><br>
            <input type="text" name="fname" value="<?php echo $customer['fname'];    ?>"/>
            <input type="text" name="mi"    value="<?php echo $customer['mi']   ;    ?>"/>
            <input type="text" name="lname" value="<?php echo $customer['lname'];    ?>"/>
            <br>
            <input type="text" name="street" value="<?php echo $customer['street']; ?>"/>
            <br>
            <input type="text" name="city"  value="<?php echo $customer['city']; ?>"/>
            <input type="text" name="province" value="<?php echo $customer['province'];?>"/>
            <input type="text" name="country" value="<?php echo $customer['country']; ?>"/>
            <input type="text" name="postal_code"  value="<?php echo $customer['postal_code']; ?>"/>
            </div>
            
            <div class="ex2">
            <b> Shipping address</b>
            <br>
            <input type="text" name="ship_name" value="<?php echo $customer['ship_name']; ?>"/>
            <br>
            <input type="text" name="ship_street" value="<?php echo $customer['ship_street']; ?>"/>
            <br>
            <input type="text" name="ship_city" value="<?php echo $customer['ship_city']; ?>"/>            
            <input type="text" name="ship_province" value="<?php echo $customer['ship_province']; ?>"/>
            <input type="text" name="ship_country" value="<?php echo $customer['ship_country']; ?>"/>            
            <input type="text" name="ship_postal_code" value="<?php echo $customer['ship_postal_code']; ?>"/>
            </div>            

            <div>
            </div>
            <div>
            <br>
            <input type="submit" name="saveCustomer" value="Save Changes"/>
            <input type="submit" name="back" value="return"/>
            </div>
        </form>
    </body>
</html>