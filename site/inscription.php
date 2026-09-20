<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: accueil.php");
    exit();
}
require_once 'connexion.php';

$error_msg = "";
$success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim(htmlspecialchars($_POST['nom']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = $_POST['password'];

    if (!empty($nom) && !empty($email) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
            $stmt->execute(['email' => $email]);
            
            if ($stmt->rowCount() > 0) {
                $error_msg = "Cet email est déjà utilisé !";
            } else {
                $insert = $pdo->prepare("INSERT INTO utilisateurs (nom, email, password) VALUES (?, ?, ?)");
                $insert->execute([$nom, $email, $password]);

                $success_msg = "Inscription réussie ! Connexion en cours...";
                
                header("refresh:2;url=log.php");
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
  <link rel="stylesheet" href="log.css"> <link rel="icon" href="dress-up-logo.png" type="image/png">
  <title>Inscription - Dress-Up</title>
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
      .success-box {
          background-color: rgba(40, 167, 69, 0.2);
          color: #fff;
          padding: 10px;
          border-radius: 8px;
          margin-bottom: 15px;
          font-size: 14px;
          border: 1px solid #28a745;
          text-align: center;
          font-weight: bold;
      }
      

      .login-link {
          display: block;
          text-align: center;
          margin-top: 20px;
          font-size: 15px;
          color: #ca3a4f; 
          font-weight: bold;
          text-decoration: none;
          font-family: sans-serif;
          transition: 0.3s;
      }
      .login-link:hover {
          text-decoration: underline;
          color: #ff4d6d;
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
      <h2>Create your Account</h2>

      <?php if (!empty($error_msg)): ?>
          <div class="error-box"><?php echo htmlspecialchars($error_msg); ?></div>
      <?php endif; ?>

      <?php if (!empty($success_msg)): ?>
          <div class="success-box"><?php echo htmlspecialchars($success_msg); ?></div>
      <?php endif; ?>

      <form id="register-form" action="inscription.php" method="POST">
        
        <label for="nom">Full Name</label>
        <input id="nom" name="nom" type="text" placeholder="Your full name" required value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>">

        <label for="email">Email</label>
        <input id="email" name="email" type="email" placeholder="email@gmail.com" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Create a password" required>  

        <button type="submit"><b>Sign Up</b></button>
      </form>

      <a href="log.php" class="login-link">Déjà inscrit ? Connectez-vous ici</a>

    </article>
  </section>

</body>
</html>