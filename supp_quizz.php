<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'admin, sinon rediriger vers la page de connexion
if (!isset($_SESSION["pseudo"]) && $_SESSION["role"] !== "admin") {
    header("location: Connexion.php");
    exit();
}

if (isset($_GET["id_quizz"])) {
    $id = $_GET["id_quizz"];
    
    $conn = mysqli_connect("127.0.0.1", "root", "", "quizzeo");

    $updateQuery = $sql = "DELETE choices FROM choices
    JOIN questions ON choices.id_question = questions.id_question
    WHERE questions.id_quizz = '$id'";
    mysqli_query($conn, $updateQuery);

    $deleteQuery = "DELETE FROM questions WHERE id_quizz = '$id'";
    mysqli_query($conn, $deleteQuery);

    $deleteQuery = "DELETE FROM quizzes WHERE id_quizz = '$id'";
    mysqli_query($conn, $deleteQuery);

    header("location: admin_edit_quizz.php");
    exit();
}

?>
