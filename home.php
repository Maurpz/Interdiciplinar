<?php
session_start();
if(!isset($_SESSION["usuario"])){
    header("Location:login.php");
    exit();
} 

else if($_SESSION["tipo"]!="alumnos_1"){
    header("Location:login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>
        home sesion
    </h1>
    <h2>
        Bienvenido <?php echo $_SESSION["nombre"]." ".$_SESSION["apellido"]?>
        <input type="hidden" id="cui" value='<?php echo $_SESSION["cui"]?>'>

    </h2>

    <div>
        <button id="btn_matricula">Mostrar cursos que puede adelantar</button>
        <div id="cont_matricula"></div>
    </div>

    <!--div>
        <form method="get">
            <table>
                <thead>
                    <th>Cursos</th>
                    <th>Opcion</th>
                </thead>
                <tbody>
                    <tr><td>curso</td><td><input type="checkbox" name="curso1" ></td></tr>
                    <tr><td>curso</td><td><input type="checkbox" name="curso2" ></td></tr>
                    <tr><td>curso</td><td><input type="checkbox" name="curso3" ></td></tr>
                </tbody>
            </table>
            <button type="submit">Matricularse</button>

        </form>
    </div-->

    <div id="contenido_2"></div>
    <h4></h4>
    <a href="cerrar_cesion.php">Cerrar secion</a>
<script src="http://localhost/traBAJO%20INTERDICIPLINAR/P1/fun_alun.js"></script>
</body>
</html>