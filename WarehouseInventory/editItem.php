<?php
/* * Start session */
session_start();
require_once("../Includes/db.php");
if (!array_key_exists("warehouseID", $_SESSION)) {
    header('Location:getWID_eInv.php ');
    exit;
}
else {
    $warehouseID=(int)$_SESSION['warehouseID'];
    }
if ($_SERVER['REQUEST_METHOD'] == "POST") {
         //$warehouseID = filter_input(INPUT_POST,'warehouseID',FILTER_SANITIZE_SPECIAL_CHARS);              //filter uninitializes warehouseID
        $product = filter_input(INPUT_POST,'product',FILTER_SANITIZE_SPECIAL_CHARS);
        $cost = filter_input(INPUT_POST,'cost',FILTER_SANITIZE_SPECIAL_CHARS);
        $qoh = filter_input(INPUT_POST,'qoh',FILTER_SANITIZE_SPECIAL_CHARS);
        $DatePlanted = filter_input(INPUT_POST,'DatePlanted',FILTER_SANITIZE_SPECIAL_CHARS);
        $DateReady = filter_input(INPUT_POST,'DateReady',FILTER_SANITIZE_SPECIAL_CHARS);
        $SeedTransplant = filter_input(INPUT_POST,'SeedTransplant',FILTER_SANITIZE_SPECIAL_CHARS);
        $LotNumber = filter_input(INPUT_POST,'LotNumber',FILTER_SANITIZE_SPECIAL_CHARS);
        $description= filter_input(INPUT_POST,'description',FILTER_SANITIZE_SPECIAL_CHARS);    
// Checks whether the $_POST array contains an element with the "back" key */
    if (array_key_exists("back", $_POST)) {
        /** The Back to the List key was pressed.
         * Code redirects the user to the editWarehouseInventory.php */
        header('Location: editWarehouseInventory.php');
        exit;
    }else if ($_POST['itemID'] === "") {
        WarInvDB::getInstance()->insert_item($warehouseID, $product, $cost, $qoh,
            $DatePlanted, $DateReady,$SeedTransplant,$LotNumber,$description);
            header('Location: editWarehouseInventory.php');
	    exit;
    } else if ($_POST['itemID'] != "") {
            $itemID=(int) filter_input(INPUT_POST,'itemID',FILTER_SANITIZE_NUMBER_INT); 
            //InvDB::getInstance()->update_inventory($warehouseID, $qoh, $product,$cost,$DatePlanted,
            //    $DateReady,$SeedTransplant,$LotNumber,$description);
        WarInvDB::getInstance()->update_inventory($itemID,$warehouseID,$product,$cost,$qoh,$DatePlanted,$DateReady,$SeedTransplant,$LotNumber,$description);
        header('Location: editWarehouseInventory.php');
        exit;
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Edit inventory item</title>
        <link href="../wishlist.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
       <?php
                //$warehouseID = filter_input(INPUT_POST,'warehouseID',FILTER_SANITIZE_SPECIAL_CHARS);              //filter uninitializes warehouseID
        $product = filter_input(INPUT_POST,'product',FILTER_SANITIZE_SPECIAL_CHARS);
        $cost = filter_input(INPUT_POST,'cost',FILTER_SANITIZE_SPECIAL_CHARS);
        $qoh = filter_input(INPUT_POST,'qoh',FILTER_SANITIZE_SPECIAL_CHARS);       
        $DatePlanted = filter_input(INPUT_POST,'DatePlanted',FILTER_SANITIZE_SPECIAL_CHARS);
        $DateReady = filter_input(INPUT_POST,'DateReady',FILTER_SANITIZE_SPECIAL_CHARS);
        $SeedTransplant = filter_input(INPUT_POST,'SeedTransplant',FILTER_SANITIZE_SPECIAL_CHARS);
        $LotNumber = filter_input(INPUT_POST,'LotNumber',FILTER_SANITIZE_SPECIAL_CHARS);
        $description= filter_input(INPUT_POST,'description',FILTER_SANITIZE_SPECIAL_CHARS);    
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $item = array("id" => $itemID,
                "warehouse_id" => $warehouseID,
                "product" => $product,
                "cost" => $cost,
                "qoh" => $qoh,
                "DatePlanted" => $DatePlanted,
                "DateReady" => $DateReady,
                "SeedTransplant" => $SeedTransplant,
                'LotNumber' => $LotNumber,
                "description" => $description);
        }
        else if (array_key_exists("itemID",$_GET)) {                                              // check out "get" warehouseID?
            $item = mysqli_fetch_array(WarInvDB::getInstance()->get_item_by_item_id($_GET['itemID']));        
        } else {
            $item = array("id" => "", "warehouse_id" => "","product" => "",
                "cost" => "", "qoh" => "", "DatePlanted" => "",
                "DateReady" => "", "SeedTransplant" => "", "LotNumber" => "",
                "description" => "");                               
        }
        ?>  
        <form name="editItem" action="editItem.php" method="POST">  
            <input type="hidden" name="itemID" value="<?php echo $item['id']; ?>" />
            <input type="hidden" name="warehouseID" value="<?php echo $item['warehouse_ID']; ?>" />
            
            <label>Enter Product:</label>
            <input type="text" name="product"  value="<?php echo $item['product']; ?>" /><br/>
            <label>Enter cost:</label>
            <input type="text" name="cost"  value="<?php echo $item['cost']; ?>" /><br/>
            <label>Enter quantity on hand:</label>
            <input type="text" autofocus name="qoh"  value="<?php echo $item['qoh']; ?>" /><br/>
            <label>Enter date planted:</label>
            <input type="text" name="DatePlanted"  value="<?php echo $item['DatePlanted']; ?>" /><br/>
            <label>Enter date ready to sell:</label>
            <input type="text" name="DateReady"  value="<?php echo $item['DateReady']; ?>" /><br/>
            <label>Enter planted from seed or transplant:</label>
            <input type="text" name="SeedTransplant"  value="<?php echo $item['SeedTransplant']; ?>" /><br/>
            <label>Enter lot number:</label>
            <input type="text" name="LotNumber"  value="<?php echo $item['LotNumber']; ?>" /><br/>
            <label>Enter brief description:</label>
            <input type="text" name="description"  value="<?php echo $item['description']; ?>" /><br/>

            <br/>
            <br/>
            <input type="submit" name="saveItem" value="Save Changes"/>
            <input type="submit" name="back" value="Back"/>
        </form>
    </body>
</html>