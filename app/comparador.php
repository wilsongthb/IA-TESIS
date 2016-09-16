<?php
/*
Script: script para comparar dos archivos *.txt

NOTAS:
    FUNCIONES UTILES
        similar_text : calcula la similitud entre dos strings según se describe en Programming Classics: Implementing the World's Best Algorithms by Oliver (ISBN 0-131-00413-1).
            mas: http://php.net/manual/es/function.similar-text.php
        levenshtein : el número mínimo de caracteres que se tienen que sustituir, insertar o borrar para transformar str1 en str2. La complejidad del algoritmo es O(m*n), donde n y m son la longitud de str1 y str2
            mas: http://php.net/manual/es/function.levenshtein.php
*/
function arr_archivos(#carga una lista de archivos a un array, devuelve el array
    $ruta, #carpeta
    $filtro #tipo de archivos a guardar
){
    $respuesta = [];
    $lista_de_archivos = scandir($ruta);
    foreach($lista_de_archivos as $archivo){
        $t_ruta = $ruta . "/" . $archivo;
        if(!is_dir($t_ruta)){
            if(strrchr($t_ruta,".") == $filtro){
                $respuesta[] = $t_ruta;
            }
        }
    }
    return $respuesta;
}
function str_archivo(
    $ruta #ruta del archivo
){
    $gestor = @fopen($ruta, "r");
    $respuesta = "";
    if ($gestor) {
        while (($búfer = fgets($gestor, 4096)) !== false) {
            $respuesta .= $búfer;
        }
        if (!feof($gestor)) {
            $respuesta .= "Error: fallo inesperado de fgets()\n";
        }
        fclose($gestor);
    }
    return $respuesta;
}
function str_archivo_1(
    $ruta #ruta del archivo
){
    $arr_texto = file($ruta,FILE_IGNORE_NEW_LINES);
    $respuesta = "";
    foreach ($arr_texto as $linea) {
        $respuesta .= $linea;
    }
    return $respuesta;
}
function menor_distancia($str,$arr_str){
    $distancia_mas_corta = -1;
    foreach ($arr_str as $str_1) {
        $nivel = levenshtein($str,$str_1);
        if ($nivel == 0) {#eureka
            $str_2 = $str_1;
            $distancia_mas_corta = 0;
            break;
        }
        if($nivel <= $distancia_mas_corta || $distancia_mas_corta < 0){
            $str_2 = $str_1;
            $distancia_mas_corta = $nivel;
        }
    }
    if($distancia_mas_corta == 0){
        echo "string exacto encontrado";
    }else{
        echo "el mas cercano es el siguiente"; 
    }
}
#porcion de ejecucion
//$archivos = arr_archivos("src",".txt");

/*similar_text(str_archivo($archivos[1]),str_archivo($archivos[2]),$percent);
echo $percent;*/
#echo str_archivo($archivos[1]);
#echo "<pre>" . print_r(explode(" ", str_archivo($archivos[1])),true);
#$texto_1 = file($archivos[0]);
#echo "<meta charset='utf-8'><pre>" . print_r($archivos,true) . print_r($texto_1,true);
/*$gestor = @fopen($archivos[0], "r");
if ($gestor) {
    while (($búfer = fgets($gestor, 4096)) !== false) {
        echo $búfer;
    }
    if (!feof($gestor)) {
        echo "Error: fallo inesperado de fgets()\n";
    }
    fclose($gestor);
}*/