<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include '../includes/db.php';
include 'send_mail.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $applicant_id = $_POST['applicant_id'] ?? 0;
    $action = $_POST['action'] ?? '';
    $status = '';
    $subject = '';
    $body = '';

    if ($action === 'round1_pass') {
        $status = 'Round 1 Passed';
        $subject = "Round 1 Result - Passed";
        $body = "Congratulations! You've cleared Round 1.";
    } elseif ($action === 'round1_fail') {
        $status = 'Round 1 Failed';
        $subject = "Round 1 Result - Not Selected";
        $body = "Thank you for applying. Unfortunately, you didn't clear Round 1.";
    }

    if ($status && $applicant_id) {
        $stmt = $conn->prepare("UPDATE applicants SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $applicant_id);
        $stmt->execute();

        // Fetch email for sending mail
        $res = $conn->query("SELECT email, name FROM applicants WHERE id=$applicant_id");
        $row = $res->fetch_assoc();
        sendStatusMail($row['email'], $row['name'], $subject, $body);
    }
}

header("Location: dashboard.php");
exit;
