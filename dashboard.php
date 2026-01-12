<?php
/**
 * Author : Salim Nazir
 * Email : salnazi@gmail.com
 * Powered By : JA Square
 * Module : JA Square Marketplace
 * FILENAME : dashboard.php
 * Path : /business-card/dashboard.php
 * Updated : 2026-01-11 21:05:00 (Asia/Kolkata +5:30)
 * Version : 1.0.0
 * Status : Active
 * Logic : Display saved business cards with Print/Delete capabilities.
 */
include('db_connect.php');

// Handle Deletion Logic
if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $table = $table_prefix . "cards";
    mysqli_query($conn, "DELETE FROM $table WHERE id = '$id'");
    header("Location: dashboard.php");
    exit();
}

// Fetch all saved cards
$table = $table_prefix . "cards";
$result = mysqli_query($conn, "SELECT * FROM $table ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | JA Square Business Cards</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    
    <style>
        :root {
            --md-sys-color-primary: #6750A4;
            --md-sys-color-error: #B3261E;
            --glass-bg: rgba(255, 255, 255, 0.5);
        }

        body, html {
            margin: 0; padding: 0; height: 100vh;
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            overflow: hidden; /* Vertically shallow */
            display: flex; align-items: center; justify-content: center;
        }

        .dashboard-container {
            width: 95vw; height: 85vh;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 32px; /* High-density corners */
            border: 1px solid rgba(255,255,255,0.4);
            box-shadow: 0 15px 45px rgba(0,0,0,0.08);
            display: flex; flex-direction: column; overflow: hidden;
        }

        .header {
            padding: 24px 40px;
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .grid-container {
            flex: 1; padding: 30px 40px;
            overflow-y: auto; /* Internal scrolling only */
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px; align-content: start;
        }

        .card-item {
            background: white; border-radius: 20px;
            padding: 20px; position: relative;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            border: 1px solid #eee; transition: transform 0.2s;
        }

        .card-item:hover { transform: translateY(-5px); }

        .card-info h4 { margin: 0; font-size: 18px; color: #1C1B1F; text-transform: uppercase; }
        .card-info p { margin: 4px 0; font-size: 14px; color: #49454F; }

        .accent-dot {
            width: 12px; height: 12px; border-radius: 50%;
            display: inline-block; margin-right: 8px;
        }

        .actions {
            margin-top: 15px; display: flex; gap: 10px;
        }

        .btn-sm {
            padding: 8px 16px; border-radius: 100px; border: none;
            font-size: 12px; font-weight: 500; cursor: pointer;
            display: flex; align-items: center; gap: 5px; text-decoration: none;
        }

        .btn-print { background: var(--md-sys-color-primary); color: white; }
        .btn-delete { background: #F9DEDC; color: var(--md-sys-color-error); }

        .fab-add {
            position: fixed; bottom: 40px; right: 40px;
            width: 56px; height: 56px; border-radius: 16px;
            background: var(--md-sys-color-primary); color: white;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2); text-decoration: none;
        }

        /* Custom Scrollbar */
        .grid-container::-webkit-scrollbar { width: 6px; }
        .grid-container::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 10px; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="header">
        <div>
            <h2 style="margin:0; color:#1C1B1F;">Design Dashboard</h2>
            <span style="font-size:12px; color:#6750A4;">JA Square Marketplace Module</span>
        </div>
        <a href="index.php" style="text-decoration:none; color:var(--md-sys-color-primary); font-weight:500; display:flex; align-items:center; gap:8px;">
            <i class="material-icons-outlined">add_circle</i> Create New Design
        </a>
    </div>

    <div class="grid-container">
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="card-item">
                    <div class="card-info">
                        <h4><?php echo htmlspecialchars($row['full_name']); ?></h4>
                        <p><?php echo htmlspecialchars($row['job_title']); ?></p>
                        <p style="font-size:12px; opacity:0.7;">
                            <i class="material-icons-outlined" style="font-size:12px; vertical-align:middle;">calendar_today</i> 
                            <?php echo date('d M Y', strtotime($row['created_at'])); ?>
                        </p>
                        <div style="margin-top:10px;">
                            <span class="accent-dot" style="background:<?php echo $row['accent_color']; ?>;"></span>
                            <span style="font-size:12px; color:#49454F;">Brand Color: <?php echo $row['accent_color']; ?></span>
                        </div>
                    </div>
                    
                    <div class="actions">
                        <button class="btn-sm btn-print" onclick="alert('Redirecting to 1:1 Print Mode...')">
                            <i class="material-icons-outlined" style="font-size:16px;">print</i> Print
                        </button>
                        <a href="dashboard.php?delete_id=<?php echo $row['id']; ?>" class="btn-sm btn-delete" onclick="return confirm('Archive this design?')">
                            <i class="material-icons-outlined" style="font-size:16px;">delete</i> Delete
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="grid-column: 1/-1; text-align:center; padding:100px; color:#49454F;">
                <i class="material-icons-outlined" style="font-size:48px; opacity:0.3;">folder_open</i>
                <p>No designs saved yet. Start by creating your first card.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<a href="index.php" class="fab-add">
    <i class="material-icons-outlined">add</i>
</a>

</body>
</html>