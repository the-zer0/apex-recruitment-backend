<?php
include 'includes/db.php';
include 'includes/functions.php';
include 'admin/send_mail.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $domain = trim($_POST['domain'] ?? '');

    // Get user's IP address
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // Check if this IP has already submitted
    $checkStmt = $conn->prepare("SELECT id FROM applicants WHERE ip_address = ?");
    $checkStmt->bind_param("s", $ip_address);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Redirect with flag if already applied
        header("Location: index.php?already_applied=true");
        exit;
    }

    // Collect domain-specific questions
    $question1 = trim($_POST['question1'] ?? '');
    $question2 = trim($_POST['question2'] ?? '');
    $question3 = trim($_POST['question3'] ?? '');
    $question4 = trim($_POST['question4'] ?? '');
    $question5 = trim($_POST['question5'] ?? '');

    $resumePath = uploadResume($_FILES['resume']);

    if (!$resumePath) {
        die("Invalid resume upload.");
    }

    // Insert with IP address
    $stmt = $conn->prepare("INSERT INTO applicants (name, email, phone, domain, question1, question2, question3, question4, question5, resume_path, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $name, $email, $phone, $domain, $question1, $question2, $question3, $question4, $question5, $resumePath, $ip_address);

    if ($stmt->execute()) {
        sendAcknowledgementMail($email, $name);
        header("Location: index.php?success=true");
        exit;
    } else {
        echo "Database error: " . $stmt->error;
    }
}
?>
