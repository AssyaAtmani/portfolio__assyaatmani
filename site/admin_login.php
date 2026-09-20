<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: log.php");
    exit();
}
?>

<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {

        $_SESSION['admin'] = $admin['id'];
        header("Location: admin_dashboard.php");
        exit();

    } else {
        $error = "Login incorrect";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Login</title>

<style>
body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(to right, #000, #ca3a4f);
    font-family:Arial;
}

.box{
    background:white;
    padding:30px;
    width:300px;
    border-radius:10px;
    box-shadow:0 0 20px rgba(0,0,0,0.3);
    text-align:center;
}

input{
    width:90%;
    padding:10px;
    margin:10px 0;
}

button{
    width:100%;
    padding:10px;
    background:#ca3a4f;
    color:white;
    border:none;
    cursor:pointer;
}

button:hover{
    background:#000;
}

.error{
    color:red;
}
</style>
</head>

<body>

<div class="box">
    <h2>Admin Login</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <?php if(!empty($error)) echo "<p class='error'>$error</p>"; ?>
</div>

</body>
</html>