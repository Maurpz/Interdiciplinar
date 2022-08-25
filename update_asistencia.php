    <?php       
    include("base_datos.php");
    if(isset($_POST["curso_1"])){
        $db2=new Base_datos("localhost","root","","asistencia","lleva");
        $db2->conectar();
        $curso=$_POST["curso_1"];
        $res=$db2->codigo_curso($curso,"cursos_unsa");
            //var_dump($res);
        $row11=mysqli_fetch_assoc($res);



        $alumnos=$db2->obtener_alumnos($row11["cursos"],"lleva");
        if(!is_null($alumnos)){
            $pres=0;
            $falt=0;
            while($row=mysqli_fetch_assoc($alumnos)){
                $cui=$row["cui"];
                //aqui obtengo el cui enviado del form de home del profesor
                $op=$_POST["$cui"];

                if($op==1){
                    $pres++;
                    $campo='presente';
                    $alumno=$db2->datos_alumno_asis($row["cui"],$row11["cursos"]);
                    $dato=mysqli_fetch_assoc($alumno);
                    //aqui estoy preguntando por la cantidad de asistencia que tiene para sumarle 1 mas
                    $valor=$dato["$campo"];
                    $valor+=1;
                    $db2->actualizar_asistencia($campo,$valor,$row["cui"],$row11["cursos"]);
                }
                else if($op==2){
                    $falt++;
                    $campo='falto';
                    $alumno=$db2->datos_alumno_asis($row["cui"],$row11["cursos"]);
                    $dato=mysqli_fetch_assoc($alumno);
                    //aqui estoy preguntando por la cantidad de faltas que tiene para sumarle 1 mas
                    $valor=$dato["$campo"];
                    $valor+=1;
                    $db2->actualizar_asistencia($campo,$valor,$row["cui"],$row11["cursos"]);
                }
                else{
                    echo "No entro a ninguna opcion";
                }

            }
            
            $db2->asis_day($pres,$falt,$curso,"cursos");

            $db2->cerrar();
                    
    
    }
    //Aqui el profesor llena tanto las asistencias del alumno y como sus notas 
    }
    else if(isset($_POST["curso_2"])){  //Determinamos si una variable está definida y no es null
        $curso=$_POST["curso_2"];
        $tabla=$_POST["unidades"];  

        $db2=new Base_datos("localhost","root","","asistencia","lleva");
        $db2->conectar();

        $res=$db2->codigo_curso($curso,"cursos_unsa");
            //var_dump($res);
        $row11=mysqli_fetch_assoc($res);



        $alumnos=$db2->obtener_alumnos($row11["cursos"],"lleva");
        if(!is_null($alumnos)){
            while($row=mysqli_fetch_assoc($alumnos)){
                $cui=$row["cui"];
                $examen=$_POST["$cui"."ex"];
                $continua=$_POST["$cui"."ct"]; 
                $db2->llenar_notas($examen,$continua,$cui,$row11["cursos"],$tabla,$curso);    
        }
        $db2->cerrar();
        }
    }


    //Aqui se muestra la estadistica de asistencia diaria     

    else if(isset($_POST["day"])){
        $db0=new Base_datos("localhost","root","","asistencia","lleva");
        $db0->conectar();

        //podemos pasar por post ajax el curso que seleciono en un principio la profesora
        //con un id general del la opcion y mandarlo cada vez que se necesite
        //$curso_day="interdiciplinar";
        $curso_day=$_POST["day"];

        $datos_day=$db0->num_day($curso_day,"cursos");
        $row=mysqli_fetch_assoc($datos_day);
        $a=$row["pre"];
        $f=$row["fal"];
        $r="var cont_asi_day=document.getElementById('grap_day');
        var mychar=new Chart(cont_asi_day,{
                type:'doughnut',
                data:{
                    labels: [
                            'Asistentes',
                            'Faltantes'],
                datasets: [{
                label: 'My First Dataset',
                data: [".$a.",".$f."],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)'],
                    hoverOffset: 4}]
                }
                });
        ";
        echo $r;
        $db0->cerrar();
        
        
    }
    //Aqui obtenemos el total de clases dictadas por el profesor
    else if(isset($_POST["cla_t"])){
        $db=new Base_datos("localhost","root","","asistencia","lleva");
        $db->conectar();
        $curso_sem_cla=$_POST["cla_t"];



        $datos_sem=$db->asis_alumnos($curso_sem_cla);
        $row=mysqli_fetch_assoc($datos_sem);
        $p=$row["presente"];
        $f=$row["falto"];
        $sum=$p+$f;

        echo "<h2>Hasta la fecha se ha dictado ".$sum." clases </h2>";
        $db->cerrar();

    }

    else if(isset($_POST["porcent_asis_alum"])){
    //Aqui obtenemos el gráfico del porcentaje de asistencia de los alumnos        
        $curso=$_POST["porcent_asis_alum"];


        $db=new Base_datos("localhost","root","","asistencia","lleva");
        $db->conectar();

        //llamo a esta base para obtener los nombre y apellidos del alumno
        $db_2=new Base_datos("localhost","root","","asistencia","alumnos_1");
        $db_2->conectar();


        $pri="var cont_asi_por=document.getElementById('por_asis_alum');
        var mychar=new Chart(cont_asi_por,{
                type:'bar',
                data:{
                    labels: [";

                        
        $seg="],datasets: [{
                label: 'My First Dataset',
                data: [";

        $ter="],backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)'],
                    hoverOffset: 4}]
                }
                });
        ";

        $alumnos=$db->obtener_alumnos($curso,"lleva");
        if(!is_null($alumnos)){
            while($row=mysqli_fetch_assoc($alumnos)){
                $alumno=$db_2->datos_alumno($row["cui"]);
                $dato=mysqli_fetch_assoc($alumno);
                $pri.="'".$dato["nombres"]."',";
                $asis_p=$row["presente"];
                $asis_f=$row["falto"];
                $asis_final=($asis_p*100)/($asis_p+$asis_f);
                $seg.=$asis_final.",";
            }
            
        }
        $concatenado=$pri.$seg.$ter;
        echo $concatenado;
        $db_2->cerrar();
        $db->cerrar();
    }

    else if(isset($_POST["post_alum_abandono"])){
    //Aqui determinamos los alumnos con estado de abandono de curso        
    $curso=$_POST["post_alum_abandono"];

        $db=new Base_datos("localhost","root","","asistencia","alumnos_1");
        $db->conectar();
        $alum_abandono=$db->abandono_alum($curso,"lleva");
        if(!is_null($alum_abandono)){
            echo "<spam>Para determinar el abandono del curso ha debido de faltar a 10 clases, los estudiantes en abandono son :</spam><br>";
            while($row=mysqli_fetch_assoc($alum_abandono)){
                $datos=$db->datos_alumno($row["cui"]);
                $desglose=mysqli_fetch_assoc($datos);
                $nombre=$desglose["nombres"];
                $apellido=$desglose["apellido"];
                echo "<spam>".$nombre." ".$apellido."</spam><br>";

            }
            
        }
        else{
            echo "<spam>No hay alumnos con estado de abandono</spam>";
        }


    }


    else if(isset($_POST["post_stas_nota"])){
    //Aqui obtenemos la nota mayor y menor de cada unidad del curso  

        $curso=$_POST["post_stas_nota"];
        $unidad=$_POST["unidad"];

        $db=new Base_datos("localhost","root","","asistencia","alumnos_1");
        $db->conectar();

        $matriculados=$db->obtener_alumnos($curso,"lleva");
        if(!is_null($matriculados)){
            $totales=0;
            $array=array(
                "examen"=>array(
                    "nota_max"=>0,
                    "nota_min"=>20,
                    "suma_acumulada"=>0,
                    "alum_max"=>"nn",
                    "alum_min"=>"nn"),
                "continua"=>array(
                    "nota_max"=>0,
                    "nota_min"=>20,
                    "suma_acumulada"=>0,
                    "alum_max"=>"nn",
                    "alum_min"=>"nn")

            );
            while($row=mysqli_fetch_assoc($matriculados)){
                $totales++;

                $datos=$db->datos_alumno($row["cui"]);
                $desglose=mysqli_fetch_assoc($datos);


                $notas=$db->notas_alumno($curso,$unidad,$row["cui"]);
                $des_notas=mysqli_fetch_assoc($notas);
                $array["examen"]["suma_acumulada"]+=$des_notas["examen"];
                $array["continua"]["suma_acumulada"]+=$des_notas["continua"];

                if($totales<=1){
                    $array["examen"]["nota_max"]=$des_notas["examen"];
                    $array["examen"]["alum_max"]=$desglose["nombres"]." ".$desglose["apellido"];
                    $array["examen"]["nota_min"]=$des_notas["examen"];
                    $array["examen"]["alum_min"]=$desglose["nombres"]." ".$desglose["apellido"];
                    $array["continua"]["nota_max"]=$des_notas["continua"];
                    $array["continua"]["alum_max"]=$desglose["nombres"]." ".$desglose["apellido"];
                    $array["continua"]["nota_min"]=$des_notas["continua"];
                    $array["continua"]["alum_min"]=$desglose["nombres"]." ".$desglose["apellido"];

                }
                //notas de examen
                if($des_notas["examen"]>$array["examen"]["nota_max"]){
                    $array["examen"]["nota_max"]=$des_notas["examen"];
                    $array["examen"]["alum_max"]=$desglose["nombres"]." ".$desglose["apellido"];
                }
                else if($des_notas["examen"]<$array["examen"]["nota_min"]){
                    $array["examen"]["nota_min"]=$des_notas["examen"];
                    $array["examen"]["alum_min"]=$desglose["nombres"]." ".$desglose["apellido"];
                    
                }
                //Notas de continua
                if($des_notas["continua"]>$array["continua"]["nota_max"]){
                    $array["continua"]["nota_max"]=$des_notas["continua"];
                    $array["continua"]["alum_max"]=$desglose["nombres"]." ".$desglose["apellido"];
                }
                else if($des_notas["continua"]<$array["continua"]["nota_min"]){
                    $array["continua"]["nota_min"]=$des_notas["continua"];
                    $array["continua"]["alum_min"]=$desglose["nombres"]." ".$desglose["apellido"];
                    
                }
            }
            echo "<h3>Estadisticas Examen</h3><br>";
            echo "<span>El alumno que obtubo la mayor nota es : ".$array["examen"]["alum_max"]." con ".$array["examen"]["nota_max"]." puntos</span><br>";
            echo "<span>El alumno que obtubo la menor nota es : ".$array["examen"]["alum_min"]." con ".$array["examen"]["nota_min"]." puntos</span><br>";
            echo "<span>La nota promedio de la clase es : ".round(($array["examen"]["suma_acumulada"])/$totales,1)." puntos</span><br>";

            echo "<h3>Estadisticas Continua</h3><br>";
            echo "<span>El alumno que obtubo la mayor nota es : ".$array["continua"]["alum_max"]." con ".$array["continua"]["nota_max"]." puntos</span><br>";
            echo "<span>El alumno que obtubo la menor nota es : ".$array["continua"]["alum_min"]." con ".$array["continua"]["nota_min"]." puntos</span><br>";
            echo "<span>La nota promedio de la clase es : ".round(($array["continua"]["suma_acumulada"])/$totales,1)." puntos</span><br>";

            
        }      
    }

    else if(isset($_POST["post_stas_nota_f"])){
        //curso_c es la variable que almacena el codigo del curso recibido
        $curso_c=$_POST["post_stas_nota_f"];
        $db=new Base_datos("localhost","root","","asistencia","alumnos_1");
        $db->conectar();
        //Aqui obtenemos los alumnos aprobados y desaprobados del curso    
        $res=$db->codigo_curso($curso_c,"cursos_unsa");
        //var_dump($res);
        $row11=mysqli_fetch_assoc($res);
        $curso=$row11["cursos"];
    




        $alumnos_f=$db->obtener_alumnos($curso,"lleva");
        $array_unidad=["unidades","unidades2","unidades3"];
        $tabla="nota_final_curso";
        $por_exa=[0.1,0.1,0.3];
        $por_cont=[0.1,0.1,0.3];

        while($row=mysqli_fetch_assoc($alumnos_f)){
            $cui=$row["cui"];
            $examen_final=0;
            $continua_final=0;
            for($i=0;$i<3;$i++){
                $notas=$db->notas_alumno($curso,$array_unidad[$i],$cui);
                $desglose=mysqli_fetch_assoc($notas);
                $aux_exa=$desglose["examen"]*$por_exa[$i];
                $aux_cont=$desglose["continua"]*$por_cont[$i];
                $examen_final+=$aux_exa;
                $continua_final+=$aux_cont;
            }
            $db->llenar_notas_finales($cui,$tabla,$curso,$examen_final,$continua_final,$curso_c);
        }

        $alumnos_finales=$db->obtener_alumnos($curso,"nota_final_curso");
        $alumnos_aprovados=0;
        $alumnos_desaprovados=0;
        while($row=mysqli_fetch_assoc($alumnos_finales)){
            $not_f=$row["final"];
            if($not_f>=10.5){
                $alumnos_aprovados++;
            }
            else if($not_f<10.5){
                $alumnos_desaprovados++;
            }
        }
        echo "<span>Hay ".$alumnos_aprovados." alumnos aprovados en el curso de ".$curso."</span><br>";
        echo "<span>Hay ".$alumnos_desaprovados." alumnos desaprovados en el curso de ".$curso."</span><br>";
        $db->cerrar();
    }

    else if(isset($_POST["post_peligro_jalar"])){ // Determinamos si  la variable está definida y no es null
        $curso=$_POST["post_peligro_jalar"];
        $array_unidades=["unidades","unidades2"];
    
    //Aqui obtenemos los alumnos que estan en peligro de jalar el curso   
        $por=[0.1,0.1];
        $db=new Base_datos("localhost","root","","asistencia","alumnos_1");
        $db->conectar();
        $alumnos_f=$db->obtener_alumnos($curso,"lleva");

        while($row=mysqli_fetch_assoc($alumnos_f)){
            $cui=$row["cui"];
            $examen_par=0;
            $continua_par=0;
            $suma=0;
            for($i=0;$i<2;$i++){
                $notas=$db->notas_alumno($curso,$array_unidades[$i],$cui);
                $desglose=mysqli_fetch_assoc($notas);
                $aux_exa=$desglose["examen"]*$por[$i];
                $aux_cont=$desglose["continua"]*$por[$i];
                $examen_par+=$aux_exa;
                $continua_par+=$aux_cont;
                $suma+=($examen_par+$continua_par);
            }
            if($suma<4.5){
                //Si el alumno tiene menos de 4.5 en la suma de las 2 primeras notas parciales estara en peligro desaprobar
                $alumno_eva=$db->datos_alumno($cui);
                $emun=mysqli_fetch_assoc($alumno_eva);
                echo "<span>El alumno ".$emun["nombres"]." ".$emun["apellido"]." esta en peligro de jalar el curso</span><br>";
            }
        }

        echo ("ppppppppp");
    }
    ?>
    
