<?php 

require 'connection.php';
require 'function.inc.php';

session_start();
//Checking if a user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");  //Then when your not logged in can't access users.php file
}

if(isset($_GET['user_id'])) {
    //getting the user information
    
    $user_id = mysqli_real_escape_string($connection, $_GET['user_id']);

    // Check current user and delete user
    if($user_id == $_SESSION['user_id']) {
        // Should not delete currnt user
        header("Location: ../users.php?err=cannot_delete_current_user");
        exit();
    }
    else {
        // Delete the user 
        // Update is_deleted coloumn 0 to 1
        $query = "UPDATE users SET is_deleted =1 WHERE id = {$user_id} LIMIT 1";

        $result = mysqli_query($connection, $query);
        
        if($result) {
            // user deleted
            header("Location: ../users.php ?user_delete=success");
            exit();
        }
        else {
            header("Location: ../users.php?err=delete_failed");
            exit();
        }
    }
    
}
else {
    header("Location: ../users.php");
    exit();
}

