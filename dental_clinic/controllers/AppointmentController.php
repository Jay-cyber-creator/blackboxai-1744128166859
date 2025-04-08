<?php
require_once '../core/Controller.php';
require_once '../models/Appointment.php';
require_once '../models/Patient.php';

class AppointmentController extends Controller {
    private $appointmentModel;
    private $patientModel;

    public function __construct() {
        parent::__construct();
        $this->appointmentModel = new Appointment();
        $this->patientModel = new Patient();
    }

    public function index() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        $appointments = $this->appointmentModel->all();
        $this->view('appointments/index', [
            'appointments' => $appointments,
            'csrf_token' => $this->generateCSRFToken()
        ]);
    }

    public function create() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $data = [
                'patient_id' => $_POST['patient_id'],
                'user_id' => $_SESSION['user_id'],
                'appointment_date' => $_POST['appointment_date'],
                'treatment' => $_POST['treatment'],
                'notes' => $_POST['notes'],
                'status' => 'pending'
            ];

            if ($this->appointmentModel->create($data)) {
                $_SESSION['success'] = 'Appointment created successfully';
                $this->redirect('/appointments');
            } else {
                $error = 'Failed to create appointment';
                $this->view('appointments/create', [
                    'error' => $error,
                    'appointment' => $data,
                    'patients' => $this->patientModel->all(),
                    'csrf_token' => $this->generateCSRFToken()
                ]);
            }
        } else {
            $patients = $this->patientModel->all();
            $this->view('appointments/create', [
                'patients' => $patients,
                'patient_id' => $_GET['patient_id'] ?? null,
                'csrf_token' => $this->generateCSRFToken()
            ]);
        }
    }

    public function show($id) {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        $appointment = $this->appointmentModel->find($id);
        if (!$appointment) {
            $this->redirect('/404');
        }

        $patient = $this->patientModel->find($appointment['patient_id']);
        $this->view('appointments/show', [
            'appointment' => $appointment,
            'patient' => $patient,
            'csrf_token' => $this->generateCSRFToken()
        ]);
    }

    public function updateStatus($id, $status) {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        $validStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        if (!in_array($status, $validStatuses)) {
            $this->redirect('/400');
        }

        if ($this->appointmentModel->update($id, ['status' => $status])) {
            $_SESSION['success'] = "Appointment status updated to $status";
        } else {
            $_SESSION['error'] = 'Failed to update appointment status';
        }

        $this->redirect('/appointments/show/' . $id);
    }
}