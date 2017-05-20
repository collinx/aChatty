<?php

$response = array();

if (isset($_POST['mobileNumber']) && isset($_POST['type']) && isset($_POST['name']) && isset($_POST['address'])) {
 
    $mobileNumber = $_POST['mobileNumber'];
    $type = $_POST['type'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $balance = rand(100,250);
    require_once __DIR__ . '/DbConnect.php';
    $db = new DB_CONNECT();
    // mysql inserting a new row
    $query = sprintf("INSERT INTO users(mobileNo, type, name, address, balance) VALUES('%s', '%s', '%s', '%s', %d)",mysql_real_escape_string($mobileNumber), mysql_real_escape_string($type), mysql_real_escape_string($name),  mysql_real_escape_string($address), mysql_real_escape_string($balance));
    $result = mysql_query($query);
    if($result){
        $response["success"] = 1;
        $response["message"] = "New Mobile Number Successfully entered!!";
        echo json_encode($response);

    } else {
        $response["success"] = 0;
        $response["message"] = "Mobile Number Already Exists";
        echo json_encode($response);
    }
   
    
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    // echoing JSON response
    echo json_encode($response);
}
?>