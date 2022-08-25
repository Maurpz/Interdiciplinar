<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php       
    include("base_datos.php");
    if(isset($_POST["curso_2"])){
        $curso=$_POST["curso_2"];

        $db2=new Base_datos("localhost","root","","asistencia","lleva");
        $db2->conectar();

        $alumnos=$db2->obtener_alumnos($curso);
        if(!is_null($alumnos)){
            while($row=mysqli_fetch_assoc($alumnos)){
                $cui=$row["cui"];
                //aqui optengo el cui enviado del form de home del profesor
                $op=$_POST["$cui"];
                if($op==1){
                    $campo='presente';
                    $alumno=$db2->datos_alumno($row["cui"]);
                    $dato=mysqli_fetch_assoc($alumno);
                    //aqui estoy preguntando por la cantidad de asistencia que tiene para sumarle 1 mas
                    $valor=$dato["$campo"];
                    $valor+=1;
                    $db2->actualizar_asistencia($campo,$valor,$row["cui"],$curso);
                }
                else if($op==2){
                    $campo='falto';
                    $alumno=$db2->datos_alumno($row["cui"]);
                    $dato=mysqli_fetch_assoc($alumno);
                    //aqui estoy preguntando por la cantidad de faltas que tiene para sumarle 1 mas
                    $valor=$dato["$campo"];
                    $valor+=1;
                    $db2->actualizar_asistencia($campo,$valor,$row["cui"],$curso);
                }
                else{
                    echo "No entro a ninguna opcion";
                }
            }

            $db2->cerrar();
                    
        }
    }
    header("location:home_profesor.php");       
    ?>
    
</body>
</html>
