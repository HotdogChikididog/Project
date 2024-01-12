<?php
require_once("include/connection.php");

if (isset($_GET['file_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['file_id']);

    // fetch file to download from the database
    $sql = "SELECT * FROM upload_files WHERE ID=$id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $file = mysqli_fetch_assoc($result);

        if ($file) {
            $filepath = '../uploads/' . $file['FILE_PATH'];
            $filename = $file['NAME'];
            if (file_exists($filepath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . ($filename));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filepath));
                readfile($filepath);

                // Now update downloads count
                $newCount = $file['DOWNLOAD'] + 1;
                $updateQuery = "UPDATE upload_files SET DOWNLOAD=$newCount WHERE ID=$id";
                mysqli_query($conn, $updateQuery);
                exit;
            } else {
                echo "Error: File not found at path: $filepath";
            }
        } else {
            echo "Error: File not found in the database for ID: $id";
        }
    } else {
        echo "Error: Database query failed.";
        // Add more details about the error if needed
        error_log(mysqli_error($conn));
    }
} else {
    echo "Error: File ID not provided.";
}
?>
