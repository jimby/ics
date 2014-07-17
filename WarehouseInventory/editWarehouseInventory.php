<?php
session_start();
if (!$warehouseID=$_SESSION['warehouseID']) {
    header('Location:getWID_eWarInv.php');
    exit;
}
else {
	$warehouseID=$_SESSION['warehouseID'];
}
require_once("../Includes/db.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ics Application</title>
        <link href="../wishlist.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>


        <?php
        //echo "<h1>Hello ". $_SESSION['user'] . "</h1>";
        ?>


        <table class="std">
            <tr>
                <th>warehouseID</th>
                <th>product</th>
                <th>cost</th>
                <th>qoh</th>
                <th>Date Planted</th>
                <th>Date Ready</th>
                <th>By seed or transplant</th>
                <th>Lot Number</th>
                <th>Description</th>
                <th colspan="3">&nbsp;</th>
            </tr>
            <?php
            //$warehouseID = WarInvDB::getInstance()->get_warehouse_id_by_location($_SESSION['location']);
            $result = WarInvDB::getInstance()->get_items_by_warehouse_id($warehouseID);
            while ($row = mysqli_fetch_array($result)):
                echo "<tr><td>" . htmlentities($row['warehouse_id']) . "</td>";
                echo "<td>" . htmlentities($row['product']) . "&nbsp;</td>";
                echo "<td>" . htmlentities($row['cost']) . "&nbsp;</td>";
                echo "<td>" . htmlentities($row['qoh']) . "&nbsp;</td>";                  
                echo "<td>" . htmlentities($row['DatePlanted']) . "&nbsp;</td>";
                echo "<td>" . htmlentities($row['DateReady']) . "&nbsp;</td>";
                echo "<td>" . htmlentities($row['SeedTransplant']) . "&nbsp;</td>";
                echo "<td>" . htmlentities($row['LotNumber']) . "&nbsp;</td>";
                echo "<td>" . htmlentities($row['description']) . "&nbsp;</td>";            
                $itemID =(int) $row['id'];
                //The loop is left open
                ?>
            
                <td>
                    <form name="editItem" action="editItem.php" method="GET">
                        <input type="hidden" name="itemID" value="<?php echo $itemID; ?>"/>
                        <input type="submit" name="editItem" value="Edit"/>
                    </form>
                </td>
            
            
                <td>
                    <form name="deleteItem" action="deleteInventory.php" method="POST">
                        <input type="hidden" name="itemID" value="<?php echo $itemID; ?>"/>
                        <input type="submit" name="deleteItem" value="Delete"/>
                    </form>
                </td>
                
                <?php
                echo "</tr>\n";
            endwhile;
            mysqli_free_result($result);
            ?>
        </table>
        <form name="addItem" action="editItem.php">
            <input type="submit" value="Add to Inventory"/>
        </form>
        <form name="backToMainPage" action="../menu.php">
            <input type="submit" value="return"/>
        </form>
    </body>
</html>