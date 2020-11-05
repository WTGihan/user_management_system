<?php 

session_start();
// Check for form submission
if(isset($_POST['submit'])) {
    require 'connection.php';
    $errors = array();
    // Check if the username and password has been entered
    if(!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1 ) {
        $errors[] = 'Username is Missing / Invalid';
        header("Location: ../index.php?error=$errors");
        exit();
        // echo 'Level 1';
    }

    if(!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1 ) {
        $errors[] = 'Password is Missing / Invalid';
        header("Location: ../index.php?error=$errors");
        exit();
        // echo 'Level 2';
    }

    // Check if there are any errors in the form
    if(empty($errors)) {
        // Save username and password into variables
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = mysqli_real_escape_string($connection,$_POST['password']);
        $hashed_password = sha1($password);

        // Prepare database query
        $query = "SELECT * FROM users 
                  WHERE email = '{$email}'
                  AND password = '{$hashed_password}'
                  LIMIT 1";
        
        // This method use for fix SQL Errors in Project
        // echo $query;
        // die();

        $result_set = mysqli_query($connection, $query);
        echo 'Level 3';

        if($result_set) {
            // Query successfull

            if(mysqli_num_rows($result_set) == 1) {
                // Valid user found
                $user = mysqli_fetch_assoc($result_set);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['first_name'] = $user['first_name'];
                // $name = $_SESSION['first_name'];

                // Updating last Login
                $query = "UPDATE users SET last_login = NOW()";
                $query .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";

                $result_set = mysqli_query($connection, $query);

                if(!$result_set) {
                    die("Database query failed.");
                }

                // Redirect to user.php
                header("Location: ../users.php");
                exit();
                // echo 'Level 4';
            }
            else{
                // Username and password invalid
                $errors[] = 'Invalid Username / Password';
                // header("Location: ../index.php?error=invalid");
                header("Location: ../index.php?error=$errors");
                exit();
                // echo 'Level 5';
            }
        }
        else {
            $errors[] = 'Database query failed';
            header("Location: ../index.php?error=$errors");
            exit();
            // echo 'Level 6';
        }

        
    }


  


}




