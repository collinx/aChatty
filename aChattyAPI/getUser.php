    <?php


$response = array();


    require_once __DIR__ . '/DbConnect.php';
    $db = new DB_CONNECT();
    $data_back = json_decode(file_get_contents('php://input'));
    $intent = $data_back->{"result"}->{"metadata"}->{"intentName"};
    
    if($intent === "balance"){
        
        $mobileNo = $data_back->{"result"}->{"parameters"}->{"mobileNo"};
        
          $query = sprintf("Select * from users where mobileNo='%s'",mysql_real_escape_string($mobileNo));
          $result = mysql_query($query);
           $row = mysql_fetch_array($result);
          header("Content-type: application/json");
          if($row){
              if($row["type"] === "prepaid"){
                   $response["speech"] = $row["name"].", Your balance is ".$row["balance"].".";
                     
              }else{
                   $response["speech"] = $row["name"].", Your billed amount is ".$row["balance"].".";
              }
               
              
          }else{
              $response["speech"] = "No such user exit!!";
              
          }
        
          
                $response["source"] = "API";
                $response["data"]= null;
                $response["contextOut"] = [];
                
                echo json_encode($response);
    } else if($intent === "create.service.request"){
         $mobileNo = $data_back->{"result"}->{"parameters"}->{"mobileNo"};
         $complaintDetails = $data_back->{"result"}->{"parameters"}->{"complaintDetail"};
        
          $query = sprintf("Select * from users where mobileNo='%s'",mysql_real_escape_string($mobileNo));
          $result = mysql_query($query);
           $row = mysql_fetch_array($result);
          header("Content-type: application/json");
          if($row){
              
                $query = sprintf("Insert into serviceRequest(number,detail) values ('%s','%s')",mysql_real_escape_string($mobileNo),mysql_real_escape_string($complaintDetails));
                $result = mysql_query($query);
              
              if($result){
                  
                     $query = sprintf("Select * from serviceRequest order by id desc limit 1");
                     $result = mysql_query($query);
                     $row =mysql_fetch_array($result);
                     $response["speech"] = "Service request created at ".$row["date"]." with ticket number ".$row["id"].".";
              }else{
                   $response["speech"] = "Error with server";
              }
               
              
          }else{
              $response["speech"] = "mobile number doesn't exist!!";
              
          }
        
          
                $response["source"] = "API";
                $response["data"]= null;
                $response["contextOut"] = [];
                
                echo json_encode($response);
    } else if($intent === "view.service.status"){
         $mobileNo = $data_back->{"result"}->{"parameters"}->{"mobileNumber"};
         $ticketNumber = $data_back->{"result"}->{"parameters"}->{"ticketNumber"};
        
          $query = sprintf("Select * from users where mobileNo='%s'",mysql_real_escape_string($mobileNo));
          $result = mysql_query($query);
           $row = mysql_fetch_array($result);
          header("Content-type: application/json");
          if($row){
              
                $query = sprintf("Select * from serviceRequest where number='%s' and id=%d",mysql_real_escape_string($mobileNo),mysql_real_escape_string($ticketNumber));
                $result = mysql_query($query);
              
              if($result){
                    if($row["status"]===0){
                         $response["speech"] = "Service request created at ".$row["date"]." with ticket number ".$row["id"]." is still pending.";
                    }else{
                         $response["speech"] = "Service request created at ".$row["date"]." with ticket number ".$row["id"]." is solved with solution as ".$row["solution"].".";
                    }
                    
              }else{
                   $response["speech"] = "Error with server";
              }
               
              
          }else{
              $response["speech"] = "mobile number doesn't exist!!";
              
          }
        
          
                $response["source"] = "API";
                $response["data"]= null;
                $response["contextOut"] = [];
                
                echo json_encode($response);
    } 
    

     
?>