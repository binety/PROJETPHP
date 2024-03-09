<?php
require_once 'db.php';

// Fonction pour déterminer si un candidat est élu dès le premier tour
function check_winner($bureau_de_vote_id) {
    global $db;

    $query = "SELECT SUM(score) AS total_score FROM scores WHERE bureau_de_vote_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$bureau_de_vote_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $total_score = $result['total_score'];

    if ($total_score > 50) {
        echo "Le candidat est élu dès le premier tour avec $total_score % des voix.";
        return true;
    }

    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['bureau_vote'], $_POST['candidat'], $_POST['score'])) {
        $bureau_de_vote_id = $_POST['bureau_vote'];
        $candidat_id = $_POST['candidat'];
        $score = $_POST['score'];

        $query = "INSERT INTO scores (bureau_de_vote_id, candidat_id, score) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$bureau_de_vote_id, $candidat_id, $score]);

        echo "Score enregistré avec succès!<br>";

        // Vérifier si le candidat est élu dès le premier tour
        if (check_winner($bureau_de_vote_id)) {
            // Élection terminée, afficher les résultats
            exit();
        }

        // Sinon, trouver les candidats en ballotage
        $query = "SELECT candidat_id, SUM(score) AS total_score FROM scores WHERE bureau_de_vote_id = ? GROUP BY candidat_id ORDER BY total_score DESC LIMIT 2";
        $stmt = $db->prepare($query);
        $stmt->execute([$bureau_de_vote_id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($results) == 2) {
            $first_place = $results[0]['candidat_id'];
            $second_place = $results[1]['candidat_id'];
            echo "Les candidats en ballottage pour le second tour sont : $first_place et $second_place";
        } else {
            echo "Erreur : nombre de candidats incorrect pour déterminer le ballottage";
        }
    } else {
        echo "Erreur : champs manquants dans le formulaire.";
    }
}
?>
