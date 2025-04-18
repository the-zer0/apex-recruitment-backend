<?php
include 'includes/db.php';

// Get user's IP address
$ip_address = $_SERVER['REMOTE_ADDR'];

// Check if IP already submitted
$stmt = $conn->prepare("SELECT id FROM applicants WHERE ip_address = ?");
$stmt->bind_param("s", $ip_address);
$stmt->execute();
$stmt->store_result();
$already_applied = $stmt->num_rows > 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recruitment Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #e3f2fd, #fce4ec);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 500px;
            background-color: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #2c3e50;
        }

        .btn-primary {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
            border-radius: 10px;
        }

        .alert {
            position: absolute;
            top: 20px;
            width: 90%;
            max-width: 500px;
            z-index: 10;
        }

        .btn-disabled {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
</head>
<body>
    <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
        <div class="alert alert-success alert-dismissible fade show mx-auto" role="alert">
            <strong>Thank you!</strong> Our team will contact you shortly through email.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_GET['already_applied']) && $_GET['already_applied'] == 'true'): ?>
        <div class="alert alert-warning alert-dismissible fade show mx-auto" role="alert">
            <strong>Note:</strong> You've already submitted your application.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="container">
        <h1>Welcome to Our Recruitment</h1>
        <p class="mb-4">Apply now to join one of the most exciting and innovative teams!</p>

        <?php if ($already_applied): ?>
            <button class="btn btn-secondary btn-disabled" disabled>Already Applied</button>
        <?php else: ?>
            <a href="apply.php" class="btn btn-primary">Apply Now</a>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
