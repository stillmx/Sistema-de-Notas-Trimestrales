<?php
if (!isset($_GET['pagina'])) {
    include("paginas/contenido.php");
} else {
    include("paginas/".$_GET['pagina'].".php");
}
require_once ('tiempo.php');
?>
