<?php
header('Content-Type: application/json');
$response = array();

if (isset($_GET['username']) && $_GET['username'] =="chriswax") {
    $response["slackUsername"] = "chriswax";
    $response["backend"] = true;
    $response["age"] = 33;
    $response["bio"] = "I am Uzoigwe Christian a FullStack developer and a graduate of computer science from Michael Okpara University Umudike";
    
    $result =  json_encode($response);
    echo $result;
}else{
    $response["Error"] = "The Server cannot find the Endpoint Api request";
    $result =  json_encode($response);
    echo $result;
}
?>