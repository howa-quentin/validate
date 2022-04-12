<?php
$username = '';
$password = '';
$verifyp = '';
$secretCode = '';

if($_SERVER['HTTP_HOST'] == 'localhost'){
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '1550');
define('DB', 'SECURE_USERS');
} else {
define('HOST', 'hidden');
define('USER', 'hidden');
define('PASSWORD', 'hidden');
define('DB', 'hidden');
}

function connectToDB() {
$connect = mysqli_connect(HOST, USER, PASSWORD, DB);
return $connect;
}
$connect = connectToDB();

    if(isset($_POST['createUser'])){
        $username = ((isset($_POST['username']) ? $_POST['username'] : false));
        $password = ((isset($_POST['password']) ? $_POST['password'] : false));
        $secretCode = ((isset($_POST['secretCode']) ? $_POST['secretCode'] : false));
        $verifyp = ((isset($_POST['verifyp']) ? $_POST['verifyp'] : false));
        $log = 0;
        $sql = "select * from secret_codes where code='$secretCode';";
        $result = mysqli_query($connect, $sql);
        if(mysqli_num_rows($result) == false){
        echo '<script>alert("Secret code did not match")</script>';
    }

    $sql = "select * from users_credentials where username='$username';";
    $results = mysqli_query($connect, $sql);
    if(mysqli_num_rows($results)){
        echo '<script>alert("Username already taken!")</script>';
    }   elseif($password == $verifyp){
            $salt1 = 'uentiansdo23r0h02bfb2039fu';
            $salt2 = '92gfho9qg23fbofauwefgq93g7';
            $password = $salt1.$password.$salt2;
            $password = hash('sha512', $password);
            $ins = 'INSERT INTO users_credentials (username, password, logins) VALUES ("'.$username.'", "'.$password.'","'.$log.'");';
            mysqli_query($connect, $ins);
            $username = '';
            $password = '';
            $verifyp = '';
            $secretCode = '';
        } else {
            echo '<script>alert("Passwords do not match")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Create Account</title>
        <link type="text/css" rel="stylesheet" href="css/style.css">
        <script type="text/javascript" src="js/script.js" defer></script>
    </head>
    <body>
        <span id="passmatch" style="visibility:hidden;color:red;font-weight:bold;">Passwords do not match!</span>
            <form class='login' method="post">
                <input class="user" type="text" name="username" placeholder="Username" value="<?php echo $username;?>"><br>
                <input class="pass" type="password" name="password" placeholder="Password" id="p" oninput="checkPassword()" value="<?php echo $password;?>"><br>
                <input class="pass" type="password" name="verifyp" placeholder="Verify Password" id="v" oninput="checkPassword()" value="<?php echo $verifyp;?>"><br>
                <input class="pass" type="password" name="secretCode" placeholder="Secret Code" value="<?php echo $secretCode;?>"><br>
                <button class="submit" type="submit" name="createUser">Create User</button>
                <input class="reset" type="reset" name="reset" placeholder="Reset">
            </form>
            <form class='login' action="index.php" method="post">
                <button class="new" type="submit" name="loginPage">Return to Login</button>
            </form>
    </body>
</html>