<!DOCTYPE HTML     PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>edit users</title>
        <link href="../wishlist.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
    
    <table class="std">
            <tr>
                <th>Name</th>
                <th>Password</th>
                <th colspan="3">&nbsp;</th>
           </tr>
    <?php
       require_once("../Includes/db.php");
      // $con=\mysqli_connect('localhost','phpuser','phpuserpw','ics');
        $result = UserDB::getInstance()->get_users();
      //  $sql = "select * from users";
      //  $result =mysqli_query($con,$sql);        
        
        while ($row = mysqli_fetch_array($result)) :
            echo "<tr><td>&nbsp;" . htmlentities($row['name']) . "</td>";
            echo "<td>&nbsp;" . htmlentities($row['password']) . "</td>";
            $userID = (int)$row["id"];     
        //loop left open   
           ?>
            <td>
	           <form name="editUser" action="editUser.php" method="GET">
	               <input type="hidden" name="userID" value="<?php echo $userID; ?>"/>
	               <input type="submit" name="editUser" value="Edit"/>
	           </form>
	        </td>
           
            <td>
                <form name="deleteUser" action="deleteUser.php" method="POST">
                    <input type="hidden" name="userID" value="<?php echo $userID; ?>"/>
                    <input type="submit" name="deleteUser" value="Delete"/>
                </form>
            </td>
            <?php
            echo "</tr>\n";
        endwhile;
        mysqli_free_result($result);
        ?>
        </table>
        <form name="addUser" action="registerUser.php">
            <input type="submit" value="Add user"/>
        </form>
        <form name="backToMainPage" action="../menu.php">
            <input type="submit" value="return"/>
        </form>
    </body>
</html>

