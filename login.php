<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/TRABAJO%20INTERDICIPLINAR/P1/style.css">
    <title>Login</title>
</head>
<body class="cont_log">
    <div>
        <h2>Iniciar secion </h2>
    </div>
    <div class="div_login">
        <form>
            <fieldset class="legent">
                <legend>Quien eres</legend>
                <div>
                    <label><input type="radio" id="op1" name="op">Profesor</label>
                </div>
                <div>
                    <label><input type="radio"id="op2" name="op">Alumno</label>
                </div>
            </fieldset>
            
            <input type="text" id="user" placeholder="usuario">
            <input type="text" id="pass" placeholder="contraseña">
            <button type="button" id="btn_acc">Iniciar</button>
        </form>
        <span id="resultado"></span>
    </div>
<script src="http://localhost/trABAJO%20INTERDICIPLINAR/P1/destino.js"></script>
</body>
</html>