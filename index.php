<?php
$error = "";

if (isset($_POST['submit'])) {
    if (!empty($_FILES['photo']['tmp_name'])) {
        // print_r($_FILES);

        $file_name = $_FILES['photo']['name'];
        $file_type = $_FILES['photo']['type'];
        $file_type = explode("/", $file_type)[1];
        $tmp_name = $_FILES['photo']['tmp_name']; // temporary location
        $file_size = $_FILES['photo']['size']; // in bytes

        // Check file type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($file_type, $allowed_types)) {
            // Check file size
            if ($file_size <= 1000000) { // 1MB
                $file_name = explode(".", $file_name)[0];
                $file_name = str_replace(" ", "-", $file_name);
                $file_name = time() . $file_name . "." . $file_type;

                $file_path = "uploads/" . $file_name;

                // echo $file_name;
                move_uploaded_file($tmp_name, $file_path);
                echo "Photo Uploaded!";
            } else {
                $error = "File too large. Photo should be less than or equal to 1MB";
            }
        } else {
            $error = "Unsupported file format. Only jpg, jpeg, png, and gif is accepted";
        }
    } else {
        echo "No photo selected";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>File Upload</h1>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="photo">Photo</label>
            <input type="file" name="photo" id="photo">
            <p class="error"><?= $error ?></p>
        </div>
        <button type="submit" name="submit">Upload</button>
    </form>
</body>

</html>