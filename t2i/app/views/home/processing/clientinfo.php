<?php

require_once '../../../core/db.php';

if(isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    try {
        $db = DB::getPdo();
        // Requête infos pour requête AJAX
        $sql = $db->prepare(
            'SELECT *, DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), naissance)), "%Y") + 0 AS age, MONTH(naissance) AS month_birth, DAY(naissance) AS day_birth FROM personnes WHERE id = :id'
        );
        $sql->bindParam(':id', $id);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
    } catch (Exception $e) {
        $errorCode = $e->getCode();
        $data = "Une erreur est survenue lors de la communication avec la base de données. Veuillez contacter l'administrateur du système pour obtenir de l'aide. Code d'erreur: " . $errorCode;
        return $data;
    }
    exit;
}
    