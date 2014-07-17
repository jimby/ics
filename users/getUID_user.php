<?php
session_start();
require_once("Includes/db.php");
?>
<html>
<head>
<title>Get user ID</title>
</head>

<html>
    <body>
        <form id="form1" name="form1" action="" method="post" >
            <div>
                <label for="list"> Select a user: </label>
                <br>
                <select name="list" onchange="this.form.submit()">
                    <option value=''>-----SELECT-----</option>
                    <?php 
                    //$con = \mysqli_connect('localhost', 'phpuser', 'phpuserpw','ics');
                    if (mysqli_connect_errno())
                        {
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    }
                    $result =UserDB::getInstance()->list_customers();
                    if (!$result){
                        printf("failed query");
                    }
                    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
                    {
                      $selected = (isset($_POST['list']) && $_POST['list'] ===  $row['id']) ? 'selected' : '';
					//echo "<option value={$row[id]}>{$row[wlocation]}</option>";
					echo "<option value=". $row[id] .">".$row[name].', '.$row[city].', '.$row[province]."</option>";
					//echo "<option value='$row[id]' $selected >$row[location]</option>";     
                    }
                    ?>
                </select>
            </div>
            <div>
                <?php
                if (isset($_POST['list']))
                {
//always reassign customerID                 
                    $list = (int)filter_input(INPUT_POST,'list',FILTER_SANITIZE_SPECIAL_CHARS); 
                    //$result = mysqli_query($con, 'SELECT id FROM customers WHERE id=' . $list); <- unnecessary
                    $_SESSION['customerID']=(int)$list;
                    header('Location:customer.php');
                    exit;
                }
                ?>
            </div>
        </form>
    </body>
</html>