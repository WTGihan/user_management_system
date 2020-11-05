<?php 

    require 'inc/connection.php';
    session_start();
    //Checking if a user is logged in
    if(!isset($_SESSION['user_id'])) {
        header("Location: index.php");  //Then when your not logged in can't access users.php file
    }
    
    //Give the user information not required again enter to fields
    $user_id = '';
    if(isset($_GET['user_id'])) {
        //getting the user information
        
        $user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
        $query = "SELECT * FROM users WHERE id = {$user_id} LIMIT 1";
    
        $result_set = mysqli_query($connection, $query);
    
        if($result_set) {
            // Check num of rows
            if(mysqli_num_rows($result_set) == 1) {
                // user found
                $result = mysqli_fetch_assoc($result_set);
                $first_name = $result['first_name'];
                $last_name = $result['last_name'];;
                $email = $result['email'];    
            }
            else {
                // user not found
                header("Location: users.php?err=user_not_found");
                exit();
            }
        }
        else {
            // Query unsuccessful
            header("Location: users.php?err=query_failed");
            exit();
        }
    }
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/main.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

    <header id>
        <div class="appname">User Management System</div>
        <div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?> <a href="inc/logout.inc.php" class="logout">LogOut</a></div>
    </header>

    <main>
        <h1>Change Password <span><a href="users.php" class="blist">Back to User List</a></span></h1>

        <?php 
        
        require 'inc/function.inc.php';
        
        $errors = $_GET;
        if(!isset($_GET["user_id"])) {
            if(!empty($errors)) {
                display_error($errors);
            }
        }
        else {
            $user_id = $_GET["user_id"];
            if(!empty($errors)) {
                $arr=array_diff($errors,[$user_id]);
                $len = sizeof($arr);
                if($len != 0){
                    if($len == 1) {
                        echo '<div class="errmsg">';
                        echo '<b>There was error(s) on your form</b><br>';
                        echo $arr[0] . '<br>';
                        echo '</div>';
                    }
                    else {
                        display_error($arr);
                    }
                // //     
                // // }
                // echo '<div class="errmsg">';
                // echo '<b>'. $arr . '</b><br>';
                // echo '</div>';
               }
            }
        }
        
        ?>

        <form action="inc/change-password.inc.php" method="post" class="userform">

            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">


            <p>
                <label for="#">First Name</label>
                <input type="text" name="first_name" 
                <?php 
                //This is will be help to user the user won't again required text
                if(isset($_GET['first_name'])) {
                    echo 'value="' . $_GET['first_name'] . '"';
                } 
                else {
                    echo 'value='.$first_name;
                }
                
                ?>
                disabled>
            </p>

            <p>
                <label for="#">Last Name</label>
                <input type="text" name="last_name"
                <?php 
                
                if(isset($_GET['last_name'])) {
                    echo 'value="' . $_GET['last_name'] . '"';
                } 
                else {
                    echo 'value='.$last_name;
                }
                
                ?>
                disabled>
            </p>

            <p>
                <label for="#">Email Address</label>
                <!--type="email" and this for test -->
                <input type="text" name="email"
                <?php 
                
                if(isset($_GET['email'])) {
                    echo 'value="' . $_GET['email'] . '"';
                } 
                else {
                    echo 'value='.$email;
                }
                
                ?>
                disabled>  
            </p>

            <p>
                <label for="#">New Password</label>
                <input type="password" name="password" id="password">
            </p>

            <p>
                <label for="#">Show Password</label>
                <input type="checkbox" name="showpassword" id="showpassword">
            </p>

            <p>
                <label for="#">&nbsp;</label>
                <button type="submit" name="submit">Update Password</button>
            </p>


        </form>
        
    </main>

    <script>
        $(document).ready(function() {
            $('#showpassword').click(function() {
                // Check whether check box is clicked
                if( $('#showpassword').is(':checked')) {
                    $('#password').attr('type', 'text');  // Change the input type password to text
                }
                else {
                    $('#password').attr('type', 'password'); //Change the input type text to password
                }

            });

        });

    </script>
</body>
</html>