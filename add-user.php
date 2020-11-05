<?php 

    session_start();
    //Checking if a user is logged in
    if(!isset($_SESSION['user_id'])) {
        header("Location: index.php");  //Then when your not logged in can't access users.php file
    }
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

    <header id>
        <div class="appname">User Management System</div>
        <div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?> <a href="inc/logout.inc.php" class="logout">LogOut</a></div>
    </header>

    <main>
        <h1>Add New User <span><a href="users.php" class="blist">Back to User List</a></span></h1>

        <?php 
        
        require 'inc/function.inc.php';
        $errors = $_GET;
        if(!empty($errors)) {
            // echo '<div class="errmsg">';
            // echo '<b>There was error(s) on your form</b><br>';
            // $len = sizeof($errors);
            
            // foreach(array_slice($errors, 0, $len-3) as $error) {
            //         echo $error . '<br>';
            //     }
            // echo '</div>';
            
            //All this using in Simple function way following way
            display_error($errors);


        }

        
        
        ?>

        <form action="inc/add-user.inc.php" method="post" class="userform">

            <p>
                <label for="#">First Name</label>
                <input type="text" name="first_name" 
                <?php 
                //This is will be help to user the user won't again required text
                if(isset($_GET['first_name'])) {
                    echo 'value="' . $_GET['first_name'] . '"';
                } 
                else {
                    echo 'value=""';
                }
                
                ?>
                >
            </p>

            <p>
                <label for="#">Last Name</label>
                <input type="text" name="last_name"
                <?php 
                
                if(isset($_GET['last_name'])) {
                    echo 'value="' . $_GET['last_name'] . '"';
                } 
                else {
                    echo 'value=""';
                }
                
                ?>
                >
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
                    echo 'value=""';
                }
                
                ?>
                >  
            </p>

            <p>
                <label for="#">New Password</label>
                <input type="password" name="password">
            </p>

            <p>
                <label for="#">&nbsp;</label>
                <button type="submit" name="submit">Save</button>
            </p>


        </form>
        
    </main>
</body>
</html>