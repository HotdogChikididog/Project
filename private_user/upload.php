<?php
session_start();
if (!isset($_SESSION["email_address"])) {
    header("location:../login.html");
    exit();
}

require_once("include/connection.php");

$id = mysqli_real_escape_string($conn, $_SESSION['email_address']);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $uploadsDir = "../uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    // get the file extension
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    $filepath = uniqid() . '.' . $extension;

    // Create the target directory if it doesn't exist
    if (!file_exists($uploadsDir) && !is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0755, true);
    }
    // Dec-30-2023 06:26 PM

    $destination = $uploadsDir . $filepath;
    exec("chmod 755 $uploadsDir");
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $destination)) {
        // File was successfully uploaded
       
        $fileSize = $_FILES["file"]["size"];
        $uploader = $id;

        $sql = $conn->prepare("INSERT INTO upload_files (name, size, download, timers, admin_status, uploader_id, email, file_path) VALUES (?, ?, ?, ?, ?,?, ?, ?)");

        $download = "0";
        $admin_status = "Pending";
        $time = date('M-d-Y h:i A');
        $uploaderId = $_SESSION['user_no'];
        // s = string, i = integer
        $sql->bind_param("sssssiss", $fileName, $fileSize, $download, $time, $admin_status, $uploaderId,$uploader, $filepath);

        $sql->execute();
        // Add code to insert file details into the database
        // $query = "INSERT INTO upload_files (NAME, SIZE, EMAIL, ADMIN_STATUS, TIMERS, DOWNLOAD, FILE_PATH) VALUES ('$fileName', $fileSize, '$uploader', 'Pending', NOW(), 0, '$filePath')";

        // mysqli_query($conn, $query) or die(mysqli_error($conn));

        // Output a success message and trigger a JavaScript alert
        echo '<script>alert("File uploaded successfully."); window.location.href = "home.php";</script>';
    } else {
        // Error uploading file
        echo "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your existing head content here -->
</head>
<body>
    <!-- Add your existing body content here -->
    <!-- This body section will contain your HTML content -->

    <!-- You can add additional content here as needed -->

    <!-- Your existing JavaScript code and other content goes here -->

    <!-- The script tag for the DataTables library -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
    <!-- Additional script tags and content as needed -->

    <!-- This is the script to close the loader -->
    <script type="text/javascript" charset="utf-8">
        $(window).on('load', function(){
            setTimeout(function(){
                $('#loader').fadeOut('slow');
            });
        });
    </script>
</body>
</html>
