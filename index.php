<?php
//declare variables
$x =0;
$y = 0;
$operation = "";
$errorMsg =array();
$result =0;
$response = [];


if(file_get_contents("php://input", true)){  	//if post request is made execute below
	$data = (array) json_decode(file_get_contents("php://input", true)); //takes raw data from the request & converts it into PHP object
	$x = $data['x'];
	$y = $data['y'];
	$operation = $data['operation_type'];
}else{		//if no post request is made use the following variables as default variable to test the API
	$x =40;
	$y = 11;
	$operation = "multiplication";
}


function operationValue($operator){ //function that returns operator type
	if ($operator == "multiplication"){ return "*"; }
	if ($operator == "addition"){ return "+"; }
	if ($operator == "subtraction"){ return "-"; }
}

function calculateOperands($x, $y, $operation){
	global $errorMsg, $result, $response;
	$operation = strtolower($operation);  //convert the input to lower case
	$operationType = ["multiplication", "addition", "subtraction"]; //array containing the allowed operators

	//check and validate inputs and push the error to the array
	if (!(is_numeric($x)) ){  array_push($errorMsg, "Oops! ".$x. " is not a number, Only Numbers are required!");  }
	if (!(is_numeric($y)) ){  array_push($errorMsg, "Oops! ".$y. " is not a number, Only Numbers are required!");  }
	if (!(in_array($operation, $operationType))){
		array_push($errorMsg, "Oops! Only Multiplication, Addition and Subtraction operations are allowed!");
	}


	if(count($errorMsg) == 0){  //check if there is no error message in the array
		switch($operation){
			case "multiplication":
				$result = $x * $y;
				break;
			case "addition":
				$result = $x + $y;
				break;
			case "subtraction":
				$result = $x - $y;
				break;
			default:
				$result = null;
				break;
		}

		$response["slackUsername"] = "chriswax";
		$response["result"] = $result;
		$response["operation_Type"]["$operation"] = operationValue($operation);

		header("Content-type: application/json; charset=UTF-8");  //declare header
		$jsonOutput =  json_encode($response);	//convert to JSON 
		echo $jsonOutput;	//display the output

	}else{
		//output errors from the array
		foreach ($errorMsg as $error) {
			echo "*".$error . "<br/>";
		}
	}
}

//call the calculate operands with opertor
calculateOperands($x, $y, $operation);


//sample JSON request format
//{ 
//    "operation_type":"multiplication",
//    "x": 45,
//    "y": 10,
//}

?>
