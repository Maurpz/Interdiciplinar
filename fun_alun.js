function matricula(){
    var cui=document.getElementById("cui").value;

    var contenido=document.getElementById("cont_matricula");
    ajax=new XMLHttpRequest();
    ajax.onreadystatechange=function(){
        if(ajax.readyState==4 && ajax.status==200){
            contenido.innerHTML=ajax.responseText;
            }
        
    }

    ajax.open("POST","http://localhost/trABAJO%20INTERDICIPLINAR/P1/datos.php");
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("cui="+cui+"&accion=matricula");



};

function espera(){
    btn1=document.getElementById("btn_matricula");
    btn1.addEventListener("click",matricula);
}

//La ventana espera la ejecución de un evento para actualizarse
window.addEventListener("load",espera);