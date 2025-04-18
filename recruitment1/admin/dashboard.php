<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include '../includes/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../mailer/PHPMailer/PHPMailer.php';
require '../mailer/PHPMailer/SMTP.php';
require '../mailer/PHPMailer/Exception.php';

// Function to send a basic email using PHPMailer
function sendEmail($email, $name, $subject) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'apexmlrit@gmail.com'; // Replace with your email
        $mail->Password = 'uzwp qajt tfah ftvo';    // Replace with your app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('apexmlrit@gmail.com', 'APEX MLRIT - Recruitment Team');
        $mail->addAddress($email, $name);
        $mail->Subject = $subject;
        $mail->Body = "Hello $name,\n\n$subject\n\nBest Regards,\nThe Recruitment Team";

        $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error (sendEmail): {$mail->ErrorInfo}");
    }
}

// Function to send a custom email with link and time using PHPMailer
function sendCustomEmail($email, $name, $link, $time) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'apexmlrit@gmail.com'; // Replace with your email
        $mail->Password = 'uzwp qajt tfah ftvo';    // Replace with your app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('apexmlrit@gmail.com', 'APEX MLRIT - Recruitment Team');
        $mail->addAddress($email, $name);
        $mail->Subject = 'Your Custom Link and Time';
        $mail->Body = "Hello $name,\n\nYou have been provided with the following link and time:\n\nLink: $link\nTime: $time\n\nBest Regards,\nThe Recruitment Team";

        $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error (sendCustomEmail): {$mail->ErrorInfo}");
    }
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $applicant_id = $_POST['applicant_id'];
    $action = $_POST['action'];
    $applicant = $conn->query("SELECT * FROM applicants WHERE id = $applicant_id")->fetch_assoc();
    $email = $applicant['email'];
    $name = $applicant['name'];

    switch ($action) {
        case 'round1_pass':
            $conn->query("UPDATE applicants SET status = 'Round 1 Pass' WHERE id = $applicant_id");
            sendEmail($email, $name, 'Congratulations! You have passed Round 1');
            break;
        case 'round1_fail':
            $conn->query("UPDATE applicants SET status = 'Disqualified' WHERE id = $applicant_id");
            sendEmail($email, $name, 'Unfortunately, you have been disqualified after Round 1');
            break;
        case 'round2_pass':
            $conn->query("UPDATE applicants SET status = 'Qualified' WHERE id = $applicant_id");
            sendEmail($email, $name, 'Congratulations! You are qualified.');
            break;
        case 'round2_fail':
            $conn->query("UPDATE applicants SET status = 'Round 2 Fail' WHERE id = $applicant_id");
            sendEmail($email, $name, 'Unfortunately, you have failed Round 2');
            break;
        case 'send_custom_email':
            $link = $_POST['link'];
            $time = $_POST['time'];
            sendCustomEmail($email, $name, $link, $time);
            break;
    }
}

$result = $conn->query("SELECT * FROM applicants ORDER BY id DESC");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            background-color: #fff;
            padding: 2rem;
            margin-top: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        h2 {
            font-weight: 600;
            color: #343a40;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle !important;
        }
        .btn-sm {
            padding: 0.3rem 0.75rem;
            font-size: 0.85rem;
        }
        .d-flex.gap-2 {
            justify-content: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4 text-center">All Applicants</h2>
    <table class="table table-bordered table-hover align-middle">
    <thead class="table-light">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Domain</th>
        <th>Answers</th>
        <th>Resume</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
</thead>

        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['domain']) ?></td>
                <td class="text-start">
        <strong>Q1:</strong> <?= nl2br(htmlspecialchars($row['question1'])) ?><br>
        <strong>Q2:</strong> <?= nl2br(htmlspecialchars($row['question2'])) ?><br>
        <strong>Q3:</strong> <?= nl2br(htmlspecialchars($row['question3'])) ?><br>
        <strong>Q4:</strong> <?= nl2br(htmlspecialchars($row['question4'])) ?><br>
        <strong>Q5:</strong> <?= nl2br(htmlspecialchars($row['question5'])) ?>
    </td>
    <td>
        <a href="../<?= htmlspecialchars($row['resume_path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">Download</a>
    </td>

                <td><?= htmlspecialchars($row['status'] ?? 'Pending') ?></td>
                <td>
                    <?php if ($row['status'] === 'Disqualified'): ?>
                        <span class="text-danger">Disqualified</span>
                    <?php elseif ($row['status'] === 'Qualified'): ?>
                        <span class="text-success">Qualified</span>
                    <?php else: ?>
                        <form action="" method="post" class="d-flex flex-column gap-1">
                            <input type="hidden" name="applicant_id" value="<?= $row['id'] ?>">
                            <?php if ($row['status'] === 'Round 1 Pass'): ?>
                                <button name="action" value="round2_pass" class="btn btn-success btn-sm">Round 2 Pass</button>
                                <button name="action" value="round2_fail" class="btn btn-danger btn-sm">Round 2 Fail</button>
                            <?php elseif ($row['status'] === 'Round 2 Fail'): ?>
                                <span class="text-danger">Round 2 Fail</span>
                            <?php else: ?>
                                <button name="action" value="round1_pass" class="btn btn-success btn-sm">Round 1 Pass</button>
                                <button name="action" value="round1_fail" class="btn btn-danger btn-sm">Round 1 Fail</button>
                            <?php endif; ?>
                            <!-- Send Custom Email Button -->
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#customModal<?= $row['id'] ?>">Send Custom Email</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>

            <!-- Custom Modal -->
            <div class="modal fade" id="customModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Send Custom Email</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post">
                                <input type="hidden" name="applicant_id" value="<?= $row['id'] ?>">
                                <div class="mb-3">
                                    <label for="link" class="form-label">Link</label>
                                    <input type="text" class="form-control" name="link" required>
                                </div>
                                <div class="mb-3">
                                    <label for="time" class="form-label">Time</label>
                                    <input type="text" class="form-control" name="time" required>
                                </div>
                                <button type="submit" name="action" value="send_custom_email" class="btn btn-primary">Send Email</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
