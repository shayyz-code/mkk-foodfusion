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
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $cuisine_type = mysqli_real_escape_string($conn, $_POST['cuisine_type']);
    $dietary_pref = isset($_POST['dietary_pref']) ? mysqli_real_escape_string($conn, $_POST['dietary_pref']) : '';
    $difficulty = mysqli_real_escape_string($conn, $_POST['difficulty']);
    $prep_time = (int)$_POST['prep_time'];
    $cook_time = (int)$_POST['cook_time'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $is_community = isset($_POST['is_community']) ? 1 : 0;
    
    // Process ingredients and instructions arrays
    $ingredients = isset($_POST['ingredients']) ? $_POST['ingredients'] : [];
    $instructions = isset($_POST['instructions']) ? $_POST['instructions'] : [];
    
    // Convert arrays to strings
    $ingredients_str = mysqli_real_escape_string($conn, implode("\n", array_filter($ingredients)));
    $instructions_str = mysqli_real_escape_string($conn, implode("\n", array_filter($instructions)));
    
    // Handle image upload
    $image_path = 'images/recipes/default-recipe.jpg'; // Default image
    
    if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] == 0) {
        $upload_dir = 'images/recipes/';
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Generate unique filename
        $file_extension = pathinfo($_FILES['recipe_image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('recipe_') . '.' . $file_extension;
        $target_file = $upload_dir . $filename;
        
        // Check if image file is a actual image
        $check = getimagesize($_FILES['recipe_image']['tmp_name']);
        if ($check !== false) {
            // Try to upload file
            if (move_uploaded_file($_FILES['recipe_image']['tmp_name'], $target_file)) {
                $image_path = $target_file;
            }
        }
    }
    
    // Insert recipe into database
    $query = "INSERT INTO recipes (user_id, title, description, ingredients, instructions, 
              cuisine_type, dietary_pref, difficulty, prep_time, cook_time, image_path, is_community) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "isssssssiiis", 
        $user_id, $title, $description, $ingredients_str, $instructions_str, 
        $cuisine_type, $dietary_pref, $difficulty, $prep_time, $cook_time, $image_path, $is_community);
    
    if (mysqli_stmt_execute($stmt)) {
        // Success
        $_SESSION['message'] = "Recipe submitted successfully!";
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