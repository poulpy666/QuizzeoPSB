<?php
session_start();

// Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
if (!isset($_SESSION["id_test"]) || !isset($_SESSION["pseudo"]) || ($_SESSION["role"] !== "quizzer" && $_SESSION["role"] !== "admin")) {
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

    $deleteQuery = "DELETE FROM user_quizz WHERE id_quizz = '$id'";
    mysqli_query($conn, $deleteQuery);

    if ($_SESSION["role"] === "quizzer") {
        header("Location: quizzer.php");
    } elseif ($_SESSION["role"] === "admin") {
        header("Location: admin.php");
    }
    exit();
}
?><br>
<footer class="fixed_footer">
  <div class="content">
    <p>&copy; - Stive Gamy  -  Babacar Gueye -  Paul Vicens </p>
  </div>
</footer>
