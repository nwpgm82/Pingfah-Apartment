<?php
session_start();
if($_SESSION['level'] == 'admin'){
    $sql = "";
}else{
    Header("Location: ../../../login.php");
}