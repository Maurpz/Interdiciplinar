<?php
session_start();
if(!isset($_SESSION["usuario"])){
    header("Location:login.php");
    exit();
}

else if($_SESSION["tipo"]!="profesores"){
    header("Location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.js"></script>
    <link rel="stylesheet" href="http://localhost/TRABAJO%20INTERDICIPLINAR/P1/style.css">

    <title>Document</title>
</head>
<body>
    <h1>
        Home sesion
    </h1>
    <h2>
        Bienvenido <?php echo $_SESSION["nombre"]." ".$_SESSION["apellido"]?>
    </h2>


    
    <h1>Asistencia</h1>
    <p>
    <?php
        include("base_datos.php");
        $db=new Base_datos("localhost","root","","asistencia","cursos_unsa");
        $db->conectar();
    $str=$_SESSION["cursos"];
    $cursos=explode(",",$str);
    for($i=0;$i<count($cursos);$i++){
        
        if($i==2){
            $res=$db->codigo_curso($cursos[$i],"cursos_unsa");
            //var_dump($res);
            $row=mysqli_fetch_assoc($res);
            echo "<label><td><input type='radio' name='curso_general' value=".$cursos[$i]." checked></td>".$row["cursos"]."</label>";
        }

        if($i==0){
            echo "<label><td><input type='radio' name='curso_general' value=".$cursos[$i]." checked></td>".$cursos[$i]."</label>";
        }
        else{
            echo "<label><td><input type='radio' name='curso_general' value=".$cursos[$i]."></td>".$cursos[$i]."</label>";
        }
        //echo $cursos[$i]."<br>";
    }
    $db->cerrar();
    ?>
    </p>

<!--Tomas asistencia-->
    <div>
        
        <div>
            <!--label for="pp">Escriba el curso</!--label>
            <input type="text" placeholder="curso" name="pp" id="curso_as"-->
            <button id="btn_asi" >Mostrar alumnos</button>
        </div>
        
        <div>
            <iframe name="ulti"></iframe>
            <form action="update_asistencia.php" method="post" target="ulti">
                <table >
                    <thead >
                        <th>cui</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Presente</th>
                        <th>Falto</th>
                    </thead>
                    <tbody id="lista_asi">
                    </tbody>
                </table>
                <input type="submit" id="env_asi"value="Subir asistencia" >
            </form>
        </div>

        <button id="mos_gra" >Mostrar graficos asistencia diaria</button>
        <button id="btn_por_asis_alum" >Mostrar porcentaje de asistencia por alumno</button>
        

        
        <div class="gr_cnt">
            <canvas id="grap_day"></canvas>
            <canvas id="por_asis_alum"></canvas>
        </div>
        <div id="cont_day"></div>

        
        <div id="cont_por_asis_alum"></div>

    

    <!--Notas-->
    <h1>Notas</h1>


    <?php
    $unidades=["unidades","unidades2","unidades3"];
    $label=["Unidad I","Unidad II","Unidad III"];
    for($i=0;$i<count($label);$i++){
        if($i==0){
            echo "<label><td><input type='radio' name='unidad_general' value=".$unidades[$i]." checked></td>".$label[$i]."</label>";
        }
        else{
            echo "<label><td><input type='radio' name='unidad_general' value=".$unidades[$i]."></td>".$label[$i]."</label>";
        }
    }
    ?>
    <div>
        <div>
            <!--label for="pp">Escriba el curso</!--label>
            <input type="text" placeholder="curso" id="sb_notas"-->
            <button id="btn_notas" >Mostrar alumnos</button>
        </div>

        <div>
            <iframe name="cap_submit"></iframe>
            <form action="update_asistencia.php" method="post" target="cap_submit">
                <table>
                    <thead>
                        <th>cui</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Examen</th>
                        <th>Continua</th>
                    </thead>
                    <tbody id="lista_notas">
                    </tbody>
                </table>
                <input type="submit" id="env_notas"value="Subir notas">
            </form>
        
    </div>

    <!--Graficos-->
    <h1>Graficos</h1>
<div>
    <!--Cantidad de alumnos que han asistido a clase durante el semestre-->
    <h3>Cantidad de alumnos que han asistido y faltado a clase durante el semestre</h3>
    <div class="gr_cnt">
        <canvas id="graps_1"></canvas>
        <?php
        include_once("base_datos.php");
        $db=new Base_datos("localhost","root","","asistencia","lleva");
        $db->conectar();

        $curso="arqui1";
        $asis=$db->num_asis($curso);
        $falt=$db->num_falt($curso);
        $db->cerrar();
        ?>
        <script>
            var cont_1=document.getElementById("graps_1");
            var mychar=new Chart(cont_1,{
            type:"doughnut",
            data:{
                labels: [
                        'Asistentes',
                        'Faltantes'],
            datasets: [{
            label: 'My First Dataset',
            data: [<?php echo $asis;?>, <?php echo $falt;?>],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)'],
                hoverOffset: 4}]
            }
        });
            
        </script>
    </div>
</div>

<!--Datos escrito -->

<div>
    <!--cuantas clases se ha tenido durante e semestre -->
    <button id="btn_cla_sem">Clases llevadas durante el semestre</button>
    <div id="clases_semestre"></div>

    <button id="btn_alum_abandono" >Cuantos alumnos han abandonado el curso</button>
    <div id="cont_alum_abandono"></div>
</div>
<!--Datos escrito Notas-->
<div>
    <button id="btn_stas_nota">¿Quién obtuvo la mejor nota y cual es?</button>
    <div id="cont_stas_nota"></div>

</div>


<!--Personas en peligro de jalar-->
<div>
    <button id="btn_peligro_jalar">Alumnos en peligro de jalar</button>
    <div id="cont_peligro_jalar"></div>

</div>

<div>
    <button id="btn_notas_finales">Estadisticas Finales</button>
    <div id="cont_notas_finales">
    </div>
</div>

<div>
    
    <form action="pdf.php" method="post">
        <input type="hidden" name="curso_pdf">
    </form>
    <button id="btn_gen_pdf" >Generar reporte en pdf</button>
    <div cont="cont_gen_pdf"></div>
</div>


<div>
    <button id="btn_sub_nota_final">Subir Notas finales al Sistema</button>
    <div id="cont_msg_nota_final"></div>
</div>




    <a href="cerrar_cesion.php">Cerrar secion</a>
<script src="http://localhost/TRABAJO%20INTERDICIPLINAR/P1/fun_prof.js"></script>
</body>
</html>