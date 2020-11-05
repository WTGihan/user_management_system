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
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    // Form Validation

    // //Same way in Simple manner
    $req_fields = array('user_id', 'first_name', 'last_name', 'email');

    // Second Method
    // require 'function.inc.php';
    $errors = array_merge($errors, check_req_fields($req_fields));
    // End of Second Method
    


    //End Checking empty input fields
    
    // Checking max length
    // But TINYTEXT is not reachable boundary then following part for practise and correctness of form

    $max_len_fields = array('first_name' => 50, 'last_name' => 100, 'email' => 100);

    // Samy way in reusable manner
    // require 'function.inc.php';
    $errors = array_merge($errors, check_max_len($max_len_fields));
    // End of reusable function manner

    // End of Checking max length



    // Checking email address

    // require 'function.inc.php';

    if(!is_email($_POST['email'])) {
        $errors[] = 'Email address is Invalid';
    }

    // Checking if email address already exists
    // require 'connection.php';
    
    // String sanitizer for SQL injection
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    // Given email address should be given user_id only
    $query = "SELECT * FROM users WHERE email = '{$email}' AND id != {$user_id} LIMIT 1";
    
    $result_set= mysqli_query($connection, $query);

    if($result_set) { //Check Query Successful
        if(mysqli_num_rows($result_set) == 1) {
            $errors[] = 'Email address already use another user';
        }
    }

    if(!empty($errors)) {
        //pass the arrray through php file to another php file using .http_build_query($errors)
        header("Location: ../modify-user.php?" . http_build_query($errors) . "&user_id=" . $user_id . "&first_name=" . $first_name. "&last_name=" . $last_name. "&email=" . $email); 
        exit();
    }
    // End of Form Validation

    else {
        // No errors found.. Adding new record
        // connection.php already require for this file
        $first_name = mysqli_real_escape_string($connection, $_POST['first_name']); 
        $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
        // Email address is already sanitized


        $query = "UPDATE users SET ";
        $query .= "first_name = '{$first_name}', ";
        $query .= "last_name = '{$last_name}', ";
        $query .= "email = '{$email}' ";
        $query .= "WHERE id = {$user_id} LIMIT 1";

        $result = mysqli_query($connection, $query);

        if($result) {
            // query successful.. redirecting to users page
            header("Location: ../users.php?user_modified=success"); 
            exit();
        }
        else {
            $errors[] = 'Failed to modify the record';
            header("Location: ../modify-user.php?" . http_build_query($errors)); 
            exit();
        }



    }
}

