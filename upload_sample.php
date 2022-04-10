<?php
if (isset($_POST['submit'])) {

    // echo "test";
    $valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
    $path = 'photos/'; // upload directory
    if ($_FILES['photo']) {
        $img = $_FILES['photo']['name'];
        $tmp = $_FILES['photo']['tmp_name'];
        // get uploaded file's extension
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        // can upload same image using rand function
        $final_image_name = rand(1000, 1000000) . '.' . $ext;
        // check's valid format
        if (in_array($ext, $valid_extensions)) {
            $path = $path . strtolower($final_image_name);
            if (move_uploaded_file($tmp, $path)) {
                /**watermark */
                //load images
                $image_source = imagecreatefromjpeg($path);
                if ($ext == 'png')
                    $image_source = imagecreatefrompng($path);

                $logo = imagecreatefrompng("logo.png");

                //add watermark
                $x = (imagesx($image_source) / 2) - (imagesx($logo) / 2);
                $y = (imagesy($image_source) / 2) - (imagesy($logo) / 2);

                imagecopy(
                    $image_source,
                    $logo,
                    $x,
                    $y, //position:center logo in image
                    0,
                    0,
                    imagesx($logo),
                    imagesy($logo)
                );
                //save watermarked image
                imagejpeg($image_source, $path, 60);
                /** end watermark */
                echo "uploaded and watermarked";
            }
        } else {
            // echo "invalid extension";
            echo "-1";
        }
    } else {
        // echo "Upload error";
        echo "-2";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watermark php</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.4/css/bootstrap.css" integrity="sha512-KsdCRnLXUKDOyOPhhh7EjWSh2Mh/ZI64XwaYQPGyvuQYWBE1FGTCPnUKjLvD+DDQevQdks3US94aYJsIQxTiKg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        Select Image File to Upload:
        <input type="file" name="photo">
        <input type="submit" name="submit" value="Upload">
    </form>

</body>

</html>