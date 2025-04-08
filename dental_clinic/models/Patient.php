<?php
require_once '../core/Model.php';

class Patient extends Model {
    protected $table = 'patients';
    protected $primaryKey = 'id';

    public function search($query) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE first_name LIKE :query 
            OR last_name LIKE :query 
            OR contact LIKE :query
        ");
        $stmt->execute(['query' => "%$query%"]);
        return $stmt->fetchAll();
    }

    public function getWithAppointments($id) {
        $stmt = $this->db->prepare("
            SELECT p.*, a.appointment_date, a.treatment, a.status 
            FROM {$this->table} p
            LEFT JOIN appointments a ON p.id = a.patient_id
            WHERE p.id = ?
            ORDER BY a.appointment_date DESC
        ");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public function getRecent($limit = 5) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            ORDER BY created_at DESC 
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}