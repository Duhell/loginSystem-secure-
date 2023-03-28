<?php
    require "../control/functions.php";

    if(!isset($_SESSION['user'])){
        header("location: login.php");
        exit();
    }

    if(isset($_GET['logout'])){
        logoutUser();
    }



    $title =  $_SESSION['user'];
    include "./tags/head.php";
?>
<div>
    Hello <?=  $_SESSION['user']?>
    <a href="?logout">logout</a>
</div>
<?php include "./tags/footer.php"; ?>