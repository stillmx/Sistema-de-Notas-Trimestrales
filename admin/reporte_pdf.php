<?php 
include('../dompdf/dompdf_config.inc.php');
$html=sprintf("<html><head><title></title><link rel='stylesheet' href='../css/print.css'/></head></body><div class='logo'> 
		<img src='../imagenes/cintillo_2015.png'  width='700' class='cintillo'>
		<img src='../imagenes/uptag.jpg' width='150' class='uptag'>		
		<img src='../imagenes/pnfi.jpg' width='150' class='pnfi'><br>		
	</div>		
	<div class='titulo'>
		<h2><b>Sistema de Notas Trimestrales PNFI - UPTAG</b></h2>
	</div>%s</body></html>", $_POST["str_html"]);
$dompdf = new DOMPDF();
$dompdf->load_html(utf8_decode($html));
$dompdf->render();
$dompdf->stream("Reporte.pdf"); 


?>
