<?php
session_start();
require_once("../Includes/db.php");

if (!array_key_exists("warehouseID", $_SESSION)) {
    header('Location: getWarehouseID.php');
    exit;
}
else {
    $warehouseID = intval($_SESSION['warehouseID']);
}
?>


<!DOCTYPE HTML     PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ICS Application</title>
        <link href="wishlist.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
    <?php
    session_start();
    $warehouseID=intval((WarInvDB::getInstance()->get_warehouse_id_by_location($_POST['location'])));
    $_SESSION['warehouseID'] = $warehouseID;
    ?>

     <table class="std">
            <tr>
                <th>Wid</th>
                <th>Qty</th>
                <th>LotNumber</th>
                <th>Product</th>
                <th>Cost</th>
                <th>Planted</th>
                <th>DateReady</th>
                <th>Seed/Transplant?</th>
                <th>Total</th>
                <th colspan="3">&nbsp;</th>
            </tr>
        <?php
        require_once("Includes/db.php");    
        $result = WarInvDB::getInstance()->get_item_by_name($ItemName);
        while ($row = mysqli_fetch_array($result)) :
            echo "<tr><td>&nbsp;" . htmlentities($row['warehouse_id']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['qoh']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['LotNumber'])    . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['product']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['cost'])    . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['DatePlanted']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['DateReady']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['SeedTransplant']) . "</td>";    
            $extension=number_format(($row['qoh*cost']),2);
            echo "<td>&nbsp;$extension</td>";
            $itemID = $row["id"];
        //loop left open    
           ?>
           <td>
	           <form name="buyItem" action="newOrder.php" method="GET">
	               <input type="hidden" name="itemID" value="<?php echo $itemID; ?>"/>
	               <input type="submit" name="editInventory" value="Edit"/>
	           </form>
	       </td>
            
        	<?php
        	echo "</tr>\n";
        	endwhile;
        	mysqli_free_result($result);
        	?>
        </table>
        <form name="addNewItem" action="editInventory.php">
            <input type="submit" value="Add Item"/>
        </form>
        <form name="backToMainPage" action="index.php">
            <input type="submit" value="Back To Main Page"/>
        </form>
        
    </body>
</html>
