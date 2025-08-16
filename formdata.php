<?php

include 'database.php'; 

// Collect form data
$insname     = $_POST['insname'];
$location    = $_POST['Location'];
$op_type     = $_POST['Opportunity_types']; // Name must match form exactly
$description = $_POST['opdescription'];
$deadline    = $_POST['Deadline'];

// Step 1: Get org_id from organization table
$sql_org = "SELECT org_id FROM organizations WHERE name = ?";
$stmt_org = $conn->prepare($sql_org);
$stmt_org->bind_param("s", $insname);
$stmt_org->execute();
$result_org = $stmt_org->get_result();

if ($result_org->num_rows > 0) {
    $row = $result_org->fetch_assoc();
    $org_id = $row['org_id'];
} else {
    // If not found, insert into organization table
    $insert_org = "INSERT INTO organizations (name, location) VALUES (?, ?)";
    $stmt_insert_org = $conn->prepare($insert_org);
    $stmt_insert_org->bind_param("ss", $insname, $location);
    $stmt_insert_org->execute();
    $org_id = $stmt_insert_org->insert_id;
}

// Step 2: Insert into opportunity table
$sql_op = "INSERT INTO opportunities
(org_id, title, description, type, location, eligibility, extrainfo, deadline, posted_at, status)
VALUES (?, ?, ?, ?, ?, NULL, NULL, ?, NOW(), 'active')";

$stmt_op = $conn->prepare($sql_op);
$stmt_op->bind_param("isssss", $org_id, $op_type, $description, $op_type, $location, $deadline);

if ($stmt_op->execute()) {
    echo "<h3>✅ Opportunity posted successfully!</h3>";
} else {
    echo "❌ Error: " . $stmt_op->error;
}

// Close connection
$conn->close();
?>
