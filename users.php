<?php 

    session_start();
    //Checking if a user is logged in
    if(!isset($_SESSION['user_id'])) {
        header("Location: index.php");  //Then when your not logged in can't access users.php file
    }
    
    require 'inc/connection.php';
    $user_list = '';
    $search = '';

    // Search User
    if(isset($_GET['search'])) {
        $search = mysqli_real_escape_string($connection, $_GET['search']);
    
        $query = "SELECT * FROM users WHERE 
                (first_name LIKE '%{$search}%' OR last_name LIKE '%{$search}%' OR email LIKE '%{$search}%')
                AND is_deleted=0 ORDER BY first_name";
            
    }
    // Not Search User
    else {
        // Getting the list of users
        $query = "SELECT * FROM  users WHERE is_deleted=0 ORDER BY first_name";
    }

    
    $users = mysqli_query($connection, $query);

    //verify_query($users);  //This function also check query is correct and also inlcude this folder to top require 'inc/function.inc.php'
    if($users) {
        while($user = mysqli_fetch_assoc($users)) {
            $user_list .= "<tr>";
            $user_list .= "<td>{$user['first_name']}</td>";
            $user_list .= "<td>{$user['last_name']}</td>";
            $user_list .= "<td>{$user['last_login']}</td>";
            $user_list .= "<td><a href=\"modify-user.php?user_id={$user['id']}\" class=\"editbutton\">Edit</a></td>";
            $user_list .= "<td><a href=\"inc/delete-user.inc.php?user_id={$user['id']}\" onclick=\"return confirm('Are you sure?');\" class=\"deletebutton\">Delete</a></td>";
            $user_list .= "<tr>";
        }
    }
    else {
        echo "Database query failed"; 
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

    <header id>
        <div class="appname">User Management System</div>
        <div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?> <a href="inc/logout.inc.php" class="logout">LogOut</a></div>
    </header>

    <main>
        <h1>Users <span><a href="add-user.php" class="addnew">+ Add New</a> <a href="users.php" class="refresh">Refresh</a></span></h1>

        <div class="search">
            <form action="users.php" method="get">
                <p>
                    <input type="text" name="search" id="search" placeholder="Search:Type First Name, Last Name or Email Address and Press Enter" value="<?php echo $search; ?>" autofocus required>
                </p>
            </form>
        </div>

        <table class="masterlist">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Last Login</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>

            <?php 
            echo $user_list;
            ?>


        </table>
    </main>
</body>
</html>