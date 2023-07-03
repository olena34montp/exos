<?php

class M_Home extends Model
{
    public function createClient(array $client)
    {
        try {
            $db = DB::getPdo();

            $sql = $db->prepare(
                'INSERT INTO personnes (nom, prenom, naissance, mail, adresse, tel) VALUES (:nom, :prenom, :date, :mail, :adresse, :tel)'
            );
            $sql->bindParam(':nom', $client['nom']);
            $sql->bindParam(':prenom', $client['prenom']);
            $sql->bindParam(':date', $client['date']);
            $sql->bindParam(':mail', $client['mail']);
            $sql->bindParam(':adresse', $client['adresse']);
            $sql->bindParam(':tel', $client['tel']);
            $sql->execute();

            $data = 'Le client '. $client['nom']. 'a bien été enregistré.';
            return $data;

        } catch (Exception $e) {
            $errorCode = $e->getCode();
            $data = "Une erreur est survenue lors de la communication avec la base de données. Veuillez contacter l'administrateur du système pour obtenir de l'aide. Code d'erreur: " . $errorCode;
            return $data;
        }
    }
}
