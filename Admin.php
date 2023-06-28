<?php
session_start();
// Vérifier si l'utilisateur est connecté en tant qu'admin, sinon rediriger vers la page de connexion
if (!isset($_SESSION["pseudo"]) && $_SESSION["role"] !== "admin") {
    header("location: Connexion.php");
    exit();
}

function BDDconnect() {
    $connect_bdd = mysqli_connect("127.0.0.1", "root", "", "quizzeo");
    if (!$connect_bdd) {
        die("Échec de la connexion à la base de données: " .mysqli_error($connect_bdd));
    }
    return $connect_bdd;
}
$connect = BDDconnect();


// Récupérer la liste des utilisateurs
$query = "SELECT * FROM Users";
$result = mysqli_query($connect, $query);
$users = [];

while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

if (isset($_POST['logout']) && $_POST['logout'] === 'true') {
    // Détruire la session
    session_destroy();

    // Rediriger vers la page de connexion
    header("location: Connexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>   
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administrateur</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="connect2.css">
    </head>
    <body>
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <div class="container-fluid">
                <a href="index.php"><img class="navbar-brand" src="img/logo-quiz-symboles-bulle-dialogue-concept-spectacle-questionnaire-chante-bouton-quiz-concours-questions-examen-embleme-moderne-interview_180786-72.avif" width="75" height="75" class="d-inline-block align-top" alt="Erreur"></a>
                <div class="navbar" id="navbarNav">
                    <ul class="navbar-nav  ">
                        <div class="inscri">
                            <li class="nav-item">
                                <br><p class="bonjour">Bonjour <span><?php echo ucfirst($_SESSION["pseudo"]); ?></span>, Bienvenue !</p>
                            </li>
                        </div>
                        <div class="conn">
                            <li class="nav-item">
                                <form action="" method="post">
                                    <input type="hidden" name="logout" value="true">
                                    <button type="submit">Déconnexion</button>
                                </form>
                            </li>
                        </div>
                        <div class="deco">
                            <li class="nav-item">
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
        <div class="container">
            <div class="card bg-light">
                <div class="card-header">
                    <h3>Liste des utilisateurs</h3>
                </div>
                <div class="card-body">
                    <div class ="tableau">
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Nom d'utilisateur</th>
                                <th>Rôle</th>
                                <th>Actions</th>
                            </tr>
                            <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?php echo $user['id_test']; ?></td>
                                <td><?php echo $user['pseudo']; ?></td>
                                <td><?php echo $user['role']; ?></td>
                                <td>
                                <a href="edit_user.php?id_test=<?php echo $user['id_test']; ?>">Modifier</a>
                                <?php if ($_SESSION["role"] === "admin" && $user['id_test'] !== $_SESSION["id_test"]) : ?>
                                    <a href="supp_user.php?id_test=<?php echo $user['id_test']; ?>">Supprimer</a>
                                <?php endif; ?>
                                </td>
                                </tr>
                                <?php endforeach; ?>
                        </table>
                    </div>                 
                </div>
            </div><br><br>
            <div class="card bg-light">
                <div class="card-header">
                    <h3>Liste des quizz</h3>
                </div>
                <div class="card-body">
                    <a href="admin_edit_quizz.php">Voir la liste des quizz</a>
                </div>
            </div><br><br>
            <div class="card bg-light">
                <div class="card-header">
                    <h3>Ajouter un quizz</h3>
                </div>   
                <div class="card-body">
                    <a href="ajout_quiz.php">Ajouter un quizz</a>
                </div>              
            </div>
        </div>
    </body>
</html>
