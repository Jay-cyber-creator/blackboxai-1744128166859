<?php
require_once '../core/Controller.php';
require_once '../models/Patient.php';

class PatientController extends Controller {
    private $patientModel;

    public function __construct() {
        parent::__construct();
        $this->patientModel = new Patient();
    }

    public function index() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        $patients = $this->patientModel->all();
        $this->view('patients/index', [
            'patients' => $patients,
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
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'birth_date' => $_POST['birth_date'],
                'gender' => $_POST['gender'],
                'contact' => $_POST['contact'],
                'email' => $_POST['email'],
                'address' => $_POST['address'],
                'medical_history' => $_POST['medical_history']
            ];

            if ($this->patientModel->create($data)) {
                $_SESSION['success'] = 'Patient created successfully';
                $this->redirect('/patients');
            } else {
                $error = 'Failed to create patient';
                $this->view('patients/create', [
                    'error' => $error,
                    'patient' => $data,
                    'csrf_token' => $this->generateCSRFToken()
                ]);
            }
        } else {
            $this->view('patients/create', [
                'csrf_token' => $this->generateCSRFToken()
            ]);
        }
    }

    public function show($id) {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        $patient = $this->patientModel->find($id);
        if (!$patient) {
            $this->redirect('/404');
        }

        $appointments = $this->patientModel->getWithAppointments($id);
        $this->view('patients/show', [
            'patient' => $patient,
            'appointments' => $appointments,
            'csrf_token' => $this->generateCSRFToken()
        ]);
    }

    public function search() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        $query = $_GET['query'] ?? '';
        $patients = $this->patientModel->search($query);
        $this->view('patients/index', [
            'patients' => $patients,
            'searchQuery' => $query,
            'csrf_token' => $this->generateCSRFToken()
        ]);
    }
}