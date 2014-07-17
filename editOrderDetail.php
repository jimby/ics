
<!-- newOrderDetail.php -->

<?php
//database utilities
require_once("Includes/orders.php");
session_start();
if (!array_key_exists("customerID", $_SESSION)) {
    $customerID = filter_input(INPUT_POST,'customerID',FILTER_SANITIZE_SPECIAL_CHARS); 
    $_SESSION['customerID']=$customerID;
    }
else{
    $customerID=$_SESSION['customerID'];

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
        $customerID = filter_input(INPUT_POST,'customerID',FILTER_SANITIZE_SPECIAL_CHARS);
        $orderID = filter_input(INPUT_POST,'onumber');$odate = filter_input(INPUT_POST,'odate');
        $custID = filter_input(INPUT_POST,'custID');$custOrderNo = filter_input(INPUT_POST,'custOrderNO');
        $custOrderDt = filter_input(INPUT_POST,'custOrderDt');$oSubT = filter_input(INPUT_POST,'oSubT');
        $oTax = filter_input(INPUT_POST,'oTax');$oShipChg = filter_input(INPUT_POST,'oShipChg');
        $oTot = filter_input(INPUT_POST,'oTot');
        }
  //huh?-->     if ($customerID) {
  //          $order = mysqli_fetch_array(IcsDB::getInstance()->get_order_by_customer_id($customerID));
  //      } else {
  //          $order = array("id" => "", "onumber" => "", "odate" => "", "custID" => "","custOrderNo" => "","custOrderDt" => "","oSubT" => "","oTax" => "","oShipChg" => "","oTot"=>"");
        }
        ?>
        <form name="addOrderDetail" action="newOrderDetail.php" method="POST">
            <input type="hidden" name="customerID" value="<?php echo $customer['id']; ?>" />
            <div id="box1" style="height:100;width:1000 pix;background-color:#ffd700;float:left;">
            
            <b> Order Detail: </b>
            <br>
            <label>Order ID: </label>
            <input type="text" name="orderid" value="<?php echo $orderdetail['orderid']; ?>"/>
            <br>
            <label>Inventory ID: </label>
            <input type="text" name="inventoryid" value="<?php echo $orderdetail['inventoryid']; ?>"/>
            <br>
            <label>Item number: </label>
            <input type="text" name="itemNo" value="<?php echo $orderdetail['itemNo']; ?>"/>
            <br>
            <label>Item discount:</label>
            <input type="text" name="itemDisc"  value="<?php echo $orderdetail['itemDisc']; ?>"/>
            <br>
            <label>Item total: </label>
            <input type="text" name="itemTot" value="<?php echo $orderdetail['itemTot']; ?>"/>
            <br>
            
            </div>
            
                        
            <br><br><br><br><br><br><br><br><br><br><br><br>
            <input type="submit" name="saveCustomer" value="Save Changes"/>
            <input type="submit" name="back" value="Back to the List"/>
            
        </form>
    </body>
</html>