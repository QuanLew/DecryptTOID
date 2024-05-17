<?php 

function handleFile($filename) {
    // Handle file upload request
    $uploadedFile = $_FILES['filename']['tmp_name'];
    
    $username = $_SESSION['username'];

    $fileContent = getFileContent($uploadedFile);
    unlink($uploadedFile);
    //$result = storeData($contentName, $fileContent, $username);
    // if (is_string($result)) {
    //     echo "ERROR: " . $result;
    // } else if (!$result) {
    //     // affected row <= 0
    //     echo "No data was stored";
    // } else {
    //     // data was stored. Redirect to home page to prevent form resubmission.
    //     header("Location: index.php");
    // }
    return $fileContent;
}
function getFileContent($filename)
{
    // Open the file for reading
    $file = fopen($filename, "r");
    if (!$file) die("<div style='color:red;'>Error opening file.</div>");

    $size = filesize($filename);

    if ($size > 0 && $size <= 65535) {
        // Read the contents of the file
        $content = fread($file, $size);

        // Close the file
        fclose($file);

        // Return the file content
        return $content;
    } else if ($size > 65535) {
        // TEXT type in MySQL can only hold up to 65535 bytes only.
        die("<div style='color:red;'>File is too large! No more than 64KB text file is allowed.</div>");
    } else {
        return '';
    }
}

?>