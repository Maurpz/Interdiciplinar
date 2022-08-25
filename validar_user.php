<?php
    include("base_datos.php");
    session_start();
    if($_POST["op"]=="profesor"){
        $tipo="profesores";
    }
    else{
        $tipo="alumnos_1";
    }
    $_SESSION["tipo"]=$tipo;
    $db=new Base_datos("localhost","root","","asistencia",$tipo);
    $db->conectar();

    $user=$_POST["usuario"];
    $pass=$_POST["pass"];
    
    $revisar_user=$db->get_user($user,$pass);
    if(!is_null($revisar_user)){
        if($tipo=="profesores"){
            $row=mysqli_fetch_assoc($revisar_user);
            if($row["user"]==$user&&$row["pass"]==$pass){
                $_SESSION["usuario"]=$user;
                $_SESSION["nombre"]=$row["nombres"];
                $_SESSION["apellido"]=$row["apellido"];
                $_SESSION["cursos"]=$row["cursos"];
                $db->cerrar();
                echo "1OK";
                return;
            }
        }
        else{
            $row=mysqli_fetch_assoc($revisar_user);
            if($row["user"]==$user&&$row["pass"]==$pass){
                $_SESSION["usuario"]=$user;
                $_SESSION["nombre"]=$row["nombres"];
                $_SESSION["apellido"]=$row["apellido"];
                $_SESSION["cui"]=$row["cui"];
                $db->cerrar();
                echo "OK";
                return;

        }
    }
    }
    session_unset();
    session_destroy();
    echo "Usuario no registrado";
    $db->cerrar();

?>