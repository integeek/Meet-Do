<?php
session_start();

if (isset($_SESSION['user'])) {
    echo json_encode([
        'success' => true,
        'user' => $_SESSION['user'],
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No user data found in session.'
    ]);
}
?>