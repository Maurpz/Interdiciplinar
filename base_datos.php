<?php
    //Creamos la clase Base de datos con sus parámetros para concectarlo con la asistencia
    class Base_datos{
        private $host;
        private $usuario;
        private $pass;
        private $db;
        private $tabla;
        private $conexion;
        //Funcion para el constructor de la Clase
        function __construct($host,$usuario,$pass,$bd,$tabla){
            $this->host=$host;
            $this->usuario=$usuario;
            $this->pass=$pass;
            $this->bd=$bd;
            $this->tabla=$tabla;
        }
        //Esta función nos permite crear una conexión con una base de datos concreta.
        function conectar(){
            $this->conexion=mysqli_connect($this->host,$this->usuario,$this->pass,$this->bd);
            $this->conexion->set_charset("utf8");
            if(mysqli_connect_errno()){                       //Devuelve el código de error de la última llamada
                echo "Error al conectarse";
            }
        }
        //Esta función busca los datos creados en la tabla de la base de datos
        function get_clientes(){
            $result=mysqli_query($this->conexion,"SELECT * FROM $this->tabla"); //Realizamos una consulta a la base de datos
            $error=mysqli_error($this->conexion); //mysqli_error -> Devuelve una cadena que describe el último error
            if(empty($error)){
                if(mysqli_num_rows($result)>0){
                    return $result; //Retorna los datos en la tabla
                }
            }
            else{
                echo "Error al obtener los alumnos";//Retorna error al llamar a la tabla 
            }
            return null;
        }
        //Funcion para acceder a los usuarios de la base de datos(Con su usuario y clave)
        function get_user($user,$clave){
            $resultado=mysqli_query($this->conexion,"SELECT * FROM $this->tabla WHERE user='$user' AND pass='$clave'");
            $error=mysqli_error($this->conexion);
            if(empty($error)){
                if(mysqli_num_rows($resultado)>0){ //Se Obtiene el número de filas de un resultado
                    return $resultado;
                }
            }
            else{
                echo "Error al obtener usuario";
            }
            return null;
        }
        //Funcion para insertar los datos del usuario(DNI, Nombre , Apellido) en la Base de datos
        function insClientes($dni,$nombre,$apellido){
            $consult=mysqli_query($this->conexion,"SELECT *FROM $this->tabla WHERE dni='$dni'");
            if(mysqli_num_rows($consult)>0){return;} //Se Obtiene el número de filas de un resultado
            else if($dni===''||$nombre===''||$apellido===''){return;} //verificamos si los datos ingresados están vacíos
            
            else{
                mysqli_query($this->conexion,"INSERT INTO $this->tabla (dni,nombre,apellido) VALUES ('$dni','$nombre','$apellido')"); //insertamos lo datos del usuario en la Base de datos
                $error=mysqli_error($this->conexion);
                if(empty($error)){ //verificamos si se a producido un error
                    //echo "Usuario ingresado con exito";
                    return true;
                }
                echo "Error al insertar usuario";
                    //Error al ingresar usuario
                return false;
            }
        }

        //---------------------------ASISTENCIA----------------------------------
        //Funcion para obtener la tabla de alumnos de un curso 
        function obtener_alumnos($curso,$tabla){
            $alumnos=mysqli_query($this->conexion,"SELECT * FROM $tabla WHERE curso='$curso'"); //Se selecciona la tabla de alumnos matriculados en un curso
            $error=mysqli_error($this->conexion);    
            if(empty($error)){
                if(mysqli_num_rows($alumnos)>0){
                    return $alumnos;//Se obtiene la tabla con la lista de alumnos matriculados en el curso
                }
            }
            else{
                echo "Error al obtener los alumnos matriculados en el curso";
                return null;
            }
        }

        //Está Función retorna los alumnos dependiendo del CUI
        function datos_alumno($cui){
            $alumno=mysqli_query($this->conexion,"SELECT * FROM $this->tabla WHERE cui='$cui'"); //Busca en la tabla el CUI
            $error=mysqli_error($this->conexion); //se crea la varible "error" para indentificar errores en la conexión 
            if(empty($error)){
                if(mysqli_num_rows($alumno)>0){
                    return $alumno;
                }
            }
            else{
                echo "Error al obtener el alumno";
                return null;
            }
        }
        //Está función retorna los alumnos matriculados en un curso para ver su asistencia 
        function datos_alumno_asis($cui,$curso){
            $alumno=mysqli_query($this->conexion,"SELECT * FROM $this->tabla WHERE cui='$cui' AND curso='$curso'");
            $error=mysqli_error($this->conexion); //se crea la varible "error" para indentificar errores en la conexión 
            if(empty($error)){ //comprueba si la variable "error" se encuentra vacía
                if(mysqli_num_rows($alumno)>0){
                    return $alumno;
                }
            }
            else{
                echo "Error al obtener el alumno";
                return null;
            }

        }
        //funcion para identificar si el alumno estuvo presente o faltó en la assitencia del curso
        function asis_day($pres,$falt,$curso,$tabla){
            mysqli_query($this->conexion,"UPDATE $tabla SET pre='$pres',fal='$falt' WHERE curso='$curso'");
        }

        //Función para actualizar la asistencia mediante el CUI y curso
        function actualizar_asistencia($campo,$valor,$cui,$curso){
            mysqli_query($this->conexion,"UPDATE $this->tabla SET $campo='$valor' WHERE cui='$cui' AND curso='$curso'");

        }
        //Función para ver los alumnos que abandonaron el curso
        function abandono_alum($curso,$tabla){
            $r=mysqli_query($this->conexion,"SELECT * FROM $tabla WHERE curso='$curso' AND falto>=10 AND falto>presente");
            return $r;
        }












        //----------------------------------NOTAS-------------------------------------
        //La funcion "llenar_notas" busca si exite el dato en caso no exista inserta un nuevo dato con la informacion especificada 
        function llenar_notas($examen,$continua,$cui,$curso,$tabla,$codigo){
            $var=mysqli_query($this->conexion,"SELECT * FROM $tabla WHERE curso='$curso' AND cui='$cui'");
            if(mysqli_num_rows($var)>0){
                mysqli_query($this->conexion,"UPDATE $tabla SET examen='$examen',continua='$continua' WHERE cui='$cui' AND curso='$curso'");
            }
            else{
                mysqli_query($this->conexion,"INSERT INTO $tabla(cui,curso,continua,examen,codigo) VALUES ('$cui','$curso','$continua','$examen','$codigo')");
            }
            
        }

        //consulta en la tabla si hay un alumno con CUI y Curso
        function notas_alumno($curso,$tabla,$cui){
            $res=mysqli_query($this->conexion,"SELECT * FROM $tabla WHERE curso='$curso' AND cui='$cui'");
            return $res;

        }
        //La funcion "llenar_notas_finales" Suma la nota continua final y examen final  
        function llenar_notas_finales($cui,$tabla,$curso,$examen_f,$continua_f,$codigo){
            $final_nota=$examen_f+$continua_f;
            $var=mysqli_query($this->conexion,"SELECT * FROM $tabla WHERE curso='$curso' AND cui='$cui'");
            if(mysqli_num_rows($var)>0){
                mysqli_query($this->conexion,"UPDATE $tabla SET examen_ac='$examen_f',continua_ac='$continua_f',final='$final_nota',codigo='$codigo' WHERE cui='$cui' AND curso='$curso'");
            }
            //Si la nota ya existe se actualizara
            else{
                mysqli_query($this->conexion,"INSERT INTO $tabla(cui,curso,continua_ac,examen_ac,final,codigo) VALUES ('$cui','$curso','$continua_f','$examen_f','$final_nota','$codigo')");
            }
            //Si la nota no existe se rellenara 
        }




            //---------------------------GRAFICOS------------------------------------
            //Retorna el numero de asistencias
            function num_asis($curso){
                $res=mysqli_query($this->conexion,"SELECT * FROM lleva WHERE presente>=1 AND curso='$curso'");
                $num=mysqli_num_rows($res);
                return $num;
            }
            //retorna el numero de faltas
            function num_falt($curso){
                $res=mysqli_query($this->conexion,"SELECT * FROM lleva WHERE falto>=1 AND curso='$curso'");
                $num=mysqli_num_rows($res);
                return $num;
            }
            //retorna 
            function num_day($curso,$tabla){
                $res=mysqli_query($this->conexion,"SELECT * FROM $tabla WHERE curso='$curso'");
                return $res;
            }
            //retorna 
            function asis_alumnos($curso){
                $res=mysqli_query($this->conexion,"SELECT * FROM lleva WHERE curso='$curso'");
                return $res;
            }
            //retorna    
            function cerrar(){
                mysqli_close($this->conexion);
                //echo "Cerramos conexion con mysql";
            }

        //---------------------------------------------------------------------------------------
        function cursos_unsa($tabla,$semestre){
            $res=mysqli_query($this->conexion,"SELECT * FROM $tabla WHERE Semestre='$semestre'");
            return $res;

        }

        function Obtener_permiso($campo,$tabla){
            $var=mysqli_query($this->conexion,"SELECT $campo FROM $tabla");
            if(mysqli_num_rows($var)>0){
                return $var;
            }
            else{
                return null;
            }

        }


        //--------------------------------Matricular ---------------------------------------
        function matricular($tabla,$curso,$cui,$codigo){
            $res=mysqli_query($this->conexion,"SELECT * FROM $tabla WHERE curso='$curso' AND cui='$cui'");
            if(mysqli_num_rows($res)>0){
                return true;
            }
            else{
                mysqli_query($this->conexion,"INSERT INTO $tabla (cui,curso,presente,falto,codigo) VALUES ('$cui','$curso',0,0,'$codigo') ");
            }
            
        }



        function estado_curso($cui,$curso){
            $res=mysqli_query($this->conexion,"SELECT condicion FROM estado_cursos WHERE cui='$cui' AND codigo_curso='$curso'");
            if(mysqli_num_rows($res)>0){
                return $res;
            }
            else{
                return null;
            }
        }

        function codigo_curso($codigo,$tabla){
            $res=mysqli_query($this->conexion,"SELECT cursos FROM $tabla WHERE codigo='$codigo'");
            if(mysqli_num_rows($res)>0){
                return $res;
            }
            else{
                return null;
            }
        }

        //-----------------------------subir_registro($tabla,$cui,$codigo_curso,$curso,$nota,"Aprovado",$semestre);
        function subir_registro($tabla,$cui,$codigo_curso,$curso,$nota,$estado,$semestre){
            $var=mysqli_query($this->conexion,"SELECT * FROM $tabla WHERE curso='$curso' AND cui='$cui'");
            if(mysqli_num_rows($var)>0){
                mysqli_query($this->conexion,"UPDATE $tabla SET nota='$nota',condicion='$estado' WHERE cui='$cui' AND curso='$curso'");
            }
            else{
                mysqli_query($this->conexion,"INSERT INTO $tabla(cui,codigo_curso, curso, nota,condicion, semestre) VALUES ('$cui','$codigo_curso','$curso','$nota','$estado','$semestre')");
            }


        }
    }

        
    ?>