<?php
session_start();
require_once("../Includes/db.php");
if (!$warehouseID=$_SESSION['warehouseID']) {
	header('Location:getWID_eInv.php');
	exit;
}
else {
	$warehouseID=$_SESSION['warehouseID'];
}
//$logonSuccess = false;

?>
<!DOCTYPE HTML     PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>edit Inventory Application</title>
        <link href="wishlist.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
        
	
     <table class="std">
            <tr>
                <th>Qty</th>
                <th>Product</th>
                <th>warehousID</th>
                <th>Date Planted</th>
                <th>Date Ready</th>
                <th>Product</th>
                <th>Cost</th>
                <th>LotNumber</th>
                <th>Seed/Transplant</th>
                <th>description</th>
                <th colspan="3">&nbsp;</th>
           </tr>    
          	<!--<form name="warehouse" action="warehouse.php" method="POST">
            	<input type="text" name="location"/>
            	<input type="submit" value="Find warehouse"/>
        	</form>
                -->
        <?php
        while ($row = mysqli_fetch_array($result)) :
            echo "<tr><td>&nbsp;" . htmlentities($row['qoh']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['product']) . "</td>";
            echo "<tr><td>&nbsp;" . htmlentities($row['qoh']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['product']) . "</td>";
            echo "<tr><td>&nbsp;" . htmlentities($row['qoh']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['product']) . "</td>";
            echo "<tr><td>&nbsp;" . htmlentities($row['qoh']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['product']) . "</td>";
            echo "<tr><td>&nbsp;" . htmlentities($row['qoh']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['product']) . "</td>";
            
            $warehouseID = $row["id"];
           ?> 
            //loop left open 
                  
           <td>
	           <form name="editwarehouse" action="editWarehouses.php" method="GET">
	               <input type="hidden" name="warehouseID" value="<?php echo $warehouseID; ?>"/>
	               <input type="submit" name="editWarehouse" value="Edit"/>
	           </form>
	       </td>
           
               <td>
                <form name="deleteWarehouse" action="deleteWarehouse.php" method="POST">
                    <input type="hidden" name="warehouseID" value="<?php echo $warehouseID; ?>"/>
                    <input type="submit" name="deletewarehouse" value="Delete"/>
                </form>
            </td>
            
        <?php
        echo "</tr>\n";
        endwhile;
        mysqli_free_result($result);
        ?>
        </table>
        <!-- add editWarehouse.php -->
        <form name="addNewWarehouse" action="editWarehouse.php">
            <input type="submit" value="Add Warehouse"/>
        </form>
        <form name="backToMainPage" action="index.php">
            <input type="submit" value="Back To Main Page"/>
        </form>
        
    </body>
</html>