<?php 
session_start();
?>
<html>
<head>
<title>Title of the document</title>
<script>
function goBack() {
    window.history.back()
}
</script>
</head>

<body>
        <form id="form1" name="form1" action="" method="post" >
            <div>
                <label for="list">warehouses </label>
                <select name="list" onchange="this.form.submit()">
                    <option value=''>-----SELECT-----</option>
                    <?php 
                    $con = \mysqli_connect('localhost', 'phpuser', 'phpuserpw','ics');
                    if (mysqli_connect_errno())
                        {
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    }
                    $sql="SELECT * FROM `warehouses` WHERE 1";
                    $result = mysqli_query($con,$sql);
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
                    $result = mysqli_query($con, 'SELECT id FROM warehouses WHERE id=' . $_POST['list']);
                    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
                    {
                        echo "ID: ".$row[id];
                        if (!$_SESSION['warehouseID']) {
                            $_SESSION['warehouseID']=$row[id];       
                        }
                        
                    }
                }
                ?>
            <button onclick="goBack()">return</button>    
            </div>
        </form>
    </body>
</html>