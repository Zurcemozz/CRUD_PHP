<?php

require('connection.php');



function image_upload($img)
{
    $tmp_loc = $img['tmp_name'];
    $new_name = random_int(11111, 99999) . $img['name'];
    $new_loc = './uploads/' . $new_name;
    if (!move_uploaded_file($tmp_loc, $new_loc)) {
        header("location: index.php?alert=img_upload");
        exit;
    } else {
        return $new_name;
    }
}

function imageRemove($img)
{
    if (!unlink('./uploads/' . $img)) {
        header("location: index.php?alert=img_rem_fail");
    } else {
        echo "Not Delted";
    }
}


if (isset($_POST['addproduct'])) {

    $name = $_POST["name"];
    $price = $_POST["price"];
    $desc = $_POST["desc"];

    $imgpath = image_upload($_FILES['image']);

    $query = "INSERT INTO `products`(`name`, `price`, `desc`, `image`) VALUES('$name','$price','$desc','$imgpath')";

    if (mysqli_query($con, $query)) {
        header("location: index.php?success=added");
    } else {
        header("location: index.php?=alert=add_failed");
    }
}


if (isset($_GET['rem']) && $_GET['rem'] > 0) {

    $query = "SELECT * FROM products WHERE `id`='$_GET[rem]' ";
    $result = mysqli_query($con, $query);
    $fetch = mysqli_fetch_assoc($result);

    imageRemove($fetch['image']);

    $query = "DELETE  from `products` where `id`='$_GET[rem]'";

    if (mysqli_query($con, $query)) {
        header("location: index.php?success=removed");
    } else {
        header("location: index.php?=alert=add_failed");
    }
}


if (isset($_POST['editproduct'])) {


    $name = $_POST["name"];
    $price = $_POST["price"];
    $desc = $_POST["desc"];

    if (file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {
        $query = "SELECT * FROM products WHERE `id`='$_GET[editid]' ";
        $result = mysqli_query($con, $query);
        $fetch = mysqli_fetch_assoc($result);

        imageRemove($fetch['image']);
        $imgpath = image_upload($_FILES['image']);

        $update = "UPDATE  `products` SET `name`='$name', `price`='$price', `desc`='$desc', `image`='$imgpath' WHERE `id`=$_POST[editid] ";
    } else {
        $update = "UPDATE  `products` SET `name`='$name', `price`='$price', `desc`='$desc' WHERE `id`=$_POST[editid] ";
    }

    if (mysqli_query($con, $update)) {
        header("location: index.php?success=updated");
    } else {
        header("location: index.php?alert=update_failed");
    }
}
