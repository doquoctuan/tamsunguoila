<?php
  //  include "config.php";
    header("Content-type: text/html; charset=utf-8");
    mysqli_set_charset($conn, 'UTF8');
    $conn->query("INSERT INTO `users` (`name`, `mess_id`, `state`) VALUES ('T3s', '2589632', '0')");
    if(!$conn){
        echo ("Loi");
    } else echo("thanh cong");
?>
