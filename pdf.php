<?php
include("base_datos.php");
ob_start();
?>
<html lang="en">
<body>
    <?php
    $curso=$_GET["curso_pdf"];
    echo "<h1>Registro del curso ".$curso."</h1>";
    //$curso=$_POST["curso_pdf"];
    
    $db=new Base_datos("localhost","root","","asistencia","alumnos_1");
    $db->conectar();
    $alumnos=$db->obtener_alumnos($curso,"lleva");
    $array_unidad=["unidades","unidades2","unidades3"];
    $por_exa=[0.1,0.1,0.3];
    $por_cont=[0.1,0.1,0.3];


    while($row=mysqli_fetch_assoc($alumnos)){
        $cui=$row["cui"];
        $alumno_eva=$db->datos_alumno($cui);
        $emun=mysqli_fetch_assoc($alumno_eva);
        $examen_final=0;
        $continua_final=0;
        echo "<article><h3>NOTAS DE CURSO</h3><h2>Alumno :".$emun["nombres"]." ".$emun["apellido"]."</h2><table class='table1'>";
        echo "<thead ><tr><td>Unidad</td><td>Nota continua</td><td>Nota parcial</td><td>Nota final</td></tr></thead><tbody >";
        for($i=0;$i<3;$i++){
            $notas=$db->notas_alumno($curso,$array_unidad[$i],$cui);
            $desglose=mysqli_fetch_assoc($notas);
            $aux_exa=$desglose["examen"]*$por_exa[$i];
            $aux_cont=$desglose["continua"]*$por_cont[$i];

            $examen_final+=$aux_exa;
            $continua_final+=$aux_cont;

            $nota_final_u=$aux_exa+$aux_cont;
            echo "<tr><td>Unidad".($i+1)."</td><td>".$desglose["examen"]."</td><td>".$desglose["continua"]."</td><td>".$nota_final_u."</td></tr>";
            //echo "<tr><td>Unidad 1</td><td>X</td><td>Y</td><td>Z</td></tr>";
        }
        $nota_final_f=$examen_final+$continua_final;
        if($nota_final_f>=10.5){
            echo "</tbody></table><table><tr><span>Estado del curso : </span><span>Aprobado</span></tr></table>";
        }
        else{
            echo "</tbody></table><table><tr><span>Estado del curso : </span><span>Desaprovado</span></tr></table>";
        }

        echo "<h4>ASISTENCIA DEL ESTUDIANTE</h4><table class ='table2'><thead><tr><td>Asistencia del estudiante</td><td>Cantidad</td><td>Porcentaje</td></tr></thead><tbody>";
        $total=$row["presente"]+$row["falto"];
        
        echo "<tr><td>Presente</td><td>".$row["presente"]."</td><td>".round(($row["presente"]/$total)*100)."%</td></tr>";
        //echo "<tr><td>Presente</td><td>4</td><td>23</td></tr>";
        echo "<tr><td>Presente</td><td>".$row["falto"]."</td><td>".round(($row["falto"]/$total)*100)."%</td></tr></tbody></table><br><br></article>";
        //echo "<tr><td>FALTO</td><td>4</td><td>23</td></tr>";
    }


    ?>
<?php
$html=ob_get_clean(); 
//echo $html;

//require_once "./dompdf/autoload.inc.php";
require_once "./libreria/dompdf/autoload.inc.php";
use Dompdf\Dompdf;
$dompdf=new Dompdf();

$options=$dompdf->getOptions();
$options->set(array('isRemoteEnabled'=>true));
$dompdf->setOptions($options);

//$dompdf->loadHtml("Hola mundo");
$dompdf->loadHtml($html);

$dompdf->setPaper('letter');

$dompdf->render();
$dompdf->stream("archivo_.pdf",array("Attachment"=>false));

?>
