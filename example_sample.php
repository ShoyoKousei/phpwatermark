<?php

//load images
$image_source = imagecreatefromjpeg("image_for_test.jpg");
$logo = imagecreatefrompng("logo.png");

//add watermark
$x = (imagesx($image_source) / 2) - (imagesx($logo) / 2);
$y = (imagesy($image_source) / 2) - (imagesy($logo) / 2);

imagecopy(
    $image_source,
    $logo,
    $x,
    $y,
    0,
    0,
    imagesx($logo),
    imagesy($logo)
);
//save watermarked image

imagejpeg($image_source, "watermarked.jpg", 60);
echo "ok";
