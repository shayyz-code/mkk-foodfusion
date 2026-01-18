<?php
// Include database connection
require_once '../config/db.php';

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// Check if account is locked
if (isset($_SESSION['login_locked']) && $_SESSION['login_locked'] === true) {
    $lock_time = $_SESSION['login_lock_time'];
    $time_now = time();
    $time_diff = $time_now - $lock_time;
    
    if ($time_diff > 180) {
        $_SESSION['login_locked'] = false;
        $_SESSION['login_attempts'] = 0;
        unset($_SESSION['login_lock_time']);
    } else {
        $time_left = 180 - $time_diff;
        $message = "Account is locked due to too many failed attempts. Try again in " . $time_left . " seconds.";
        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'errors' => [$message]]);
        } else {
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = "danger";
            header("Location: ../index.php");
        }
        exit();
    }
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    // Validate input
    $errors = [];
    
    // Check if user exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Reset login attempts on successful login
            $_SESSION['login_attempts'] = 0;
            
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            
            // Success message
            $_SESSION['message'] = "Login successful! Welcome back, " . $user['first_name'] . "!";
            $_SESSION['message_type'] = "success";
            
            // If AJAX request, return success message, otherwise redirect
            if($is_ajax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Login successful']);
                exit();
            } else {
                header("Location: ../index.php");
                exit();
            }
        } else {
            // Increment login attempts
            if (!isset($_SESSION['login_attempts'])) {
                $_SESSION['login_attempts'] = 1;
            } else {
                $_SESSION['login_attempts']++;
            }
            
            // Check if max attempts reached
            if ($_SESSION['login_attempts'] >= 3) {
                $_SESSION['login_locked'] = true;
                $_SESSION['login_lock_time'] = time();
                $message = "Account locked due to too many failed attempts. Try again in 3 minutes.";
                if ($is_ajax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'errors' => [$message]]);
                } else {
                    $_SESSION['message'] = $message;
                    $_SESSION['message_type'] = "danger";
                    header("Location: ../index.php");
                }
                exit();
            }
            
            $errors[] = "Invalid password. Please try again. Attempts: " . $_SESSION['login_attempts'] . "/3";
        }
    } else {
        // Increment login attempts even for non-existent emails for security
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 1;
        } else {
            $_SESSION['login_attempts']++;
        }
        
        // Check if max attempts reached
        if ($_SESSION['login_attempts'] >= 3) {
            $_SESSION['login_locked'] = true;
            $_SESSION['login_lock_time'] = time();
            $message = "Account locked due to too many failed attempts. Try again in 3 minutes.";
            if ($is_ajax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'errors' => [$message]]);
            } else {
                $_SESSION['message'] = $message;
                $_SESSION['message_type'] = "danger";
                header("Location: ../index.php");
            }
            exit();
        }
        
        $errors[] = "Email not found. Please register or try a different email. Attempts: " . $_SESSION['login_attempts'] . "/3";
    }
    
    if (!empty($errors)) {
        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'errors' => $errors]);
        } else {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_type'] = 'login';
            $_SESSION['form_data'] = ['email' => $email];
            $redirect = isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])
                ? $_SERVER['HTTP_REFERER']
                : '../index.php';
            header("Location: " . $redirect);
        }
        exit();
    }
}
?>
