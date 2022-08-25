//crear un input general con los cursos de manera que selecione la profesora
//el curso que desee para todas las opciones y asi
//no escribira que curso necesita solo selecionando
//un buton radio
function asistencia(){
    //var curso=document.getElementById("curso_as");
    //curso_val=curso.value;
    var curso=curso_gen();

    
    ajax1=new XMLHttpRequest();

    cont1=document.getElementById("lista_asi");
    ajax1.onreadystatechange=function(){
        if(ajax1.readyState==4 &&ajax1.status==200){
            cont1.innerHTML=ajax1.responseText;
        }
    }
    ajax1.open("POST","http://localhost/TRABAJO%20INTERDICIPLINAR/P1/funciones_prof.php");
    ajax1.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax1.send("curso1="+curso);
    //ajax1.send("curso1="+curso_val);
};


function sbr_notas(){
    //console.log("gaaaaaaaaa ctv");
    //var curso2=document.getElementById("sb_notas");
    //curso_val2=curso2.value;
    var curso_2=curso_gen();
    var unidad_0=unidad_gen();

    ajax2=new XMLHttpRequest();
    cont2=document.getElementById("lista_notas");

    ajax2.onreadystatechange=function(){
        if(ajax2.readyState==4 &&ajax2.status==200){
            cont2.innerHTML=ajax2.responseText;
        }
    }
    ajax2.open("POST","http://localhost/TRABAJO%20INTERDICIPLINAR/P1/funciones_prof.php");
    ajax2.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax2.send("curso2="+curso_2+"&unidad_1="+unidad_0);
    //ajax2.send("curso2="+curso_val2);

};

function diario(){
    ajax4=new XMLHttpRequest();
    var curso88=curso_gen();

    //cont4=document.getElementById("cont_day");
    ajax4.onreadystatechange=function(){
        if(ajax4.readyState==4 &&ajax4.status==200){

            addElement();
            function addElement () {
            var newDiv=document.createElement("script");
            var resp=ajax4.responseText;
            
            var newContent = document.createTextNode(resp);
            newDiv.appendChild(newContent); //añade texto al div creado.
    
            // añade el elemento creado y su contenido al DOM
            var currentDiv = document.getElementById("cont_day");
            currentDiv.insertAdjacentElement("beforeend",newDiv);
            } 
        }
    }
    ajax4.open("POST","http://localhost/TRABAJO%20INTERDICIPLINAR/P1/update_asistencia.php");
    ajax4.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax4.send("day="+curso88);

}

function cla_sem(){
    var curso_3=curso_gen();

    ajax5=new XMLHttpRequest();
    cont5=document.getElementById("clases_semestre");

    ajax5.onreadystatechange=function(){
        if(ajax5.readyState==4 &&ajax5.status==200){
            cont5.innerHTML=ajax5.responseText;
        }
    }

    ajax5.open("POST","http://localhost/TRABAJO%20INTERDICIPLINAR/P1/update_asistencia.php");
    ajax5.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax5.send("cla_t="+curso_3);
    //ajax5.send("cla_t="+1);

}

function graf_asis_alum(){
    var curso_4=curso_gen();
    ajax6=new XMLHttpRequest();

    //cont6=document.getElementById("cont_day");
    ajax6.onreadystatechange=function(){
        if(ajax6.readyState==4 &&ajax6.status==200){
            //console.log("gaaaa")
            //console.log(ajax6.responseText);

            addElement();
            function addElement () {
            var newDiv=document.createElement("script");
            var resp=ajax6.responseText;
            
            var newContent = document.createTextNode(resp);
            newDiv.appendChild(newContent); //añade texto al div creado.
    
            // añade el elemento creado y su contenido al DOM
            var currentDiv = document.getElementById("cont_por_asis_alum");
            currentDiv.insertAdjacentElement("beforeend",newDiv);
            } 
        }
    }
    ajax6.open("POST","http://localhost/TRABAJO%20INTERDICIPLINAR/P1/update_asistencia.php");
    ajax6.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //ajax6.send("porcent_asis_alum="+1);
    ajax6.send("porcent_asis_alum="+curso_4);


}

function fun_alum_abandono(){
    var curso_5=curso_gen();
    ajax7=new XMLHttpRequest();
    var cont7=document.getElementById("cont_alum_abandono");
    ajax7.onreadystatechange=function(){
        if(ajax7.readyState==4 &&ajax7.status==200){
            cont7.innerHTML=ajax7.responseText;
        }
    }

    ajax7.open("POST","http://localhost/TRABAJO%20INTERDICIPLINAR/P1/update_asistencia.php");
    ajax7.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax7.send("post_alum_abandono="+curso_5);
    //ajax7.send("post_alum_abandono="+1);


}

function fun_stas_nota(){
    var curso_6=curso_gen();
    var unidad_1=unidad_gen();
    //console.log("hola manos que fueeeee");
    ajax8=new XMLHttpRequest();
    var cont8=document.getElementById("cont_stas_nota");
    ajax8.onreadystatechange=function(){
        if(ajax8.readyState==4 &&ajax8.status==200){
            cont8.innerHTML=ajax8.responseText;
        }
    }

    ajax8.open("POST","http://localhost/TRABAJO%20INTERDICIPLINAR/P1/update_asistencia.php");
    ajax8.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax8.send("post_stas_nota="+curso_6+"&unidad="+unidad_1);
    //ajax8.send("post_stas_nota="+1);


}


function fun_notas_finales(){
    var curso_7=curso_gen();
    //var unidad_2=unidad_gen();
    ajax9=new XMLHttpRequest();
    var cont9=document.getElementById("cont_notas_finales");
    ajax9.onreadystatechange=function(){
        if(ajax9.readyState==4 &&ajax9.status==200){
            cont9.innerHTML=ajax9.responseText;
        }
    }

    ajax9.open("POST","http://localhost/TRABAJO%20INTERDICIPLINAR/P1/update_asistencia.php");
    ajax9.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //ajax9.send("post_stas_nota_f="+curso_7+"&unidad_f="+unidad_2);
    ajax9.send("post_stas_nota_f="+curso_7);

}

function fun_peligro_jalar(){
    var curso_8=curso_gen();
    //var unidad_2=unidad_gen();
    ajax10=new XMLHttpRequest();
    var cont10=document.getElementById("cont_peligro_jalar");
    ajax10.onreadystatechange=function(){
        if(ajax10.readyState==4 &&ajax10.status==200){
            cont10.innerHTML=ajax10.responseText;
        }
    }

    ajax10.open("POST","http://localhost/TRABAJO%20INTERDICIPLINAR/P1/update_asistencia.php");
    ajax10.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //ajax9.send("post_stas_nota_f="+curso_7+"&unidad_f="+unidad_2);
    ajax10.send("post_peligro_jalar="+curso_8);

}

function fun_gen_pdf(){
    var curso_9=curso_gen();
    //var unidad_2=unidad_gen();
    ajax11=new XMLHttpRequest();
    var cont11=document.getElementById("cont_gen_pdf");
    ajax11.onreadystatechange=function(){
        if(ajax11.readyState==4 &&ajax11.status==200){
            //window.location.href=ajax11.responseXml;
            //header("pdf.php");
            //cont11.innerHTML=ajax11.responseText;
            window.location.href="pdf.php?curso_pdf=arqui1";
            
            //window.location.href="'pdf.php?curso_pdf='+curso_9";
        }
    }

    ajax11.open("POST","http://localhost/TRABAJO%20INTERDICIPLINAR/P1/pdf.php");
    ajax11.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //ajax9.send("post_stas_nota_f="+curso_7+"&unidad_f="+unidad_2);
    ajax11.send("curso_pdf="+curso_9);

}


function fun_sub_notas_finales(){
    var curso_12=curso_gen();
    //var unidad_2=unidad_gen();
    ajax12=new XMLHttpRequest();
    var cont12=document.getElementById("cont_msg_nota_final");
    ajax12.onreadystatechange=function(){
        if(ajax12.readyState==4 &&ajax12.status==200){
            cont12.innerHTML=ajax12.responseText;
        }
    }

    ajax12.open("POST","http://localhost/TRABAJO%20INTERDICIPLINAR/P1/datos.php");
    ajax12.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //ajax9.send("post_stas_nota_f="+curso_7+"&unidad_f="+unidad_2);
    ajax12.send("post_sub_nota_final="+curso_12);

}


function hola() {
    console.log("puedo entrar aqui que fue");
    
}

function curso_gen(){
    var op=document.querySelector('input[name=curso_general]:checked').value;
    return op;
}
function unidad_gen(){
    var op_1=document.querySelector('input[name=unidad_general]:checked').value;
    return op_1;

}

function espera(){
    btn2=document.getElementById("btn_notas");
    btn2.addEventListener("click",sbr_notas);

    btn1=document.getElementById("btn_asi");
    btn1.addEventListener("click",asistencia);

    btn3=document.getElementById("mos_gra");
    btn3.addEventListener("click",diario);

    btn4=document.getElementById("btn_cla_sem");
    btn4.addEventListener("click",cla_sem);

    btn5=document.getElementById("btn_por_asis_alum");
    btn5.addEventListener("click",graf_asis_alum);

    btn6=document.getElementById("btn_alum_abandono");
    btn6.addEventListener("click",fun_alum_abandono);

    btn7=document.getElementById("btn_stas_nota");
    btn7.addEventListener("click",fun_stas_nota);

    btn8=document.getElementById("btn_notas_finales");
    btn8.addEventListener("click",fun_notas_finales);

    btn9=document.getElementById("btn_peligro_jalar");
    btn9.addEventListener("click",fun_peligro_jalar);

    btn10=document.getElementById("btn_gen_pdf");
    btn10.addEventListener("click",fun_gen_pdf);

    btn11=document.getElementById("btn_sub_nota_final");
    btn11.addEventListener("click",fun_sub_notas_finales);


};


window.addEventListener("load",espera);


