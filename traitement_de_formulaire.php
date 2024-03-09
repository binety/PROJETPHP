<?php
require_once 'connexion_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['bureau_vote'], $_POST['candidat'], $_POST['score'])) {
        $bureau_de_vote_id = $_POST['bureau_vote'];
        $candidat_id = $_POST['candidat'];
        $score = $_POST['score'];

        $query = "INSERT INTO scores (bureau_de_vote_id, candidat_id, score) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$bureau_de_vote_id, $candidat_id, $score]);

        echo "Score enregistré avec succès!";
    } else {
        echo "Erreur : champs manquants dans le formulaire.";
    }
}
?>
