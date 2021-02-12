<?php
session_start();
if($_SESSION["level"] == "guest"){

}else{
    header("Location: ../../../login.php");
}
?>