<?php
        include_once ("session.php");
        include_once ("admin.php");
        
        $site = new admin;
        $id = htmlentities(trim($_POST["id"]));
        $info = $site->getLandsForMapById($id);
        echo $info;
        
?>
