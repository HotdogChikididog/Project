<?php
require_once("include/connection.php");

if (isset($_GET['file_id'])) {
    $fileId = $_GET['file_id'];

    // Add logic to update the file status to 'Approved'
    $updateStatusQuery = "UPDATE upload_files SET STATUS = 'Approved' WHERE ID = $fileId";
    $updateStatusResult = mysqli_query($conn, $updateStatusQuery);

    if ($updateStatusResult) {
        // Redirect to the pending_uploads.php page after approval
        header("Location: pending_uploads.php");
        exit;
    } else {
        // Handle error: Unable to update status
    }
} else {
    // Handle error: File ID not provided
}
?>
