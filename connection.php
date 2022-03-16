<?php

$con = mysqli_connect('localhost', 'root', 123456, 'crud');


function connection()
{
    if (mysqli_connect_errno()) {
        die("Cannot connect to db" . mysqli_connect_errno());
    }

    define("FETCH_SRC", "http://127.0.0.1:5500/crud/uploads");
}
