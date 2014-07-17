<?php
require_once("../Includes/db.php");
?>
<!DOCTYPE HTML     PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ICS Order Entry</title>
        <link href="../wishlist.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
       
     <table class="std">
            <tr>
                <th>LName</th>
                <th>FName</th>
                <th>Street</th>
                <th>City</th>
                <th>Province</th>
                <th>Country</th>
                <th>PostalCode</th>
                <th>Telephone</th>
                <th>Email</th>
                <th colspan="3">&nbsp;</th>
           </tr>
<!-- show shipping to headers-->
        <?php      
        //$mname = $_POST["name"];
        $mname = \filter_input(INPUT_POST,'mname',FILTER_SANITIZE_SPECIAL_CHARS);
        $con=\mysqli_connect('localhost','phpuser','phpuserpw','ics');
        if (mysqli_connect_errno())
                        {
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                        }
        $mname = "%".$mname."%";
        
        //$sql="select * from customers where lname like '%n%'";
        $sql="select * from customers where lname like '$mname'";
        $result=mysqli_query($con,$sql);
        //$result=CustDB::getInstance()->get_customer_by_name($mname);
        //$result = CustDB::getInstance()->list_customers();
        while ($row = mysqli_fetch_array($result)) :
            echo "<tr><td>&nbsp;" . htmlentities($row['lname']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['fname']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['street']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['city'])    . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['province']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['country'])    . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['postal_code']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['phone']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['email']) . "</td>";
            $customerID = (int)$row["id"];
            
        //loop left open   
           ?>
           <td>
	           <form name="editCustomer" action="OrdeditCustomer.php" method="GET">
	               <input type="hidden" name="customerID" value="<?php echo $customerID; ?>"/>
	               <input type="submit" name="editCustomer" value="Choose/Edit"/>
	           </form>
	       </td>
           
               <td>
                <form name="deleteCustomer" action="deleteCustomer.php" method="POST">
                    <input type="hidden" name="customerID" value="<?php echo $customerID; ?>"/>
                    <input type="submit" name="deleteCustomer" value="Delete"/>
                </form>
            </td>
           
        <?php
        echo "</tr>\n";
        endwhile;
        mysqli_free_result($result);
        ?>
        </table>
        <form name="addCustomer" action="OrdeditCustomer.php">
            <input type="submit" value="Add Customer"/>
        </form>
        <form name="backToMainPage" action="../orders/Orders.php">
            <input type="submit" value="return"/>
        </form>
    </body>
</html>