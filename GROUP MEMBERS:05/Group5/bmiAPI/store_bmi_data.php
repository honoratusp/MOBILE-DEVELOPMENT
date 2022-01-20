<?php

    //if user does not provide data
    if(!isset($_GET["height"]) || !isset($_GET["weight"])){

        $response["bmi"]="---";
		$response["description"]="Please provide your weight and height";

    }
    else{
        //store API data into variables
        $height = $_GET["height"];
        $weight = $_GET["weight"];

        //calculating the bmi and store in a variable
        $bmi = round($weight/($height*$height),2);
		$response["bmi"]=round($bmi,2);	

        //bmi categories
        if($bmi<18.5){
            //listen for the response
            $response["description"] = "You are underweight";

            //store to the variables for database
            $bmi_final = $response["bmi"];
            $message_final = $response["description"];

        }
        else if($bmi>=18.5 && $bmi<=24.9){
            //listen for the response
            $response["description"] = "You are health";

            //store to the variables for database
            $bmi_final = $response["bmi"];
            $message_final = $response["description"];
        }
        else if($bmi>=25 && $bmi<=29.9){
            //listen for the response
            $response["description"] = "You are overweight";

            //store to the variables for database
            $bmi_final = $response["bmi"];
            $message_final = $response["description"];
        }
        else{
            //listen for the response
            $response["description"] = "You are obesity";

            //store to the variables for database
            $bmi_final = $response["bmi"];
            $message_final = $response["description"];
        }
        
        //change the content-Type to JSON
        header("content-Type: application/json; charset=utf-8");
        echo json_encode($response);

        //start connection with database
        $conn = mysqli_connect("localhost", "root", "pemmy627@2", "api_bmi");

        //test connection
        if($conn){
            //insert API data into database
            $sql = "insert into tbl_bmi(height, weight, bmi_value, status) values('$height','$weight','$bmi_final','$message_final')";
            
            //run the query
            $sql_run = mysqli_query($conn, $sql);

            //sent notification
            $response = ["msg" => "Data are stored successfully"];
        }
        else{
            echo "Connection Failed";
        }

    }
    
?>