
<?php

    include ("base_datos.php");
    if(isset($_POST["curso1"])){
        $curso=$_POST["curso1"];
        
        $db=new Base_datos("localhost","root","","asistencia","lleva");
        $db->conectar();

        //llamo a esta base para obtener los nombre y apellidos del alumno
        $db_2=new Base_datos("localhost","root","","asistencia","alumnos_1");
        $db_2->conectar();
        //echo ($curso);

        //$alumnos=$db->obtener_alumnos($curso,"lleva");

        $res=$db->codigo_curso($curso,"cursos_unsa");
            //var_dump($res);
        $row=mysqli_fetch_assoc($res);
        $alumnos=$db->obtener_alumnos($row["cursos"],"lleva");

        if(!is_null($alumnos)){
            echo "<input type='hidden' name='curso_1' value=".$curso.">";
            while($row=mysqli_fetch_assoc($alumnos)){
                $alumno=$db_2->datos_alumno($row["cui"]);
                $dato=mysqli_fetch_assoc($alumno);
                echo "<tr>";
                echo "<td>".$dato["cui"]."</td>";
                echo "<td>".$dato["nombres"]."</td>";
                echo "<td>".$dato["apellido"]."</td>";
                echo "<td><input type='radio' name=".$dato["cui"]." value='1'></td>";
                echo "<td><input type='radio' name=".$dato["cui"]." value='2' checked></td>";
                echo "</tr>";
            }
            
        }
        else{
            echo ("no hya nada al parecer ");
        }
        $db_2->cerrar();
        $db->cerrar();

    }
    else if(isset($_POST["curso2"])){
        $curso=$_POST["curso2"];
        $tabla=$_POST["unidad_1"];
        $db=new Base_datos("localhost","root","","asistencia","lleva");
        $db->conectar();

        //llamo a esta base para obtener los nombre y apellidos del alumno
        $db_2=new Base_datos("localhost","root","","asistencia","alumnos_1");
        $db_2->conectar();




        $res=$db->codigo_curso($curso,"cursos_unsa");
        //var_dump($res);
        $row=mysqli_fetch_assoc($res);
        $alumnos=$db->obtener_alumnos($row["cursos"],"lleva");

/*
        $alumnos=$db->obtener_alumnos($curso,"lleva");


*/

        if(!is_null($alumnos)){
            echo "<input type='hidden' name='curso_2' value=".$curso.">";
            echo "<input type='hidden' name='unidades' value=".$tabla.">";
            while($row=mysqli_fetch_assoc($alumnos)){
                $alumno=$db_2->datos_alumno($row["cui"]);
                $dato=mysqli_fetch_assoc($alumno);
                echo "<tr>";
                echo "<td>".$dato["cui"]."</td>";
                echo "<td>".$dato["nombres"]."</td>";
                echo "<td>".$dato["apellido"]."</td>";
                //imprmo botones tipo radio con name del cui para enviarlo a asistencia
                echo "<td><input type='text' name=".$dato["cui"].'ex'." placeholder='Nota examen'></td>";
                echo "<td><input type='text' name=".$dato["cui"].'ct'." placeholder='Nota continua'></td>";

                echo "</tr>";
            }
            
        }
        $db_2->cerrar();
        $db->cerrar();


    }
?>

