<?php
/**
 * Author : Salim Nazir
 * Email : salnazi@gmail.com
 * Powered By : JA Square
 * Module : JA Square Marketplace
 * FILENAME : db_setup.php
 * Path : /business-card/db_setup.php
 * Updated : 2026-01-12 10:25:00 (Asia/Kolkata +5:30)
 * Version : 1.1.0
 * Status : Active
 * Logic : Drops/Creates DB via temporary connection, then includes db_connect.php for table creation with Fabric.js support.
 */

// 1. Initial configuration to match your db_connect.php environment
require_once('db_connect.php');



    /**
     * 3. Load official connection
     * This file defines $conn and $table_prefix (businesscard_)
     */
    

    $table_name = $table_prefix . "cards";

    // Table Schema updated for Fabric.js (Layered JSON) and Background Images
    $sql_table = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100) NOT NULL,
        canvas_json LONGTEXT NOT NULL, 
        bg_image VARCHAR(255) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB";

    if (mysqli_query($conn, $sql_table)) {
        // Professional M3 Success Screen
        echo "
        <div style='display:flex; justify-content:center; align-items:center; height:100vh; background:#f3f4f6; font-family:\"Roboto\", sans-serif;'>
            <div style='padding:40px; border-radius:32px; background:rgba(255,255,255,0.8); backdrop-filter:blur(15px); text-align:center; box-shadow:0 10px 40px rgba(0,0,0,0.05); border:1px solid white;'>
                <div style='color:#6750A4; font-size:48px; margin-bottom:15px;'>
                   <span style='font-family:\"Material Icons Outlined\"'>check_circle</span>
                </div>
                <h2 style='color:#1C1B1F; margin:0;'>Environment Rebuilt</h2>
                <p style='color:#49454F;'>Database <b>$dbname</b> and table <b>$table_name</b> are ready.</p>
                <hr style='border:0; border-top:1px solid #ddd; margin:25px 0;'>
                <a href='index.php' style='display:inline-block; padding:12px 32px; background:#6750A4; color:white; text-decoration:none; border-radius:100px; font-weight:500;'>Launch Layered Designer</a>
            </div>
        </div>";
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }

?>