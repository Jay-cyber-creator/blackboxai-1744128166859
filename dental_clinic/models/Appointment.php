<?php
require_once '../core/Model.php';

class Appointment extends Model {
    protected $table = 'appointments';
    protected $primaryKey = 'id';

    public function getByPatientId($patientId) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE patient_id = ? 
            ORDER BY appointment_date DESC
        ");
        $stmt->execute([$patientId]);
        return $stmt->fetchAll();
    }

    public function getUpcoming($limit = 5) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE appointment_date > NOW() 
            ORDER BY appointment_date ASC 
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function countByStatus($status) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM {$this->table} 
            WHERE status = ?
        ");
        $stmt->execute([$status]);
        return $stmt->fetchColumn();
    }
}