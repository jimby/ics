<?php
          $logonSuccess=false;
          session_start();   
          require_once("Includes/db.php");       
          if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $logonSuccess = (IcsDB::getInstance()->verify_users_credentials($_POST['user'], $_POST['userpassword']));
          }
          if ($logonSuccess) {
               $_SESSION['logonSuccess']=true;
                header('Location:index.php');
                exit;
                }
          else{}
        ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        
        <form name="logon" action="login.php" method="POST">
          	Username:
            <input type="text" name="user" autofocus/>
			<br>
          	Password:
           <input type="password" name="userpassword"/>
            
            <div class="error">
              <?php
              if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (!$logonSuccess)
                    echo '<input type="submit" value="Login"/>';
              }
              ?>
            </div>
            <input type="submit" value="Login"/>
            
    	</form>       
    </body>
</html>
