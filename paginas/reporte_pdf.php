<?php 
include('../dompdf/dompdf_config.inc.php');
$html=sprintf("<html><head><title></title><link rel='stylesheet' href='../css/print.css'/>
		</head></body><div class='logo'> 
		<img src='../imagenes/cintillo.png'  width='700' class='cintillo'>
		</div>		
	<div class='titulo'>
		Sistema de Notas Trimestrales PNFI - UPTAG
	</div>%s</body></html>", $_POST["str_html"]);
$dompdf = new DOMPDF();
$dompdf->load_html(utf8_decode($html));
$dompdf->render();
$dompdf->stream("Reporte.pdf"); 


?>
