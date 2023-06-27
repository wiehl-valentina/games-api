<?php
class PlatformController {
    private $db;

    public function __construct($db) {
        $this->db = $db->getDb();
    }

    public function getAllPlatforms() {
        $query = "SELECT * FROM plataformas";
        $stmt = $this->db->query($query);
        $platforms = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $platform = array('id' => $row['id'], 'nombre' => $row['nombre']);
            $platforms[] = $platform;
        }
        return $platforms;
    }

    public function createPlatform($nombre) {
        $query = "INSERT INTO plataformas (nombre) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$nombre]);
        $id = $this->db->lastInsertId();
        return array('id'=>$id,'nombre'=>$nombre);
    }

    public function updatePlatform($id, $nombre) {
        $query = "UPDATE plataformas SET nombre = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$nombre,$id]);
        return array('id'=>$id,'nombre'=>$nombre);
    }

    public function deletePlatform($id) {
        $query = "DELETE FROM plataformas WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }

    public function existsById($id){
        $query = "SELECT id FROM plataformas WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return ($stmt->rowCount()!=0);
    }

    public function getById($id){
        $query = "SELECT nombre FROM plataformas WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $platform = $stmt->fetch(PDO::FETCH_ASSOC);
        return $platform['nombre'];
    }

    public function idUsed($id){
        $query = "SELECT id FROM juegos WHERE id_plataforma = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return ($stmt->rowCount()!=0);
    }
}