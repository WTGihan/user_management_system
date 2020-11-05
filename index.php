
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>


    <div class="login">

        <form action="inc/login.inc.php" method="post">

            <fieldset>
                <legend><h1>Log In</h1></legend>

                <?php 
                    //Get the array form login.inc.php file
                    if(isset($_GET['error'])) {
                        $err = $_GET['error'];
                        if(!empty($err)) {
                            echo '<p class="error">Invalid Username / Password</p>';
                       }
                    }
                    
                ?>

                <?php 
                    if(isset($_GET['logout'])) {
                        echo '<p class="info">You have Successfully logged out</p>';
                    }
                
                ?>
                

                <p>
                    <label for="#">Username:</label>
                    <input type="text" name="email" id="#" placeholder="Email Address">
                </p>

                <p>
                    <label for="#">Password:</label>
                    <input type="password" name="password" id="#" placeholder="Password">
                </p>

                <p>
                    <button type="submit" name="submit">Log In</button>
                </p>
            </fieldset>
        
        </form>
    
    </div> <!--login -->
    
</body>
</html>
