var page;

function execDatatable(text) {

/*=============================================
 Validamos tabla de administradores
=============================================*/ 

if($(".tableAdmins").length > 0){

  var url = "ajax/data-admins.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");

  var columns = [
    {"data": "id_user"},
    {"data": "picture_user", "orderable":false, "search":false},
    {"data": "username_user"},
    {"data": "displayname_user"},
     {"data": "cargo_user"},
    {"data": "email_user"},
    {"data": "date_created_user"},
    {"data": "actions", "orderable":false}
  ];

  page = "admins";


}

/*=============================================
 Validamos tabla de barrios
=============================================*/ 

if($(".tableBarrios").length > 0){

  var url = "ajax/data-barrios.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");

  var columns = [
    {"data": "id_barrio"},
    {"data": "nombre_barrio"}, 
    {"data": "fecha_creacion_barrio"},
    {"data": "fecha_creacion_barrio"},    
    {"data": "actions", "orderable":false}
  ];

  page = "barrios";


}

/*=============================================
 Validamos tabla de categoria de negocios
=============================================*/ 

if($(".tableCatNegocios").length > 0){

  var url = "ajax/data-catnegocios.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");
  
  var columns = [
    {"data": "id_categorianegocio"},
    {"data": "nombre_categorianegocio"}, 
    {"data": "icono_categorianegocio"},
    {"data": "visitas_categorianegocio"},    
    {"data": "fecha_creacion_categorianegocio"},    
    {"data": "actions", "orderable":false}
  ];
  

  page = "catnegocios";

}

/*=============================================
 Validamos tabla de categoria de noticias
=============================================*/ 

if($(".tableCatNoticias").length > 0){

  var url = "ajax/data-catnoticias.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");
  
  var columns = [
    {"data": "id_categorianoticia"},
    {"data": "nombre_categorianoticia"}, 
    {"data": "descripcion_categorianoticia"},
    {"data": "icono_categorianoticia"},
    {"data": "fecha_creacion_categorianoticia"},    
    {"data": "actions", "orderable":false}
  ];  

  page = "catnoticias";

}

/*=============================================
 Validamos tabla de noticias
=============================================*/ 

if($(".tableNoticias").length > 0){

  var url = "ajax/data-noticias.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");
  
  var columns = [
    {"data": "id_noticia"},
    {"data": "actions", "orderable":false},
    {"data": "categoria_noticia"},
    {"data": "titulo_noticia"},  
    {"data": "logo"}, 
    {"data": "resumen_noticia"},
    {"data": "visitas_noticia"},  
    {"data": "cuerpo_noticia"}, 
    {"data": "fecha_creacion_noticia"},  
    {"data": "fecha_actualizacion_noticia"} 
   
  ];  

  page = "noticias";

}

/*=============================================
 Validamos tabla de negocios
=============================================*/ 

if($(".tableNegocios").length > 0){

  var url = "ajax/data-negocios.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");
  
  var columns = [
     {"data": "id_negocio"},
     {"data": "actions", "orderable":false},
     {"data": "nombre_negocio"},
     {"data": "logo_negocio"},
     {"data": "direccion_negocio"},
     {"data": "telefono_negocio"},
     {"data": "mapa_negocio"},
     {"data": "correo_negocio"},
     {"data": "descripcion_negocio"},
     {"data": "categoria_negocio"},
     {"data": "nombre_barrio"},
     {"data": "gallery_product"},
     {"data": "paginaweb_negocio"},
     {"data": "socialnetwork_store"},
     {"data": "fecha_creacion_negocio"}
  ];

  page = "negocios";

}

/*=============================================
 Validamos tabla de usuarios
=============================================*/ 

if($(".tableUsers").length > 0){

  var url = "ajax/data-users.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");

  var columns = [
    {"data": "id_user"},
    {"data": "foto_user", "orderable":false, "search":false},
    {"data": "displayname_user"},
    {"data": "username_user"},
    {"data": "email_user"},
    {"data": "method_user"},
    {"data": "country_user"},
    {"data": "city_user"},
    {"data": "address_user"},
    {"data": "phone_user"},
    {"data": "date_created_user"}
  ];

  page = "admins";

}

/*=============================================
 Validamos tabla de categorias
=============================================*/ 

if($(".tableCategories").length > 0){

  var url = "ajax/data-categories.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");

  var columns = [
    {"data": "id_category"},
    {"data": "image_category", "orderable":false, "search":false},
    {"data": "name_category"},
    {"data": "title_list_category"},
    {"data": "url_category"},
    {"data": "icon_category"},
    {"data": "views_category"},
    {"data": "date_created_category"},
    {"data": "actions", "orderable":false}
  ];

  page = "categories";

}

/*=============================================
 Validamos tabla de categoria de cursos
=============================================*/ 

if($(".tableCatCursos").length > 0){

  var url = "ajax/data-catcursos.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");
  
  var columns = [
    {"data": "id_categoriacurso"},
    {"data": "nombre_categoriacurso"}, 
    {"data": "descripcion_categoriacurso"},
    {"data": "icono_categoriacurso"},
    {"data": "fecha_creacion_categoriacurso"},    
    {"data": "actions", "orderable":false}
  ];  

  page = "catcursos";

}

/*=============================================
 Validamos tabla de cursos
=============================================*/ 

if($(".tableCursos").length > 0){

  var url = "ajax/data-cursos.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");
  
  var columns = [
    {"data": "id_curso"},
    {"data": "actions", "orderable":false},
    {"data": "categoria_curso"},
    {"data": "nombre_curso"},  
    {"data": "logo"}, 
    {"data": "descripcion_curso"},
    {"data": "visitas_curso"},  
    {"data": "contenido_curso"}, 
    {"data": "fecha_creacion_curso"},  
    {"data": "fecha_actualizacion_curso"} 
   
  ];  

  page = "cursos";

}


/*=============================================
 Validamos tabla de mensajes
=============================================*/ 

if($(".tableMensajes").length > 0){

  var url = "ajax/data-mensajes.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&idAdmin="+$("#idAdmin").val();

   var columns = [
      { "data": "id_mensaje" },
      { "data": "correo_mensaje" },
      { "data": "contenido_mensaje", "orderable": false },
      { "data": "fecha_creacion_mensaje" }  
        
  ];

  page = "mensajes";

}

/*=============================================
 Validamos tabla de categoria denuncias
=============================================*/ 

if($(".tableCatDenuncias").length > 0){

  var url = "ajax/data-catdenuncias.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");
  
  var columns = [
    {"data": "id_categoriadenuncia"},
    {"data": "nombre_categoriadenuncia"}, 
    {"data": "descripcion_categoriadenuncia"},
    {"data": "fecha_creacion_categoriadenuncia"},    
    {"data": "actions", "orderable":false}
  ];  

  page = "catdenuncias";

}
/*=============================================
 Validamos tabla denuncias
=============================================*/ 

if($(".tableDenuncias").length > 0){

  var url = "ajax/data-denuncias.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");
  
  var columns = [
    {"data": "id_denuncia"},
    {"data": "actions", "orderable":false},
    {"data": "categoria_denuncia"},
    {"data": "nombre_denuncia"},  
    {"data": "logo"}, 
    {"data": "descripcion_denuncia"},
    {"data": "visitas_denuncia"},  
    {"data": "contenido_denuncia"}, 
    {"data": "fecha_creacion_denuncia"},  
    {"data": "fecha_actualizacion_denuncia"} 
   
  ];  

  page = "denuncias";

}


/*=============================================
 Validamos tabla de categoria tramites
=============================================*/ 

if($(".tableCatTramites").length > 0){

  var url = "ajax/data-cattramites.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");
  
  var columns = [
    {"data": "id_categoriatramite"},
    {"data": "nombre_categoriatramite"}, 
    {"data": "descripcion_categoriatramite"},
    {"data": "fecha_creacion_categoriatramite"},    
    {"data": "actions", "orderable":false}
  ];  

  page = "cattramites";

}

/*=============================================
 Validamos tabla de tramites
=============================================*/ 

if($(".tableTramites").length > 0){

  var url = "ajax/data-tramites.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");
  
  var columns = [
    {"data": "id_tramite"},
    {"data": "actions", "orderable":false},
    {"data": "categoria_tramite"},
    {"data": "nombre_tramite"},  
    {"data": "logo"}, 
    {"data": "descripcion_tramite"},
    {"data": "visitas_tramite"},  
    {"data": "contenido_tramite"}, 
    {"data": "fecha_creacion_tramite"},  
    {"data": "fecha_actualizacion_tramite"} 
   
  ];  

  page = "tramites";

}


/*=============================================
Ejecutamos DataTable
=============================================*/ 

  var adminsTable = $("#adminsTable").DataTable({

    "responsive": true, 
    "lengthChange": true, 
    "aLengthMenu":[[10, 50, 100, 500, 1000],[10, 50, 100, 500, 1000]],
    "autoWidth": false,
    "processing":true,
    "serverSide": true,
    "order":[[0,"desc"]],
    "ajax":{
      "url":url,
      "type":"POST"
    },
    "columns":columns,
     "language": {

       "sProcessing":     "Procesando...",
    //   "sLengthMenu":     "Mostrar _MENU_ registros",
    //   "sZeroRecords":    "No se encontraron resultados",
    //   "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
       "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
       "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    //   "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
    //   "sUrl":            "",
    //   "sInfoThousands":  ",",
    //   "sLoadingRecords": "Cargando...",
    //   "oPaginate": {
    //     "sFirst":    "Primero",
    //     "sLast":     "Último",
      //   "sNext":     "Siguiente",
      //  "sPrevious": "Anterior",
    //   },
    //   "oAria": {
    //     "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
    //     "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    //   }

     },

    "buttons": [

      { extend:"copy",className:"btn-dark"},
      { extend:"csv",className:"btn-dark"},
      { extend:"excel",className:"btn-dark"},
      { extend:"pdf",className:"btn-dark",orientation:"landscape"},
      { extend:"print",className:"btn-dark"},
      { extend:"colvis",className:"btn-dark"}

    ],
    fnDrawCallback:function(oSettings){
      if(oSettings.aoData.length == 0){
          $('.dataTables_paginate').hide();
          $('.dataTables_info').hide();
      }

    }
  })

  

  if(text == "flat"){

    $("#adminsTable").on("draw.dt", function(){

      setTimeout(function(){
    
         adminsTable.buttons().container().appendTo('#adminsTable_wrapper .col-md-6:eq(0)');  

      },100)

    })

  }

};

execDatatable("html");

/*=============================================
Ejecutar reporte 
=============================================*/

function reportActive(event){
  
  if(event.target.checked){

    $("#adminsTable").dataTable().fnClearTable();
    $("#adminsTable").dataTable().fnDestroy();

    setTimeout(function(){

      execDatatable("flat");

    },100)

  }else{

    $("#adminsTable").dataTable().fnClearTable();
    $("#adminsTable").dataTable().fnDestroy();

    setTimeout(function(){

      execDatatable("html");

     },100)
  }

}


/*=============================================
Rango de fechas
=============================================*/

$('#daterange-btn').daterangepicker(
  {
    // "locale": {
    //   "format": "YYYY-MM-DD",
    //   "separator": " - ",
    //   "applyLabel": "Aplicar",
    //   "cancelLabel": "Cancelar",
    //   "fromLabel": "Desde",
    //   "toLabel": "Hasta",
    //   "customRangeLabel": "Rango Personalizado",
    //   "daysOfWeek": [
    //       "Do",
    //       "Lu",
    //       "Ma",
    //       "Mi",
    //       "Ju",
    //       "Vi",
    //       "Sa"
    //   ],
    //   "monthNames": [
    //       "Enero",
    //       "Febrero",
    //       "Marzo",
    //       "Abril",
    //       "Mayo",
    //       "Junio",
    //       "Julio",
    //       "Agosto",
    //       "Septiembre",
    //       "Octubre",
    //       "Noviembre",
    //       "Diciembre"
    //   ],
    //   "firstDay": 1
    // },
    // ranges   : {
    //   'Hoy'       : [moment(), moment()],
    //   'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    //   'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
    //   'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
    //   'Este Mes'  : [moment().startOf('month'), moment().endOf('month')],
    //   'Último Mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
    //   'Este Año': [moment().startOf('year'), moment().endOf('year')],
    //   'Último Año'  : [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
    // },
    ranges   : {
      'Today'       : [moment(), moment()],
      'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month'  : [moment().startOf('month'), moment().endOf('month')],
      'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
      'This Year': [moment().startOf('year'), moment().endOf('year')],
      'last Year'  : [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
    },

    startDate: moment($("#between1").val()),
    endDate  : moment($("#between2").val())
  },
  function (start, end) {

    window.location = page+"?start="+start.format('YYYY-MM-DD')+"&end="+end.format('YYYY-MM-DD');
  },


)



/*=============================================
Eliminar registro
=============================================*/

$(document).on("click",".removeItem",function(){

    var idItem = $(this).attr("idItem");
    var table = $(this).attr("table");
    var suffix = $(this).attr("suffix");
    var deleteFile = $(this).attr("deleteFile");
    var page = $(this).attr("page");
    
    


    fncSweetAlert("confirm","Desea eliminar el registro ?","").then(resp=>{

      if(resp){

        var data = new FormData();
        data.append("idItem", idItem);
        data.append("table", table);
        data.append("suffix", suffix);
        data.append("token", localStorage.getItem("token_user"));
        data.append("deleteFile", deleteFile);

        $.ajax({  

          url: "ajax/ajax-delete.php",
          method: "POST",
          data: data,
          contentType: false,
          cache: false,
          processData: false,
          success: function (response){   

           if(response == 200){

                fncSweetAlert(
                  "success",
                  "Registro eliminado con exito",
                  "/"+page
                );

            }else if(response == "no-delete"){

              fncSweetAlert(
                "error",
                "El registro tiene datos relacionados.",
                "/"+page
              );

            }else{

              fncNotie(3, "Error eliminando el registro");

            }

          }

        })

      }

    })

})

/*=============================================
Eliminar registro noticias
=============================================*/

$(document).on("click",".removeNoti",function(){

    var idItem = $(this).attr("idItem");
    var table = $(this).attr("table");
    var suffix = $(this).attr("suffix");
    var deleteFile = $(this).attr("deleteFile");
    var page = $(this).attr("page");
    
    


    fncSweetAlert("confirm","Desea eliminar el registro ?","").then(resp=>{

      if(resp){

        var data = new FormData();
        data.append("idItem", idItem);
        data.append("table", table);
        data.append("suffix", suffix);
        data.append("token", localStorage.getItem("token_user"));
        data.append("deleteFile", deleteFile);

        $.ajax({  

          url: "ajax/ajax-deletenoti.php",
          method: "POST",
          data: data,
          contentType: false,
          cache: false,
          processData: false,
          success: function (response){   

           if(response == 200){

                fncSweetAlert(
                  "success",
                  "Registro eliminado con exito",
                  "/"+page
                );

            }else if(response == "no-delete"){

              fncSweetAlert(
                "error",
                "El registro tiene datos relacionados.",
                "/"+page
              );

            }else{

              fncNotie(3, "Error eliminando el registro");

            }

          }

        })

      }

    })

})

/*=============================================
Eliminar registro cursos
=============================================*/

$(document).on("click",".removeCur",function(){

    var idItem = $(this).attr("idItem");
    var table = $(this).attr("table");
    var suffix = $(this).attr("suffix");
    var deleteFile = $(this).attr("deleteFile");
    var page = $(this).attr("page");
    
    


    fncSweetAlert("confirm","Desea eliminar el registro ?","").then(resp=>{

      if(resp){

        var data = new FormData();
        data.append("idItem", idItem);
        data.append("table", table);
        data.append("suffix", suffix);
        data.append("token", localStorage.getItem("token_user"));
        data.append("deleteFile", deleteFile);

        $.ajax({  

          url: "ajax/ajax-deletecur.php",
          method: "POST",
          data: data,
          contentType: false,
          cache: false,
          processData: false,
          success: function (response){   

           if(response == 200){

                fncSweetAlert(
                  "success",
                  "Registro eliminado con exito",
                  "/"+page
                );

            }else if(response == "no-delete"){

              fncSweetAlert(
                "error",
                "El registro tiene datos relacionados.",
                "/"+page
              );

            }else{

              fncNotie(3, "Error eliminando el registro");

            }

          }

        })

      }

    })

})
/*=============================================
Eliminar registro tramites
=============================================*/

$(document).on("click",".eliminar",function(){

    var idItem = $(this).attr("idItem");
    var table = $(this).attr("table");
    var suffix = $(this).attr("suffix");
    var deleteFile = $(this).attr("deleteFile");
    var page = $(this).attr("page");
    
    


    fncSweetAlert("confirm","Desea eliminar el registro ?","").then(resp=>{

      if(resp){

        var data = new FormData();
        data.append("idItem", idItem);
        data.append("table", table);
        data.append("suffix", suffix);
        data.append("token", localStorage.getItem("token_user"));
        data.append("deleteFile", deleteFile);

        $.ajax({  

          url: "ajax/ajax-eliminar.php",
          method: "POST",
          data: data,
          contentType: false,
          cache: false,
          processData: false,
          success: function (response){   

           if(response == 200){

                fncSweetAlert(
                  "success",
                  "Registro eliminado con exito",
                  "/"+page
                );

            }else if(response == "no-delete"){

              fncSweetAlert(
                "error",
                "El registro tiene datos relacionados.",
                "/"+page
              );

            }else{

              fncNotie(3, "Error eliminando el registro");

            }

          }

        })

      }

    })

})

/*=============================================
Cambiar estado del producto
=============================================*/

function changeState(event, idProduct){
  
  if(event.target.checked){

    var state = "show";

  }else{

    var state = "hidden";    
   
  }


  var data = new FormData();
  data.append("state", state);
  data.append("idProduct", idProduct);
  data.append("token", localStorage.getItem("token_user"));


  $.ajax({
    url: "ajax/ajax-state.php",
    method: "POST",
    data: data,
    contentType: false,
    cache: false,
    processData: false,
    success: function(response){

       if(response == 200){
      
         fncNotie(1, "the record was updated");

       }else{

           fncNotie(3, "Error updating registry");
       }

    }

  })

}

/*=============================================
Feedback
=============================================*/

$(document).on("click",".feedback", function(){

  var  idProduct = $(this).attr("idProduct");
  var  approval = $(this).attr("approval");

  $("[name='idProduct']").val(idProduct);

  if(approval == "approved"){

     $("#approval_product").prop("checked",true);

  }else{

    $("#approval_product").prop("checked",false);
  }

  $("#myFeedback").modal();

})

/*=============================================
Función para actualizar la orden
=============================================*/

$(document).on("click", ".nextProcess", function(){

  /*=============================================
  Limpiamos la ventana modal
  =============================================*/

  $(".orderBody").html("");

  var idOrder = $(this).attr("idOrder");
  var processOrder = JSON.parse(atob($(this).attr("processOrder")));
  

  /*=============================================
  Nombramos la ventana modal con el id de la orden
  =============================================*/

  $(".modal-title span").html("Order N. "+idOrder);

  /*=============================================
   Quitamos la opción de llenar el campo de recibido si no se ha enviado el producto
  =============================================*/

   if(processOrder[1].status == "pending"){

      processOrder.splice(2,1); 

   }

  /*=============================================
  Información dinámica que aparecerá en la ventana modal
  =============================================*/

  processOrder.forEach((value,index)=>{

    let date = "";
    let status = "";
    let comment = "";

    if(value.status == "ok"){

      date = `<div class="col-10 p-3">
          
              <input type="date" class="form-control" value="`+value.date+`" readonly>

          </div>`;

      status = `<div class="col-10 mt-1 p-3">

                <div class="text-uppercase">`+value.status+`</div>

              </div>`;

      comment = `<div class="col-10 p-3">   
                <textarea class="form-control" readonly>`+value.comment+`</textarea>
            </div>`;

    }else{

       date = `<div class="col-10 p-3">
          
              <input type="date" class="form-control" name="date" value="`+value.date+`" required>

          </div>`;


        status = `<div class="col-10 mt-1 p-3">

                    <input type="hidden" name="stage" value="`+value.stage+`">
                    <input type="hidden" name="processOrder" value="`+$(this).attr("processOrder")+`">
                    <input type="hidden" name="idOrder" value="`+idOrder+`">
                    <input type="hidden" name="clientOrder" value="`+$(this).attr("clientOrder")+`">
                    <input type="hidden" name="emailOrder" value="`+$(this).attr("emailOrder")+`">
                    <input type="hidden" name="productOrder" value="`+$(this).attr("productOrder")+`">

                    <div class="custom-control custom-radio custom-control-inline">

                      <input 
                          id="status-pending" 
                          type="radio" 
                          class="custom-control-input" 
                          value="pending" 
                          name="status" 
                          checked>

                          <label  class="custom-control-label" for="status-pending">Pending</label>

                    </div>

                    <div class="custom-control custom-radio custom-control-inline">

                      <input 
                          id="status-ok" 
                          type="radio" 
                          class="custom-control-input" 
                          value="ok" 
                          name="status" 
                          >

                          <label  class="custom-control-label" for="status-ok">Ok</label>

                    </div>

        </div>`;

         comment = `<div class="col-10 p-3">   
                <textarea class="form-control" name="comment" required>`+value.comment+`</textarea>
            </div>`;

    }


     $(".orderBody").append(`

       <div class="card-header text-uppercase">`+value.stage+`</div> 

       <div class="card-body">
          
          <!--=====================================
          Bloque Fecha
          ======================================-->

          <div class="form-row">

            <div class="col-2 text-right">

                <label class="p-3 lead">Date:</label>

            </div>

            `+date+`

          </div>

          <!--=====================================
          Bloque Status
          ======================================-->

          <div class="form-row">
                        
            <div class="col-2 text-right">
                <label class="p-3 lead">Status:</label>
            </div>

            `+status+`

          </div> 

          <!--=====================================
            Bloque Comentarios
          ======================================-->

          <div class="form-row">

            <div class="col-2 text-right">
                <label class="p-3 lead">Comment:</label>
            </div>

            `+comment+`

          </div>

        </div>
     

    `)

  })

  $("#nextProcess").modal()


})

/*=============================================
Función para responder disputa
=============================================*/

$(document).on("click", ".answerDispute", function(){

    $("[name='idDispute']").val($(this).attr("idDispute"));
    $("[name='clientDispute']").val($(this).attr("clientDispute"));
    $("[name='emailDispute']").val($(this).attr("emailDispute"));
    
   /*=============================================
    Aparecemos la ventana Modal
    =============================================*/

    $("#answerDispute").modal()

})

/*=============================================
Función para responder mensaje
=============================================*/

$(document).on("click", ".answerMessage", function(){

    $("[name='idMessage']").val($(this).attr("idMessage"));
    $("[name='clientMessage']").val($(this).attr("clientMessage"));
    $("[name='emailMessage']").val($(this).attr("emailMessage"));
    $("[name='urlProduct']").val($(this).attr("urlProduct"));

     /*=============================================
    Aparecemos la ventana Modal
    =============================================*/

    $("#answerMessage").modal()

})

