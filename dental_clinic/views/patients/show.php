<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic - Patient Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dental Clinic</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/patients">Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/appointments">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Patient Details</h1>
            <a href="/patients" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Patients</a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Personal Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> <?= htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']) ?></p>
                        <p><strong>Birth Date:</strong> <?= htmlspecialchars($patient['birth_date'] ?? 'N/A') ?></p>
                        <p><strong>Gender:</strong> <?= htmlspecialchars(ucfirst($patient['gender'] ?? 'N/A')) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Contact:</strong> <?= htmlspecialchars($patient['contact']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($patient['email'] ?? 'N/A') ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Address:</strong> <?= htmlspecialchars($patient['address'] ?? 'N/A') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Medical History</h5>
            </div>
            <div class="card-body">
                <p><?= nl2br(htmlspecialchars($patient['medical_history'] ?? 'No medical history recorded')) ?></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Appointment History</h5>
                <a href="/appointments/create?patient_id=<?= $patient['id'] ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> New Appointment
                </a>
            </div>
            <div class="card-body">
                <?php if (!empty($appointments)): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Treatment</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr>
                                    <td><?= htmlspecialchars(date('M d, Y h:i A', strtotime($appointment['appointment_date']))) ?></td>
                                    <td><?= htmlspecialchars($appointment['treatment']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= 
                                            $appointment['status'] === 'completed' ? 'success' : 
                                            ($appointment['status'] === 'confirmed' ? 'primary' : 'warning') 
                                        ?>">
                                            <?= htmlspecialchars(ucfirst($appointment['status'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/appointments/show/<?= $appointment['id'] ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No appointments found for this patient.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>