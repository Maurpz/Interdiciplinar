//Creamos la función asignar, esta nos servirá para enviar el tipo de usuario "profesor" o "alumno".
function asignar(){
    var op1=document.getElementById("op1"); //obtenemos el iD de la opcion1
    var op2=document.getElementById("op2"); //obtenemos el iD de la opcion2
    val_op=op1.checked; //obtenemos la opción1 marcada
    var op;
    if(val_op==true){
        op="profesor";
    }
    else{
        op="alumno";
    }
    var user=document.getElementById("user"); //obtenemos el iD del Usuario
    var pass=document.getElementById("pass"); //obtenemos el iD del pass
    user_val=user.value; //obtenemos el iD del Usuario
    pass_val=pass.value; //obtenemos el iD del pass 
    console.log(user_val); //imprimimos en consola el usuario
    console.log(pass_val); //imprimimos en consola el pass

    if(user_val==""||pass_val==""){ //se verifica que el usuario y pass no esté vacío
        alert("Porfavor llene todos los campos");
        return;
    }
    contenido=document.getElementById("resultado"); //Se obtiene le ID del resutlado

    ajax=new XMLHttpRequest();
    ajax.onreadystatechange=function(){
        if(ajax.readyState==4 && ajax.status==200){
            if(ajax.responseText.trim()=="OK"){
                window.location.href="home.php";
            }
            else if(ajax.responseText.trim()=="1OK"){
                window.location.href="home_profesor.php";
            }
            else{
                contenido.innerHTML=ajax.responseText;
            }
        }
    }

    ajax.open("POST","http://localhost/trABAJO%20INTERDICIPLINAR/P1/validar_user.php");
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("op="+op+"&usuario="+user_val+"&pass="+pass_val);
};

//Espera  a que un botón sea presionado
function espera(){
    btnAcceder=document.getElementById("btn_acc");
    btnAcceder.addEventListener("click",asignar);
}
//La ventana espera la ejecución de un evento para actualizarse
window.addEventListener("load",espera);