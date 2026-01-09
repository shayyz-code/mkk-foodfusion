<?php

// Include database connection
require_once 'config/db.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
    
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
    
    $upload_dir_fs = __DIR__ . '/assets/uploads/recipes/';
    $upload_dir_web = 'assets/uploads/recipes/';
    $image_path = null;
    
    if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] == 0) {
        $allowed_image_ext = ['jpg','jpeg','png','gif','webp'];
        $allowed_file_ext = array_merge($allowed_image_ext, ['pdf']);
        $file_extension = strtolower(pathinfo($_FILES['recipe_image']['name'], PATHINFO_EXTENSION));
        if (!in_array($file_extension, $allowed_file_ext)) {
            $_SESSION['message'] = "Unsupported file type. Please upload an image or PDF.";
            $_SESSION['message_type'] = "danger";
            header("Location: community.php");
            exit();
        }
        if (!is_dir($upload_dir_fs)) {
            @mkdir($upload_dir_fs, 0755, true);
        }
        $filename = uniqid('recipe_') . '.' . $file_extension;
        $target_file_fs = $upload_dir_fs . $filename;
        $target_file_web = $upload_dir_web . $filename;
        if (in_array($file_extension, $allowed_image_ext)) {
            $check = @getimagesize($_FILES['recipe_image']['tmp_name']);
            if ($check === false) {
                $_SESSION['message'] = "Invalid image file.";
                $_SESSION['message_type'] = "danger";
                header("Location: community.php");
                exit();
            }
        }
        if (!is_uploaded_file($_FILES['recipe_image']['tmp_name'])) {
            $_SESSION['message'] = "Upload failed. Please try again.";
            $_SESSION['message_type'] = "danger";
            header("Location: community.php");
            exit();
        }
        if (!@move_uploaded_file($_FILES['recipe_image']['tmp_name'], $target_file_fs)) {
            $_SESSION['message'] = "Unable to save the uploaded file.";
            $_SESSION['message_type'] = "danger";
            header("Location: community.php");
            exit();
        }
        $image_path = $target_file_web;
    } else {
        $_SESSION['message'] = "Please upload a photo or PDF for your recipe.";
        $_SESSION['message_type'] = "danger";
        header("Location: community.php");
        exit();
    }
    
    // Insert recipe into database, handle NULL user_id explicitly to avoid FK issues
    if ($user_id === null) {
        $query = "INSERT INTO recipes (user_id, title, description, ingredients, instructions, 
                  cuisine_type, dietary_pref, difficulty, prep_time, cook_time, image_path, is_community) 
                  VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssiisi",
            $title, $description, $ingredients_str, $instructions_str,
            $cuisine_type, $dietary_pref, $difficulty, $prep_time, $cook_time, $image_path, $is_community
        );
    } else {
        $query = "INSERT INTO recipes (user_id, title, description, ingredients, instructions, 
                  cuisine_type, dietary_pref, difficulty, prep_time, cook_time, image_path, is_community) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "isssssssiisi",
            $user_id, $title, $description, $ingredients_str, $instructions_str,
            $cuisine_type, $dietary_pref, $difficulty, $prep_time, $cook_time, $image_path, $is_community
        );
    }
    
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
