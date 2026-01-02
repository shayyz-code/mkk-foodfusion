<?php
// ======================
// DEBUG MODE ENABLED
// ======================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
require_once '../config/database.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check database connection
if (!isset($conn) || !$conn) {
    $error = "Database connection failed or not defined.";
    die(json_encode(['success' => false, 'error' => $error]));
}

// Helper: Detect AJAX
$is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $error = "Invalid request method: " . $_SERVER['REQUEST_METHOD'];
    if ($is_ajax) {
        echo json_encode(['success' => false, 'error' => $error]);
    } else {
        echo "<pre>$error</pre>";
    }
    exit;
}

// ======================
// GET AND VALIDATE INPUT
// ======================
$first_name = trim($_POST['first_name'] ?? '');
$last_name  = trim($_POST['last_name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$password   = $_POST['password'] ?? '';
$errors     = [];
$debug      = [];

// Log received POST data
$debug['received_data'] = $_POST;

// Basic validation
if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
    $errors[] = "All fields are required.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

if (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters long.";
}

// ======================
// CHECK EXISTING EMAIL
// ======================
if (empty($errors)) {
    $check_email = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $check_email);

    if (!$stmt) {
        $errors[] = "Prepare failed: " . mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $errors[] = "Email already exists.";
        }

        $debug['email_query'] = [
            'query' => $check_email,
            'rows_found' => $result ? mysqli_num_rows($result) : 'N/A'
        ];

        mysqli_stmt_close($stmt);
    }
}

// ======================
// INSERT NEW USER
// ======================
if (empty($errors)) {
    $username = explode('@', $email)[0];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO users (first_name, last_name, email, password)
              VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        $errors[] = "Prepare failed for INSERT: " . mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "ssss",
            $first_name, $last_name, $email, $hashed_password);

        if (mysqli_stmt_execute($stmt)) {
            $user_id = mysqli_insert_id($conn);
            $_SESSION['user_id'] = $user_id;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['email'] = $email;
            $_SESSION['logged_in'] = true;

            $debug['insert_status'] = "Success";
            $debug['inserted_user_id'] = $user_id;

            $response = [
                'success' => true,
                'message' => "Registration successful! Welcome, $first_name.",
                'debug' => $debug
            ];

            header('Content-Type: application/json');
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        } else {
            $errors[] = "Execution failed: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
}

// ======================
// RETURN ERRORS
// ======================
if (!empty($errors)) {
    $response = [
        'success' => false,
        'errors' => $errors,
        'debug' => $debug
    ];

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}
?>
