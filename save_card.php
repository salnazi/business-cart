<?php
/**
 * Author : Salim Nazir
 * Email : salnazi@gmail.com
 * Powered By : JA Square
 * Module : JA Square Marketplace
 * FILENAME : save_card.php
 * Path : /business-card/save_card.php
 * Updated : 2025-12-30 00:20:00 (Asia/Kolkata +5:30)
 * Version : 1.0.0
 * Status : Active
 * Logic : Background AJAX handler to persist card data into the businesscard_cards table.
 */

// Include the centralized connection with environment detection
include('db_connect.php');

// Initialize response array
$response = ['status' => 'error', 'message' => 'Invalid Request'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Sanitize and capture the M3 form inputs
    $full_name    = mysqli_real_escape_with_strip($conn, $_POST['full_name']);
    $job_title    = mysqli_real_escape_with_strip($conn, $_POST['job_title']);
    $email        = mysqli_real_escape_with_strip($conn, $_POST['email']);
    $phone        = mysqli_real_escape_with_strip($conn, $_POST['phone']);
    $accent_color = mysqli_real_escape_with_strip($conn, $_POST['accent_color']);

    // Construct the table name using the prefix from db_connect
    $table_name = $table_prefix . "cards";
    
    // Insert into the dynamic table
    $query = "INSERT INTO $table_name (full_name, job_title, email, phone, accent_color) 
              VALUES ('$full_name', '$job_title', '$email', '$phone', '$accent_color')";

    if (mysqli_query($conn, $query)) {
        $response['status'] = 'success';
        $response['message'] = 'Card saved successfully';
    } else {
        $response['message'] = 'Database Error: ' . mysqli_error($conn);
    }
}

// Return JSON for the frontend AJAX fetch
header('Content-Type: application/json');
echo json_encode($response);

/**
 * Utility function to clean input
 */
function mysqli_real_escape_with_strip($conn, $data) {
    return mysqli_real_escape_string($conn, strip_tags(trim($data)));
}
?>