<!--newOrder.php-->
<?php
require_once("Includes/db.php");
session_start();
//filter mvars
$customerID = filter_input(INPUT_POST,'customerID',FILTER_SANITIZE_NUMBER_INT);
$name = filter_input(INPUT_POST,'name');$street = filter_input(INPUT_POST,'street');
$city = filter_input(INPUT_POST,'city');$province = filter_input(INPUT_POST,'province');
$country = filter_input(INPUT_POST,'country');$postal_code = filter_input(INPUT_POST,'postal_code');
$phone = filter_input(INPUT_POST,'phone');$email = filter_input(INPUT_POST,'email');        
$ship_name = filter_input(INPUT_POST,'ship_name');$ship_street = filter_input(INPUT_POST,'ship_street');
$ship_city = filter_input(INPUT_POST,'ship_city');$ship_province = filter_input(INPUT_POST,'ship_province');
$ship_country = filter_input(INPUT_POST,'ship_country');$ship_postal_code = filter_input(INPUT_POST,'ship_postal_code');
$ship_phone = filter_input(INPUT_POST,'ship_phone');$ship_email = filter_input(INPUT_POST,'ship_email');
$back=filter_input(INPUT_POST,'back');

if (!array_key_exists("name", $_SESSION)) {
    $customerID = filter_input(INPUT_POST,'customerID',FILTER_SANITIZE_SPECIAL_CHARS); 
    $_SESSION['customerID']=$customerID;
    }
else{
    $customerID=$_SESSION['customerID'];
    }
    
if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $customerID = filter_input(INPUT_POST,'customerID',FILTER_SANITIZE_SPECIAL_CHARS);
        $back=filter_input(INPUT_POST,'back');
    /** Checks whether the $_POST array contains an element with the "back" key */
    if (array_key_exists($back)) {
        /** The Back to the List key was pressed.
         * Code redirects the user to the index.php */
        header('Location: index.php');
        exit;
    }
        /** The "item" key in the $_POST array is NOT empty, so a item is entered.
     * Adds the street,city,province,etc  to the database via IcsDB.insert_customer
     */ 
      else if ($customerID == ""){
        IcsDB::getInstance()->insert_($customerID,$onumber,$odate,$custID,$custOrderNo,$custOrderDt,$oSubT,$oTax,$oShipChg,$oTot);
        //header('Location: customer.php');
        //exit;
    } else if (customerID != "") {
        IcsDB::getInstance()->update_customer($customerID,$onumber,$odate,$custID,$custOrderNo,$custOrderDt,$oSubT,$oTax,$oShipChg,$oTot);
        //header('Location: customer.php');
        //exit;
    }
}    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ICS Application</title>
        
    </head>
    <body>
        <?php
        
        if ($customerID) {
            $customer = mysqli_fetch_array(IcsDB::getInstance()->get_customer_by_customer_id($customerID));
        } else {
            $customer = array("id" => "", "name" => "", "street" => "", "city" => "","province" => "","country" => "","postal_code" => "","phone" => "","email" => "","ship_name"=>"","ship_street"=>"","ship_city"=>"","ship_province"=>"","ship_country"=>"","ship_postal_code"=>"","ship_phone"=>"","ship_email"=>"");
        }
        ?>
  <form name="newOrder" action="newOrder.php" method="POST">
            <input type="hidden" name="customerID" value="<?php echo $customer['id']; ?>" />
            <div id="box1" style="height:100;width:1000 pix;background-color:#ffd700;float:left;">
            
            <b> Customer information: </b>
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
            
            <div id="box2" style="height:100;width:1000 pix;background-color:#ffd700;float:left;">
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
            <br><br><br><br><br><br><br><br><br><br><br><br>
          <input type="submit" name="saveCustomer" value="Save Changes"/>
          <input type="submit" name="back" value="Back to the List"/>
            
        </form>
    </body>
</html>