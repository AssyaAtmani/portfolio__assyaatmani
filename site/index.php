

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: accueil.php");
    exit();
}

require_once 'connexion.php';

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {

        try {

            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $password == $user['password']) {

                // session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nom'];
                $_SESSION['role'] = $user['role'];

                // redirect
                if ($user['role'] === 'admin') {
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    header("Location: accueil.php");
                    exit();
                }

            } else {
                $error_msg = "Email ou mot de passe incorrect !";
            }

        } catch (PDOException $e) {
            $error_msg = "Erreur technique : " . $e->getMessage();
        }

    } else {
        $error_msg = "Veuillez remplir tous les champs !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="log.css">
  <link rel="icon" href="dress-up-logo.png" type="image/png">
  <title>Dress-Up</title>

  <style>
      .error-box {
          background-color: rgba(220, 53, 69, 0.2);
          color: #fff;
          padding: 10px;
          border-radius: 8px;
          margin-bottom: 15px;
          font-size: 14px;
          border: 1px solid #dc3545;
          text-align: center;
          font-weight: bold;
      }

      .signup-link {
          display: block;
          text-align: center;
          margin-top: 20px;
          font-size: 16px;
          color: #6e1623; 
          font-weight: bold;
          text-decoration: none;
          font-family: sans-serif;
          transition: 0.3s;
      }

      .signup-link:hover {
          text-decoration: underline;
          color: #b90e2e;
      }
  </style>
</head>

<body>
  
<header>
    <img class="logo" src="dress-up-logo.png" alt="Dress-Up Logo">
    <h1 class="two">Welcome to Dress-Up</h1>
</header>

<section>

<article class="login-container">

    <h2>Log in to Dress-Up</h2>

    <?php if (!empty($error_msg)): ?>
        <div class="error-box">
            <?php echo htmlspecialchars($error_msg); ?>
        </div>
    <?php endif; ?>

    <form id="login-form" action="log.php" method="POST">
        
        <label for="email">Email</label>
        <input id="email" name="email" type="email" placeholder="email@gmail.com" required
        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Your password" required>  

        <button type="submit"><b>Login</b></button>
    </form>

    <a href="inscription.php" class="signup-link">
        Vous n'avez pas de compte ? Inscrivez-vous ici
    </a>

</article>

</section>

</body>
</html>