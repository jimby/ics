<?php

class IcsDB extends mysqli {
    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "phpuser";
    private $pass = "phpuserpw";
    private $dbName = "ics";
    private $dbHost = "localhost";
    private $con = null;

    //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    // private constructor
    private function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }

    public function verify_users_credentials($name, $password) {
        $name = $this->real_escape_string($name);
        $password = $this->real_escape_string($password);
        $result = $this->query("SELECT * FROM users WHERE name = '"
                        . $name . "' AND password = '" . $password . "'");
        return $result->data_seek(0);
    }
    function format_date_for_sql($date) {
        if ($date == "") {
            return null;
        }
        else {
            $dateParts = date_parse($date);
            return $dateParts['year'] * 10000 + $dateParts['month'] * 100 + $dateParts['day'];
        }
    }
}

?>

<?php

class CustDB extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "phpuser";
    private $pass = "phpuserpw";
    private $dbName = "ics";
    private $dbHost = "localhost";
    private $con = null;

    //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    // private constructor
    private function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }
   /********** customer functions **********/ 
    public function verify_customers_credentials($name, $password) {
        $name = $this->real_escape_string($name);
        $password = $this->real_escape_string($password);
        //$result = $this->query("SELECT * FROM customers WHERE name = '". $name . "' AND password = '" . $password . "'");
        $result = $this->query("SELECT * FROM customers WHERE name = $name AND password = $password");                
        return $result->data_seek(0);
    }
    

    public function get_customer_id_by_email($email){
        $email = $this->real_escape_string($email);
        $customer = $this->query("SELECT id FROM customers WHERE email = '"
            . $email . "'");
    
      if ($customer->num_rows > 0){
            $row = $customer->fetch_row();
            return $row[0];
        } else {
            return null;
        }
    }

    public function get_customer_id_by_name($name) {
        $name = $this->real_escape_string($name);
        return $customer = $this->query("SELECT id FROM customers WHERE name = $name");
    }
    public function get_customer_by_customer_id($customerID) {
        return $this->query("SELECT * FROM customers WHERE id = $customerID");
    }

    public function create_customer($name, $email,$password) {
        $name = $this->real_escape_string($name);
        $email = $this->real_escape_string($email);
        $password = $this->real_escape_string($password);
        $this->query("INSERT INTO customers (name, email, password) VALUES ('" . $name
                . "','".$email."', '" . $password . "')");
    }

        public function list_customers($lname) {
    	$name = $this->real_escape_string($name);
    	return $this->query("SELECT *  FROM customers WHERE lnamed =$lname");
        
    }
    public function delete_customer($customerID) {
        $customerID = (int)($customerID);
        $this->query("DELETE FROM customers WHERE id =$customerID");
    }
    public function update_customer($customerID,$lname,$fname,$mi,$name,$street,$city,$province,$country,$postal_code,$phone,$email,$ship_name,$ship_street,$ship_city,$ship_province,$ship_country,$ship_postal_code,$ship_phone,$ship_email) {
        $customerID = (int)($customerID);$lname = $this->real_escape_string($lname);
        $fname = $this->real_escape_string($fname);$mi = $this->real_escape_string($mi);$name= $this->real_escape_string($name);
        $street = $this->real_escape_string($street);$city = $this->real_escape_string($city);
        $province = $this->real_escape_string($province);$country = $this->real_escape_string($country);
        $postal_code = $this->real_escape_string($postal_code);$phone = $this->real_escape_string($phone);
        $email = $this->real_escape_string($email);$ship_name = $this->real_escape_string($ship_name);
        $ship_street = $this->real_escape_string($ship_street);$ship_city = $this->real_escape_string($ship_city);
        $ship_province = $this->real_escape_string($ship_province);$ship_country = $this->real_escape_string($ship_country);
        $ship_postal_code = $this->real_escape_string($ship_postal_code);$ship_phone = $this->real_escape_string($ship_phone);
        $ship_email = $this->real_escape_string($ship_email);
        $this->query("UPDATE customers SET 
            lname ='" . $lname . "',fname = '" . $fname ."',mi ='" . $mi . "',name ='" . $name . "',      
            street ='" . $street . "',city = ' " . $city . "',province ='" . $province . "',country = '" . $country . "',
            postal_code ='" . $postal_code . "',phone ='" . $phone . "',email = '" . $email ."',ship_name = '" . $ship_name ."',            
            ship_street ='" . $ship_street . "',ship_city = ' " . $ship_city . "',ship_province ='" . $ship_province . "',ship_country = '" . $ship_country . "',
            ship_postal_code ='" . $ship_postal_code . "',ship_phone ='" . $ship_phone . "',ship_email = '" . $ship_email . "'WHERE id =" . $customerID);
    }
    function insert_customer($customerID,$lname,$fname,$mi,$name,$street,$city,$province,$country,$postal_code,$phone,$email,$ship_name,$ship_street,$ship_city,$ship_province,$ship_country,$ship_postal_code,$ship_phone,$ship_email) {
        $customerID = (int)($customerID);$lname = $this->real_escape_string($lname);
        $fname = $this->real_escape_string($fname);$mi = $this->real_escape_string($mi);$name = $this->real_escape_string($name);
        $street = $this->real_escape_string($street);$city = $this->real_escape_string($city);
        $province = $this->real_escape_string($province);$country = $this->real_escape_string($country);
        $postal_code = $this->real_escape_string($postal_code);$phone = $this->real_escape_string($phone);
        $email = $this->real_escape_string($email);$ship_name = $this->real_escape_string($ship_name);
        $ship_street = $this->real_escape_string($ship_street);$ship_city = $this->real_escape_string($ship_city);
        $ship_province = $this->real_escape_string($ship_province);$ship_country = $this->real_escape_string($ship_country);
        $ship_postal_code = $this->real_escape_string($ship_postal_code);$ship_phone = $this->real_escape_string($ship_phone);
        $ship_email = $this->real_escape_string($ship_email);
    
        $this->query ("INSERT INTO customers
            (city,country,email,fname,lname,mi,name,phone,postal_code,province,ship_city,ship_country,ship_email,ship_name,ship_phone,ship_postal_code,ship_province,ship_street,street)
            VALUES
            ('$city','$country','$email','$fname','$lname','$mi','$name','$phone','$postal_code','$province','$ship_city','$ship_country','$ship_email','$ship_name','$ship_phone','$ship_postal_code','$ship_province','$ship_street','$street')");
    }
}
class UserDB extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "phpuser";
    private $pass = "phpuserpw";
    private $dbName = "ics";
    private $dbHost = "localhost";
    private $con = null;

    //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    // private constructor
    private function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }

    /**** users start here *****/
public function verify_users_credentials($name, $password) {
        $name = $this->real_escape_string($name);
        $password = $this->real_escape_string($password);
        $result = $this->query("SELECT * FROM users WHERE name = '"
                        . $name . "' AND password = '" . $password . "'");
        //$result = $this->query("SELECT * FROM users WHERE name = $name AND password = $password");                
        return $result->data_seek(0);
    }
    public function get_user_id_by_name($name) {
    	$name = $this->real_escape_string($name);
    	$user = $this->query("SELECT id FROM users WHERE name = $name");
    
    	if ($user->num_rows > 0){
    		$row = $user->fetch_row();
    		return $row[0];
    	} else {
    		return null;
    	}
    }  
    
    public function get_user_by_user_id($userID) {
        return $this->query("SELECT * FROM users WHERE id = $userID");
    }

    public function create_user($name,$password) {
    	$name = $this->real_escape_string($name);
    	$password = $this->real_escape_string($password);
    	$this->query("INSERT INTO users (name,  password) VALUES ('" . $name
    			. "', '" . $password . "')");
    }
    
    
    public function get_users() {
        return $this->query("SELECT id,name,password FROM users");
    }
    public function delete_user($userID) {
    	$userID = (int)($userID);
    	$this->query("DELETE FROM users WHERE id =$userID");
    }
    
}

?>
<?php

class WarInvDB extends mysqli {
    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "phpuser";
    private $pass = "phpuserpw";
    private $dbName = "ics";
    private $dbHost = "localhost";
    private $con = null;

    //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    // private constructor
    private function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }

    public function get_wisher_id_by_name($name) {
        $name = $this->real_escape_string($name);
        $wisher = $this->query("SELECT id FROM wishers WHERE name = '"
                        . $name . "'");
        if ($wisher->num_rows > 0){
            $row = $wisher->fetch_row();
            return $row[0];
        } else{
            return null;
        }
/* inventory functions****************************************************************/
    }
    function insert_item($warehouseID,$product,$cost,$qoh,$DatePlanted,$DateReady,$SeedTransplant,$LotNumber,$description) {
        $warehouseID = intval($warehouseID);
        $product = $this->real_escape_string($product);
        $cost = $this->real_escape_string($cost);
        $qoh = $this->real_escape_string($qoh);   
        $DatePlanted = $this->real_escape_string($DatePlanted);
        $DateReady = $this->real_escape_string($DateReady);
        $SeedTransplant = $this->real_escape_string($SeedTransplant);
        $LotNumber = $this->real_escape_string($LotNumber);
        $description = $this->real_escape_string($description);
        $this->query ("INSERT INTO inventory
            (warehouse_id,product,cost,qoh,DatePlanted,DateReady,SeedTransplant,LotNumber,description)
            VALUES
            ('$warehouseID','$product','$cost','$qoh','$DatePlanted','$DateReady','$SeedTransplant','$LotNumber','$description')");
    }
    public function update_inventory($itemID,$warehouseID,$product,$cost,$qoh,$DatePlanted,$DateReady,$SeedTransplant,$LotNumber,$description) {
        $warehouseID = intval($warehouseID);
        $product = $this->real_escape_string($product);
        $cost = $this->real_escape_string($cost);
        $qoh = $this->real_escape_string($qoh);
        $DatePlanted = $this->real_escape_string($DatePlanted);
        $DateReady = $this->real_escape_string($DateReady);
        $SeedTransplant = $this->real_escape_string($SeedTransplant);
        $LotNumber = $this->real_escape_string($LotNumber);
        $description = $this->real_escape_string($description);
        $this->query("UPDATE inventory SET
                warehouse_id = ' " . $warehouseID . "',
                product = '" . $product . "',
                cost = '" . $cost ."',
                qoh = '" . $qoh ."',
                DatePlanted='" . $DatePlanted . "',
                DateReady='" . $DateReady . "',
                SeedTransplant='" . $SeedTransplant . "',
                LotNumber='" . $LotNumber . "',
                description='" . $description . "'
                WHERE id =" . $itemID);
    }
    public function get_item_by_name($ItemName) {
        $ItemName = "%".$this->real_escape_string($ItemName)."%";
        return $this->query("SELECT id,warehouse_id,qoh, product, cost,DatePlanted,DateReady,SeedTransplant,LotNumber FROM inventory WHERE name = " . $ItemName);
    }
    public function get_item_by_item_id($itemID) {
        return $this->query("SELECT id,warehouse_id,qoh, product, cost,DatePlanted,DateReady,SeedTransplant,LotNumber,description FROM inventory WHERE id = " . $itemID);
    }
    public function get_items_by_warehouse_id($warehouseID) {
        return $this->query("SELECT id,warehouse_id,qoh, product, cost,DatePlanted,DateReady,SeedTransplant,LotNumber,description FROM inventory WHERE warehouse_id = $warehouseID order by product");
    }
    public function delete_item($itemID) {
        $this->query("DELETE FROM inventory WHERE id =  $itemID");
    }
/***** END INVENTORY FUNCTIONS *****
/***** BEGIN warehouse**********************************/
    public function get_warehouse_id_by_location($mlocation) {
        $mlocation = $this->real_escape_string($mlocation);
        $warehouseID = $this->query("SELECT id FROM warehouses WHERE wlocation like = "
                        . $mlocation);

            if ($warehouseID->num_rows > 0){
               $row = $warehouseID->fetch_row();
               return $row[0];
            } else{
             return null;
            }
        }
    
    public function create_warehouse($name, $location) {
        $name = $this->real_escape_string($name);
        $location = $this->real_escape_string($location);
        $this->query("INSERT INTO warehouses (wname, wlocation) VALUES ('" . $name
                . "', '" . $location . "')");
    }
    
        
    public function find_warehouses() {
        return $this->query("SELECT * FROM warehouses");
    }
    
    
    public function delete_warehouse($warehouseID) {
                $this->query("DELETE FROM warehouses WHERE id = $warehouseID");
        }
        /*warehouse**********************************/
}