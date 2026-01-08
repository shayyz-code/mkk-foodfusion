<?php
session_start();
require_once 'config/db.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipe_id = isset($_POST['recipe_id']) ? (int)$_POST['recipe_id'] : 0;
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $user_name = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
    
    // Validation
    $errors = [];
    
    if ($recipe_id <= 0) {
        $errors[] = "Invalid recipe ID.";
    }
    
    if ($rating < 1 || $rating > 5) {
        $errors[] = "Rating must be between 1 and 5 stars.";
    }
    
    if (empty($user_name)) {
        $errors[] = "Please provide your name.";
    }
    
    if (empty($comment)) {
        $errors[] = "Please provide a comment.";
    }
    
    // Check if recipe exists
    if (empty($errors)) {
        $recipe_check = "SELECT id FROM recipes WHERE id = ?";
        $stmt = mysqli_prepare($conn, $recipe_check);
        mysqli_stmt_bind_param($stmt, "i", $recipe_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 0) {
            $errors[] = "Recipe not found.";
        }
    }
    
    // Get user ID if logged in
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
    // Check if user has already rated this recipe (if logged in)
    if (empty($errors) && $user_id) {
        $existing_rating = "SELECT id FROM recipe_ratings WHERE recipe_id = ? AND user_id = ?";
        $stmt = mysqli_prepare($conn, $existing_rating);
        mysqli_stmt_bind_param($stmt, "ii", $recipe_id, $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            // Update existing rating
            $update_query = "UPDATE recipe_ratings SET rating = ?, comment = ?, user_name = ?, created_at = CURRENT_TIMESTAMP WHERE recipe_id = ? AND user_id = ?";
            $stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($stmt, "issii", $rating, $comment, $user_name, $recipe_id, $user_id);
            
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['rating_message'] = "Your rating has been updated successfully!";
                $_SESSION['rating_type'] = "success";
            } else {
                $_SESSION['rating_message'] = "Error updating rating. Please try again.";
                $_SESSION['rating_type'] = "danger";
            }
        } else {
            // Insert new rating
            $insert_query = "INSERT INTO recipe_ratings (recipe_id, user_id, user_name, rating, comment) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($stmt, "iisis", $recipe_id, $user_id, $user_name, $rating, $comment);
            
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['rating_message'] = "Thank you for your rating and comment!";
                $_SESSION['rating_type'] = "success";
            } else {
                $_SESSION['rating_message'] = "Error saving rating. Please try again.";
                $_SESSION['rating_type'] = "danger";
            }
        }
    } else if (empty($errors)) {
        // Guest user - insert without user_id
        $insert_query = "INSERT INTO recipe_ratings (recipe_id, user_name, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt, "isis", $recipe_id, $user_name, $rating, $comment);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['rating_message'] = "Thank you for your rating and comment!";
            $_SESSION['rating_type'] = "success";
        } else {
            $_SESSION['rating_message'] = "Error saving rating. Please try again.";
            $_SESSION['rating_type'] = "danger";
        }
    }
    
    // Handle errors
    if (!empty($errors)) {
        $_SESSION['rating_message'] = implode(" ", $errors);
        $_SESSION['rating_type'] = "danger";
    }
    
    // Redirect back to recipe page
    header("Location: recipe.php?id=" . $recipe_id);
    exit();
} else {
    // If not POST request, redirect to recipes page
    header("Location: recipes.php");
    exit();
}
?>