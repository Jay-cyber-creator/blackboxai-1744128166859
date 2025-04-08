<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic - Appointments</title>
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
                        <a class="nav-link active" href="#">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Appointments</h1>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="d-flex justify-content-between mb-3">
            <div>
                <a href="/appointments/create" class="btn btn-success"><i class="fas fa-plus"></i> New Appointment</a>
            </div>
            <div>
                <div class="btn-group" role="group">
                    <a href="/appointments" class="btn btn-outline-secondary">All</a>
                    <a href="/appointments?status=pending" class="btn btn-outline-warning">Pending</a>
                    <a href="/appointments?status=confirmed" class="btn btn-outline-primary">Confirmed</a>
                    <a href="/appointments?status=completed" class="btn btn-outline-success">Completed</a>
                </div>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Date & Time</th>
                    <th>Treatment</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?= htmlspecialchars($appointment['id']) ?></td>
                        <td>
                            <a href="/patients/show/<?= htmlspecialchars($appointment['patient_id']) ?>">
                                <?= htmlspecialchars($appointment['patient_name'] ?? 'Unknown') ?>
                            </a>
                        </td>
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
                            <a href="/appointments/show/<?= htmlspecialchars($appointment['id']) ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>