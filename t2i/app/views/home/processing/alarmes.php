<?php

require_once '../../../core/db.php';

if(isset($_GET['id']) && isset($_GET['status'])) {

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $status = filter_input(INPUT_GET, 'status', FILTER_DEFAULT);

    try {
        $db = DB::getPdo();
        // Requête infos pour requête AJAX
        $sql = $db->prepare(
            'UPDATE personnes SET alarme = :status WHERE id = :id'
        );
        $sql->bindParam(':id', $id);
        $sql->bindParam(':status', $status);
        $sql->execute();

        $result = "ok";

        echo json_encode($result);

    } catch (Exception $e) {
        $errorCode = $e->getCode();
        $data = "Une erreur est survenue lors de la communication avec la base de données. Veuillez contacter l'administrateur du système pour obtenir de l'aide. Code d'erreur: " . $errorCode;
        return $data;
    }
    exit;
}
