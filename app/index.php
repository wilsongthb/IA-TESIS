<?php
echo "<pre>";

require("clases.php");
$archivos = new ArchivosPDFtoTXT();
print_r($archivos->lista);
$archivos->convertAll();