<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic - Appointment Details</title>
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
                        <a class="nav-link" href="/patients">Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/appointments">Appointments</a>
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
            <h1>Appointment Details</h1>
            <a href="/appointments" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Appointments</a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Appointment Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Patient:</strong> 
                            <a href="/patients/show/<?= htmlspecialchars($appointment['patient_id']) ?>">
                                <?= htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']) ?>
                            </a>
                        </p>
                        <p><strong>Date & Time:</strong> <?= htmlspecialchars(date('M d, Y h:i A', strtotime($appointment['appointment_date']))) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> 
                            <span class="badge bg-<?= 
                                $appointment['status'] === 'completed' ? 'success' : 
                                ($appointment['status'] === 'confirmed' ? 'primary' : 'warning') 
                            ?>">
                                <?= htmlspecialchars(ucfirst($appointment['status'])) ?>
                            </span>
                        </p>
                        <p><strong>Treatment:</strong> <?= htmlspecialchars($appointment['treatment']) ?></p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <p><strong>Notes:</strong></p>
                        <div class="border p-3 rounded">
                            <?= nl2br(htmlspecialchars($appointment['notes'] ?? 'No notes available')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Manage Appointment</h5>
            </div>
            <div class="card-body">
                <div class="btn-group" role="group">
                    <?php if ($appointment['status'] !== 'confirmed'): ?>
                        <a href="/appointments/update-status/<?= $appointment['id'] ?>/confirmed" 
                           class="btn btn-primary">
                            <i class="fas fa-check-circle"></i> Confirm
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($appointment['status'] !== 'completed'): ?>
                        <a href="/appointments/update-status/<?= $appointment['id'] ?>/completed" 
                           class="btn btn-success">
                            <i class="fas fa-check-double"></i> Complete
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($appointment['status'] !== 'cancelled'): ?>
                        <a href="/appointments/update-status/<?= $appointment['id'] ?>/cancelled" 
                           class="btn btn-danger">
                            <i class="fas fa-times-circle"></i> Cancel
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>