<?php 
session_start();
require_once("../Includes/db.php");
?>
<html>
<head>
<title>getWID_eInv.php</title>
</head>

<html>
    <body>
        <form id="form1" name="form1" action="" method="post" >
            <div>
                <label for="list">warehouses </label>
                <select name="list" onchange="this.form.submit()">
                    <option value=''>-----SELECT-----</option>
                    <?php 
                    //$con = \mysqli_connect('localhost', 'phpuser', 'phpuserpw','ics');
                    if (mysqli_connect_errno())
                        {
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    }
                    //$sql="SELECT * FROM `warehouses` WHERE 1";
                    //$result = mysqli_query($con,$sql);
                    $result = WareDB::getInstance()->find_warehouses();
                    if (!$result){
                        printf("failed query");
                    }
                    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
                    {
                      $selected = (isset($_POST['list']) && $_POST['list'] ===  $row['id']) ? 'selected' : '';
					//echo "<option value={$row[id]}>{$row[wlocation]}</option>";
					echo "<option value=". $row[id] .">".$row[wname].', '.$row[wlocation]."</option>";
					//echo "<option value='$row[id]' $selected >$row[location]</option>";
			
                      
                    }
                    ?>
                </select>
            </div>
            <div>
               
                <?php
                if (isset($_POST['list']))
                {
                    $list = filter_input(INPUT_POST,'list',FILTER_SANITIZE_SPECIAL_CHARS); 
                    $result = mysqli_query($con, 'SELECT id FROM warehouses WHERE id=' . $list);
                    if (!$_SESSION['warehouseID']) {
                            $_SESSION['warehouseID']=$list;
                            header('Location:editInventory.php');
                            exit;
                        }   
                    }
                ?>
               <!--<a href="editWarehouseInventory.php" /></a>-->
                
            </div>
        </form>
    </body>
</html>