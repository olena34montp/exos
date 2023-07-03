<?php

require_once '../../../core/db.php';

try {
    $db = DB::getPdo();
    // Requête infos pour requête AJAX
    $sql = $db->prepare(
        'SELECT id, prenom, alarme FROM personnes'
    );
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch (Exception $e) {
    $errorCode = $e->getCode();
    $data = "Une erreur est survenue lors de la communication avec la base de données. Veuillez contacter l'administrateur du système pour obtenir de l'aide. Code d'erreur: " . $errorCode;
    return $data;
}
exit;
