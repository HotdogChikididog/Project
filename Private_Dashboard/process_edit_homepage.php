<?php
require_once("include/connection.php");
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file uploads
    $logo = $_FILES["logo"]["name"];
    if (move_uploaded_file($_FILES["logo"]["tmp_name"], "uploads/" . $logo)) {
        // File uploaded successfully, continue processing

        // Retrieve other values from the form
        $form_data = [
            'company_name' => $_POST['company_name'],
            'mission_text' => $_POST['mission_text'],
            'vision_text' => $_POST['vision_text'],
        ];

        // traditonal way of separating strings based on space and replace space with _
        // $slug = implode('_',explode(" ",$companyName));


        // $slug = str_replace(" ", "_", $companyName);


        $conn->begin_transaction();

        try{
            foreach($form_data as $key => $row)
            {
                $row['slug'] = str_replace(" ", "_", $key);

                if(!empty($get_metadata($row['slug'])))  {
                    $statement = $conn->prepare("UPDATE `meta_data` SET `value` = ?, `updated` = ? WHERE `slug` = ?");
                    $statement->bind_param("sss", $row['value'], date('now'), $row['slug']);
                    $statement->execute();
                } else {
                    $statement = $conn->prepare("INSERT INTO `meta_data` (`value`, `name`, `slug`) VALUES (?, ?, ?)");
                    $statement->bind_param("sss", $row['value'], $row['name'], $row['slug']);
                    $statement->execute();
                }
            }

            if($conn->commit()){
                echo '
                <script type = "text/javascript">
                    alert("File Upload");
                    window.location = "edit_homepage.php";
                </script>';
            }
        } catch(mysqli_sql_exception $e) {
            $conn->rollback();

            throw $e;
        }

        // --- START ---
        // Read the existing index.html file
        // $indexContent = file_get_contents("index.html");
        
        // Replace placeholders with submitted values
        // $indexContent = str_replace("{logo}", $logo, $indexContent);
        // $indexContent = str_replace("{company_name}", $companyName, $indexContent);
        // $indexContent = str_replace("{mission_vision}", $missionVision, $indexContent);

        // Write the updated content back to index.html
        // file_put_contents("index.html", $indexContent);

        // --- END ---
        
        // if($id)
        // {
        //     $statement = "UPDATE `meta_data` SET `logo` = '$logo', `company_name` = '$companyName', `mission_text` = '$mission_text', `vision_text` = '$vision_text', `slug` = '$slug' WHERE `id` = '$id'";
        // }
        // else
        // {
        //     $statement = "INSERT INTO `meta_data` (`logo`, `company_name`, `mission_text`, `vision_text`, `slug`) VALUES ('$logo', '$companyName', '$mission_text', '$vision_text', '$slug')";
        // }

        exit();
    } else {
        // Handle file upload error
        echo "File upload failed.";
    }
} else {
    // Redirect the user to the edit homepage page if the form is not submitted
    header("Location: edit_homepage.php");
    exit();
}
?>
