<?php
// Include database connection
require_once 'config/db.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // For demo purposes, we'll set a default user_id
    // In a real application, this would come from the session
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;
    
    // Get form data
    $tip_content = mysqli_real_escape_string($conn, $_POST['tip_content']);
    
    // Insert tip into database
    $query = "INSERT INTO cooking_tips (user_id, tip_content) VALUES (?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "is", $user_id, $tip_content);
    
    if (mysqli_stmt_execute($stmt)) {
        // Success
        $_SESSION['message'] = "Cooking tip shared successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        // Error
        $_SESSION['message'] = "Error: " . mysqli_error($conn);
        $_SESSION['message_type'] = "danger";
    }
    
    // Redirect back to community page
    header("Location: community.php");
    exit();
}
?>