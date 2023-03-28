<?php 

   require "../config.php";

    function connect(){
         // create connection
        $mysql = new mysqli(server,username, password, database);

        // check for connection
        if($mysql->connect_error){
            $error = $mysql->connect_error;
            $error_date = date("F j, Y, g:i a");
            $message = "{$error} | {$error_date} \r\n";
            file_put_contents("../db-log.text",$message,FILE_APPEND);
            return false;
        
        }else{  
            return $mysql;
        }
}
        


    function register($email,$username,$password,$confirmPassword){
        $mysql = connect();
        $args = func_get_args();
        $args = array_map(function($value){
            return trim($value);
        },$args);


        foreach($args as $value){
            if(empty($value)){
                return "All fields are required";
            }
        }

        foreach($args as $value){
            if(preg_match("/([<|>])/",$value)){
                return "<> characters are not allowed.";
            }
        }

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return "Email is not valid.";
        }

        $checkSqlQuery = $mysql->prepare("SELECT email FROM users WHERE email = ?");
        $checkSqlQuery->bind_param("s",$email);
        $checkSqlQuery->execute();
        $queryResult = $checkSqlQuery->get_result();
        $data = $queryResult->fetch_assoc();
        if($data != NULL){
            return "Email already exists.";
        }

        if(strlen($username) > 50){
            return "Username is too long";
        }

        $checkSqlQuery = $mysql->prepare("SELECT username FROM users WHERE username = ?");
        $checkSqlQuery->bind_param("s",$username);
        $checkSqlQuery->execute();
        $queryResult = $checkSqlQuery->get_result();
        $data = $queryResult->fetch_assoc();
        if($data != NULL){
            return "Username already exists.";
        }

        
        if(strlen($password) > 50){
            return "Password is too long";
        }

        if($password != $confirmPassword){
            return "Password dont match";
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $checkSqlQuery = $mysql->prepare("INSERT INTO users(username, password, email) VALUES(?,?,?)");
        $checkSqlQuery->bind_param("sss",$username,$hashed_password,$email);
        $checkSqlQuery->execute();
        if($checkSqlQuery->affected_rows != 1){
            return "An error ocurred. Please try again.";
        }else{
            return "Success";
        }

    }

    function loginUser($username,$password){
        $mysql = connect();
        $username = trim($username);
        $password = trim($password);

        if($username == "" || $password == ""){
            return "Both fields are required";
        }

        $username = filter_var($username,FILTER_SANITIZE_STRING);
        $password = filter_var($password,FILTER_SANITIZE_STRING);
        
        $sql = "SELECT username, password FROM users WHERE username = ?";
        $checkSqlQuery = $mysql->prepare($sql);
        $checkSqlQuery->bind_param("s", $username);
        $checkSqlQuery->execute();
        $result = $checkSqlQuery->get_result();
        $data = $result->fetch_assoc();

        if($data == NULL){
            return "Wrong username and password!";
        }

        if(password_verify($password,$data['password'])==FALSE){
            return "Wrong username or password";
        }else{
            $_SESSION['user'] = $username;
            header("location: account_page.php");
            exit();
        };
    }

    function logoutUser(){
        session_destroy();
        header("location: login.php");
        exit();
    }