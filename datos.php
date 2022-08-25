<?php
    include("base_datos.php");

    $db=new Base_datos("localhost","root","","asistencia","alumnos_1");
    $db->conectar();






    if(isset($_POST["accion"])&&$_POST["accion"]=="matricula"){
        $var=$db->Obtener_permiso("Matricula","permisos");
        $boll=mysqli_fetch_assoc($var);
        $valor=$boll["Matricula"];
        
        if($valor=='1'){
            $cui=$_POST["cui"];
            $res=$db->datos_alumno($cui);
            $datos=mysqli_fetch_assoc($res);
            $semestre=$datos["Semestre"];

            $res_c=$db->cursos_unsa("cursos_unsa",$semestre);
            /*
            $row=mysqli_fetch_assoc($res_c);
            $str=$row["cursos"];
            $cursos=explode(",",$str);
            */
            //$html1='<form action="datos.php?accion1='.$semestre.'&cui='.$cui.'" method="get"><table><thead><th>Cursos</th><th>Opcion</th></thead><tbody>';
            
            $html1='<form action="datos.php" method="post"><input type="hidden" name="cui" value="'.$cui.'"><input type="hidden" name="accion1" value="'.$semestre.'"><table><thead><th>Cursos</th><th>Opcion</th></thead><tbody>';
            //$html1='<form action="datos.php" method="GET"><input type="hidden" name="cui" value="'.$cui.'"><input type="hidden" name="accion1" value="'.$semestre.'"><table><thead><th>Cursos</th><th>Opcion</th></thead><tbody>';

            $html2='</tbody></table><button type="submit">Matricularse</button></form>';
            echo ($html1);
//-------------------------------------------------------------------------------------------------
            while($row=mysqli_fetch_assoc($res_c)){
                if($row["requisito"]=="NN"){
                    echo ("<tr><td>".$row["cursos"]."</td><td><input type='checkbox' name='".$row["codigo"]."'></td></tr>");
                }
            }
/*
            for($i=0;$i<count($cursos);$i++){
                //echo ('<tr><td>'.$cursos[$i]'.</td><td><input type="checkbox" name="'.$cursos[$i].'" id=""></td></tr>');
                echo ("<tr><td>".$cursos[$i]."</td><td><input type='checkbox' name='".$cursos[$i]."'></td></tr>");

                //echo($cursos[$i]."<br>");
            }
*/
//-------------------------------------------------------------------------------


            echo ($html2);
            $db->cerrar();
        }
        else{
            echo ("<h2>La matriculas no estan habilitadas</h2>");
        }
    }
/*
//-----------------------resapaldo primer api--------------------------------
    if(isset($_POST["accion"])&&$_POST["accion"]=="matricula"){
        $var=$db->Obtener_permiso("Matricula","permisos");
        $boll=mysqli_fetch_assoc($var);
        $valor=$boll["Matricula"];
        
        if($valor=='1'){
            $cui=$_POST["cui"];
            $res=$db->datos_alumno($cui);
            $datos=mysqli_fetch_assoc($res);
            $semestre=$datos["Semestre"];

            $res_c=$db->cursos_unsa("cursos_unsa",$semestre);
            $row=mysqli_fetch_assoc($res_c);
            $str=$row["cursos"];
            $cursos=explode(",",$str);
            //$html1='<form action="datos.php?accion1='.$semestre.'&cui='.$cui.'" method="get"><table><thead><th>Cursos</th><th>Opcion</th></thead><tbody>';
            $html1='<form action="datos.php" method="post"><input type="hidden" name="cui" value="'.$cui.'"><input type="hidden" name="accion1" value="'.$semestre.'"><table><thead><th>Cursos</th><th>Opcion</th></thead><tbody>';
            //$html1='<form action="datos.php" method="GET"><input type="hidden" name="cui" value="'.$cui.'"><input type="hidden" name="accion1" value="'.$semestre.'"><table><thead><th>Cursos</th><th>Opcion</th></thead><tbody>';

            $html2='</tbody></table><button type="submit">Matricularse</button></form>';
            echo ($html1);
            for($i=0;$i<count($cursos);$i++){
                //echo ('<tr><td>'.$cursos[$i]'.</td><td><input type="checkbox" name="'.$cursos[$i].'" id=""></td></tr>');
                echo ("<tr><td>".$cursos[$i]."</td><td><input type='checkbox' name='".$cursos[$i]."'></td></tr>");

                //echo($cursos[$i]."<br>");
            }
            echo ($html2);
            $db->cerrar();
        }
        else{
            echo ("<h2>La matriculas no estan habilitadas</h2>");
        }
    }
//----------------------------------------termina el respaldo-----------------------------------






    if(isset($_POST["accion1"])){
        $sem=$_POST["accion1"];
        $cui=$_POST["cui"];
        $res_c=$db->cursos_unsa("cursos_unsa",$sem);
        $row=mysqli_fetch_assoc($res_c);
        $str=$row["cursos"];
        $cursos=explode(",",$str);
        for($i=0;$i<count($cursos);$i++){
            $aux=$cursos[$i];
            if(isset($_POST["$cursos[$i]"])&&$_POST["$cursos[$i]"]=="on"){
                $estado=$db->matricular("lleva",$cursos[$i],$cui);
                if($estado){
                    echo ("Usted ya esta matriculado en el el curso de ".$cursos[$i]);
                }
                else{
                    echo ("Se matriculo exitosamente en ".$cursos[$i]);
                }
            }
        }
        $db->cerrar();
    }
*/
    else if(isset($_POST["post_sub_nota_final"])){
        $curso11=$_POST["post_sub_nota_final"];
        $tabla="estado_cursos";



        

        $res=$db->codigo_curso($curso11,"cursos_unsa");
        //var_dump($res);
        $row11=mysqli_fetch_assoc($res);

        $curso=$row11["cursos"];

        $notas=$db->obtener_alumnos($curso,"nota_final_curso");
        while($row=mysqli_fetch_assoc($notas)){
            $cui=$row["cui"];
            $nota=$row["final"];
            $codigo_curso=$row["codigo"];

            $sem=$db->datos_alumno($cui);
            $row2=mysqli_fetch_assoc($sem);
            $semestre=$row2["Semestre"];
            if($nota>=10.5){
                $db->subir_registro($tabla,$cui,$codigo_curso,$curso,$nota,"Aprovado",$semestre);
            }
            else{
                $db->subir_registro($tabla,$cui,$codigo_curso,$curso,$nota,"Desaprovado",$semestre);
            }

        }
        
        $db->cerrar();
    }














/*
    echo ("hola mundo"."<br>");
    $cui=20213123;

    $res_c=$db->cursos_unsa("cursos_unsa",4);
    
    while($row=mysqli_fetch_assoc($res_c)){
        if($row["requisito"]!="NN"){
            $pre_requisito=$row["requisito"];
            $estado=$db->estado_curso($cui,$pre_requisito);
            //var_dump($estado);
            
            if($estado=="APROVADO"){
                echo ($row["cursos"]."<br>");
            }
            else if($estado==null){
                echo ("no hay datos registrados sobre el curso"."<br>");
            }
            else{
                echo ($row["cursos"]."  NO fue aprovado "."<br>");
            }
        }
        else{
            echo ($row["cursos"]."<br>");
        }
    }
*/
//.............................................................................
    else if(isset($_POST["accion1"])){
        $sem=$_POST["accion1"];
        $cui=$_POST["cui"];
        $res_c=$db->cursos_unsa("cursos_unsa",$sem);

        while($row=mysqli_fetch_assoc($res_c)){
            $codigo=$row["codigo"];
            $curso=$row["cursos"];
            if(isset($_POST["$codigo"])&&$_POST[$codigo]=="on"){
                if($row["requisito"]!="NN"){
                    $pre_requisito=$row["requisito"];
                    $estado_i=$db->estado_curso($cui,$pre_requisito);
                    $row12=mysqli_fetch_assoc($estado_i);
                    $estado=$row12["condicion"];
                    echo ("este es el estado del curso : ".$estado);
                    //var_dump($estado);
                    
                    if($estado=="Aprovado"){
                        //$db->matricular("lleva",$curso,$cui,$codigo);
                        //echo ($row["cursos"]."<br>");
                    }
                    else if($estado==""){
                        //echo ($row["cursos"]."no hay datos registrados sobre el curso"."<br>");
                    }
                    else{
                        //echo ($row["cursos"]."  NO fue aprovado "."<br>");
                    }
                }

            
                else{
                    $db->matricular("lleva",$curso,$cui,$codigo);
                    //echo ($row["cursos"]."<br>");
                }
            }
        }
/*
        $row=mysqli_fetch_assoc($res_c);
        $str=$row["cursos"];
        $cursos=explode(",",$str);
        for($i=0;$i<count($cursos);$i++){
            $aux=$cursos[$i];
            if(isset($_POST["$cursos[$i]"])&&$_POST["$cursos[$i]"]=="on"){
                $estado=$db->matricular("lleva",$cursos[$i],$cui);
                if($estado){
                    echo ("Usted ya esta matriculado en el el curso de ".$cursos[$i]);
                }
                else{
                    echo ("Se matriculo exitosamente en ".$cursos[$i]);
                }
            }
        }
*/
        $db->cerrar();
    }





?>