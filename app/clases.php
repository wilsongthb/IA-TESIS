<?php
/**
 * crear archivos TXT a partir de archivos PDF de una carpeta
 * los archivos TXT se guardan en la misma carpeta en donde
 * estan los PDF
 */
class ArchivosPDFtoTXT
{
    public $lista = [];
    protected $clave = '0';
    function __construct($ruta='files', $filtro='.pdf')
    {
        $lista_de_archivos = scandir($ruta);
        foreach($lista_de_archivos as $archivo){
            $t_ruta = $ruta . '/' . $archivo;
            if(!is_dir($t_ruta)){
                if(strrchr($t_ruta,'.') == $filtro){
                    $this->lista[] = $t_ruta;
                }
            }
        }
    }
    public function convertir($id = '-1')
    {
        if($id == '-1'){
            //echo $this->clave.PHP_EOL;
            system('pdftotext "'.$this->lista[$this->clave].'"');
            $this->clave++;
        }else{
            //echo $id.PHP_EOL;
            $sentencias = 'pdftotext "'.$this->lista[$id].'"';
            //echo $sentencias.PHP_EOL;
            system($sentencias);
        }
    }
    public function convertAll()
    {
        $this->clave = '0';
        foreach ($this->lista as $ruta) {
            $this->convertir();
        }
    }
}
