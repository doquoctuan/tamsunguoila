<?php
    $conn = new mysqli('otwsl2e23jrxcqvx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com','u3zuylg51m7x01eu','a6xhckoto8haoj3s','qnymtzcf5hep13df');
    header("Content-type: text/html; charset=utf-8");
    mysqli_set_charset($conn, 'UTF8');
    $conn->query("INSERT INTO `users` (`name`, `mess_id`, `state`) VALUES ('Test nè', '253345654', '0')");
    if(!$conn){
        echo ("Loi");
    } else echo("thanh cong");
?>
