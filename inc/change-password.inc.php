<?php 

require 'connection.php';
require 'function.inc.php';

$errors = array();

$user_id = '';
$first_name = '';
$last_name = '';
$email = '';
$password = '';



if(isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    
    // Form Validation

    //Same way in Simple manner
    //Checking required fields
    $req_fields = array('user_id', 'password');

    // Second Method
    // require 'function.inc.php';
    $errors = array_merge($errors, check_req_fields($req_fields));
    // End of Second Method
    


    //End Checking empty input fields
    
    // Checking max length
    $max_len_fields = array('password' => 40);

    $errors = array_merge($errors, check_max_len($max_len_fields));

    // End of Checking max length

    

    if(!empty($errors)) {
        //pass the arrray through php file to another php file using .http_build_query($errors)
        header("Location: ../change-password.php?" . http_build_query($errors) . "&user_id=" . $user_id); 
        exit();
    }
    // End of Form Validation

    else {
        // No errors found.. Adding new record
        // connection.php already require for this file
        // Password Sanitized
        $password = mysqli_real_escape_string($connection, $_POST['password']); 
        $hashed_password = sha1($password);


        $query = "UPDATE users SET ";
        $query .= "password = '{$hashed_password}'";
        $query .= "WHERE id = {$user_id} LIMIT 1";

        $result = mysqli_query($connection, $query);

        if($result) {
            // query successful.. redirecting to users page
            header("Location: ../users.php?user_modified=success"); 
            exit();
        }
        else {
            $errors[] = 'Failed to modify the record';
            header("Location: ../change-password.php?" . http_build_query($errors)); 
            exit();
        }



    }
}

