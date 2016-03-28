<?php
if (!isset($_GET['admin'])) {
    include("admin/contenido.php");
} else {
    include("admin/".$_GET['admin'].".php");
}
require_once ('tiempo.php');
?>
