<?php
require_once 'database.php';

// Get image data from the database
$result = $db->query("SELECT image FROM images ORDER BY id DESC");

// Check if images were found
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Display each image using base64 encoding
        echo '<img src="data:image/jpg;base64,' . base64_encode($row['image']) . '" />';
    }
} else {
    echo 'No images found.';
}
?>
