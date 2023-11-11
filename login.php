<?php
session_start(); // Initialize the session

if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $pwd = htmlspecialchars($_POST['password']);

    try {
        require_once "inc/db_config.php";
        $query = "SELECT * FROM users WHERE email = :email and pwd = :pwd";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pwd', md5($pwd));

        

        $stmt->execute();

        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        

        if ($user) {
            session_regenerate_id();
            $username = substr($email, 0, -10);
            $_SESSION['username'] = $user[0]['username'];
            $_SESSION['id'] = $user[0]['id'];
            header('Location: /'); // Redirect after successful login
            exit(); // Terminate script execution
            /*$pdo = null;
            $stmt = null;*/
        } else if (!$user) {
            $msg = '<p style="color:darkred">Wrong email or password</p>';
        } else {
            echo 'Something went wrong';
        }
    } catch (PDOException $e) {
        die('An error occurred' . $e->getMessage());
    }
}/* else {
    $msg = '<p style="color:darkred">Something went wrong</p>';
}*/
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>
    <link rel="stylesheet" href="css/simple.min.css">
</head>
<body>
<header>
    <h1>Creativity Clash ©</h1>
</header>
<?php echo $msg ?? null; ?>
<h2>Login</h2>
<form method="POST" action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" id="form">
    <label>
        Email Address
        <input id="email" type="email" name="email" placeholder="Enter your email address" required>
    </label>
    <label>
        Password
        <input id="password" type="password" name="password" placeholder="Enter your password" required>
    </label>
    <button name="submit" id="submit">Login</button>
    <span>Don't have an account?...<a href="/signup">Signup</a></span>
</form>
<script src="js/login.js"></script>
</body>
</html>