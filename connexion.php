<?php
    include 'header.php';
?>
<?php
// On récupère les valeurs saisies
if(isset($_POST["button"])){
    $username = $_POST["pseudo"];
    $password = sha1($_POST["password"]);
    // On se connecte à la base de donnée 
    $connect_bdd = mysqli_connect("127.0.0.1","root","","quizzeo");
    // On lance la requête de récupération des valeurs saisies
    $req = "SELECT * FROM Users WHERE pseudo = '$username' AND password = '$password'";
    $res = mysqli_query($connect_bdd, $req);
    
    // On fait une condition au cas où les données saisies sont correctes ou fausses
    if(mysqli_num_rows($res) > 0){
        $row = mysqli_fetch_assoc($res);
        $_SESSION["pseudo"] = $username;
        $_SESSION["id_test"] = $row["id_test"];

        // Vérification du rôle admin
        if ($row["role"] == "admin") {
            $_SESSION["role"] = "admin";
            header("location: admin.php");
        }
        // Vérification du rôle quizzer
        elseif ($row["role"] == "quizzer") {
            $_SESSION["role"] = "quizzer";
            header("location: quizzer.php");
        }
        // Redirection vers la page utilisateur
        elseif ($row["role"] == "utilisateur"){
            $_SESSION["role"] = "utilisateur";
            header("location: user.php");
        }
    } else {
        echo "<p id='erreur'>Erreur de Connexion<p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="connectE.css">
</head>
<body>
    <style>
        body{
            background-image:url(img/bgadmin);
             background-size:100%;
            }
    </style>
    <div class="container">
        <br><br>
        <div class="border border-secondary w-50 mx-auto rounded bidoop">
            <br>
            <form action="" method="post">
                <h1>Connexion</h1>
                <br>
                <input type="text" name="pseudo" placeholder="Entrer votre Pseudo" required  ><br><br>
                <input type="password" name="password" placeholder="Entrer votre Mot De Passe"required ><br><br>
                <button type="submit" name="button">Se connecter</button>
                <a href="inscription.php">Créer un compte</a>
            </form>
        </div>
    </div><br><br><br>
    <footer class="fixed_footer">
  <div class="content">
    <p>&copy; - Stive Gamy  -  Babacar Gueye -  Paul Vicens </p>
  </div>
</footer>
</body>
</html>
