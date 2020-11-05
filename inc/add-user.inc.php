<?php 


$errors = array();

$first_name = '';
$last_name = '';
$email = '';
$password = '';

if(isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Form Validation
    // Checking required fields
    if(empty(trim($_POST['first_name']))) {
        $errors[] = 'First Name is Required';
        // echo 'Level 1';
    }

    if(empty(trim($_POST['last_name']))) {
        $errors[] = 'Last Name is Required';
        // echo 'Level 1';
    }

    if(empty(trim($_POST['email']))) {
        $errors[] = 'Email is Required';
        // echo 'Level 1';
    }

    if(empty(trim($_POST['password']))) {
         $errors[] = 'Password is Required';
        // echo 'Level 1';
    }

    // //Same way in Simple manner
    // $req_fields = array('first_name', 'last_name', 'email', 'password');

    // // First Method
    // foreach($req_fields as $field) {
    //     if(empty(trim($_POST[$field]))) {
    //         $errors[] = $field . ' is required';
    //     }
    // }
    // End of First Method

    // // Simple reusable way to First Method
    // // Second Method
    // require 'function.inc.php';
    // $errors = array_merge($errors, check_req_fields($req_fields));
    // End of Second Method
    


    //End Checking empty input fields
    
    // Checking max length
    // But TINYTEXT is not reachable boundary then following part for practise and correctness of form

    if(strlen(trim($_POST['first_name'])) > 50 ) {
        $errors[] = 'First name must be less than 50 characters';
    }

    if(strlen(trim($_POST['last_name'])) > 100 ) {
        $errors[] = 'last name must be less than 100 characters';
    }

    if(strlen(trim($_POST['email'])) > 100 ) {
        $errors[] = 'Email must be less than 100 characters';
    }

    if(strlen(trim($_POST['password'])) > 40 ) {
        $errors[] = 'Password must be less than 40 characters';
    }

    // Same way in Simple manner
    // $max_len_fields = array('first_name' => 50, 'last_name' => 100, 'email' => 100, 'password' => 40);

    // foreach($max_len_fields as $field => $max_len) {
    //     if(strlen(trim($_POST[$field])) > $max_len ) {
    //         $errors[] = $field . ' must be less than ' . $max_len . 'characters';
    //     }
    // }

    // Samy way in reusable manner
    // require 'function.inc.php';
    // $errors = array_merge($errors, check_max_len($max_len_fields));
    // End of reusable function manner

    // End of Checking max length



    // Checking email address

    require 'function.inc.php';

    if(!is_email($_POST['email'])) {
        $errors[] = 'Email address is Invalid';
    }

    // Checking if email address already exists
    require 'connection.php';
    
    // String sanitizer for SQL injection
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $query = "SELECT * FROM users WHERE email = '{$email}' LIMIT 1";

    $result_set= mysqli_query($connection, $query);

    if($result_set) { //Check Query Successful
        if(mysqli_num_rows($result_set) == 1) {
            $errors[] = 'Email address already exists';
        }
    }

    if(!empty($errors)) {
        //pass the arrray through php file to another php file using .http_build_query($errors)
        header("Location: ../add-user.php?" . http_build_query($errors) . "&first_name=" . $first_name. "&last_name=" . $last_name. "&email=" . $email); 
        exit();
    }
    // End of Form Validation

    else {
        // No errors found.. Adding new record
        // connection.php already require for this file
        $first_name = mysqli_real_escape_string($connection, $_POST['first_name']); 
        $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        // Email address is already sanitized

        $hashed_password = sha1($password);

        $query = "INSERT INTO users (";
        $query .= "first_name, last_name, email, password, is_deleted";
        $query .= ") VALUES (";
        $query .= "'{$first_name}', '{$last_name}', '{$email}', '{$hashed_password}', 0";
        $query .= ")";

        $result = mysqli_query($connection, $query);

        if($result) {
            // query successful.. redirecting to users page
            header("Location: ../users.php?user_added=true"); 
            exit();
        }
        else {
            $errors[] = 'Failed to add the new record';
            header("Location: ../add-user.php?" . http_build_query($errors)); 
            exit();
        }



    }
}

