<?php
require_once("Includes/db.php");
$logonSuccess = false;
// verify user's credentials
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user =filter_input(INPUT_POST,'user');
    $userpassword =  filter_input(INPUT_POST,'userpassword');
    $logonSuccess = (UserDB::getInstance()->verify_users_credentials($user,$userpassword));
    if ($logonSuccess == true) {
        session_start();
        $_SESSION['user'] = $_POST['user'];
        header('Location: menu.php');
        exit;
    } else {
        header('Location:users/users.php');     //register new user
        exit;
    }
}
?>


<!DOCTYPE html>
<html>
  <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Inventory Control System</title>
        <link href="wishlist.css" type="text/css" rel="stylesheet" media="all" />
  </head>
  <body>
  	<div id="content">
   <!-- <div class="logo">
            <img src="static/logo1.jpg" alt="logo"/>
            <img src="static/logo2.jpg" alt="logo"/>
            <br/>
            <img src="static/logo3.jpg" alt="logo"/>
            <img src="static/logo5.jpg" alt="logo"/>
        </div>
	-->   
	    <div class="logon">
          	<!--<input type="submit" name="myWishList" value="My Wish List >>" onclick="javascript:showHideLogonForm()"/>-->
           	<form name="logon" action="index.php" method="POST"
                 style="visibility:<?php if ($logonSuccess) {echo "hidden";} else {echo "visible";}?>"/>
                    Name:
                    <input type="text" name="user" autofocus/>
                    Password:
                    <input type="password" name="userpassword"/><br/>
                
                    <div class="error">
                    	<?php
                    	    if ($_SERVER['REQUEST_METHOD'] === "POST") {
                        	if (!$logonSuccess) {
                                    echo "Name or password not found";
                            	}
                    	    }
                    	?>
                	</div>
                    <input type="submit" value="Login"/>
                </form>
            </div>
        <div class="showCustomers">
            <!--<input type="submit" name="showCustomers" value="listCustomers >>" onclick="javascript:showHideShowWishListForm()"/>

            <form name="customers" action="customers.php" method="GET" style="visibility:hidden">
                <input type="text" name="customer"/>
                <input type="submit" value="Go" />
            </form>
        </div>
        -->
            <!--  //<div class="createWishList">-->
        <!--    Register customer <a href="customer/registerCustomer.php">register now</a> <br>-->
        <!--  </div>-->
        <!-- <div class="createWishList">-->
        <!--    Add user  <a href="users/users.php">register now</a> -->
        <!-- </div> -->
        
        <script type="text/javascript">
        	function showHideLogonForm() {
            	if (document.all.logon.style.visibility === "visible"){
                	document.all.logon.style.visibility = "hidden";
                	document.all.myWishList.value = "<< My Wish List";
                }
                else {
                	document.all.logon.style.visibility = "visible";
                	document.all.myWishList.value = "My Wish List >>";
                }
           	}

            function showHideShowWishListForm() {
                if (document.all.wishList.style.visibility === "visible") {
                    document.all.wishList.style.visibility = "hidden";
                    document.all.showWishList.value = "Show Wish List of >>";
                }
                else {
                    document.all.wishList.style.visibility = "visible";
                    document.all.showWishList.value = "<< Show Wish List of";
                }
            }
        </script>
	 </div>
  </body>
</html>