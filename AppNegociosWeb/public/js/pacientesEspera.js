var database = firebase.database();

var generarHTML = (key, paciente) => {
    var identi = paciente.val().identificador;
    let item = `<li style="opacity: 0;"  id="${paciente.key}" ><div onclick="Cambios(this.id); $('#secciones').collapsible('open', 0);" id="${paciente.val().identificador}" class="collapsible-header waves-effect waves-green"><i class="fa fa-user indigo-text" aria-hidden="true"></i> ${paciente.val().nombre} <br> ${paciente.val().curp} <br> &#9673; ${paciente.val().localidad} </div></li>`;
    $('ul#listaNombres').append(item);
    // Materialize.showStaggeredList('#listaNombres');
};

var removerHTML = (key) => {
    $('ul#listaNombres').find(`li#${key}`).each(function(){
        $(this).remove();
    });
};

var actualizarHTML = (key, paciente) => {
    $('ul#listaNombres').find(`li#${key}`).each(function(){
        // Mostrar los nuevos campos
        $(this).html(`<li style="opacity: 0;" onclick="Cambio();" id="${paciente.key}" data-id="${paciente.val().identificador}"><div class="collapsible-header waves-effect waves-green"><i class="fa fa-user indigo-text" aria-hidden="true"></i> ${paciente.val().nombre} <br> ${paciente.val().curp} <br> &#9673; ${paciente.val().localidad} </div></li>`);
        // Materialize.showStaggeredList('#listaNombres');
    });
};

var ObtenerDatos = () => {
    let pacientes = database.ref('pacientes');
    
    //listening encargado de agregar items en pantalla
    pacientes.on("child_added", function(paciente){
        generarHTML(paciente.key, paciente);
        Materialize.showStaggeredList('#listaNombres');
    });
    //listening encargado de eliminar items en pantalla
    pacientes.on("child_removed", function(paciente){
       removerHTML(paciente.key);
    });
    // Listening encargado de mostrar los cambios en los items
    pacientes.on("child_changed", function(paciente){
        actualizarHTML(paciente.key, paciente);
        Materialize.showStaggeredList('#listaNombres');
    });
    
};

var guardarFirebase = () => {
    database.ref('pacientes').push({
        nombre: $('input#first_name').val(),
        curp: $('input#curp').val(),
        localidad: $('input#localidad').val()
    }).then(function () {
        Materialize.toast($('input#first_name').val() + ' guardado correctamente', 4000);
        $('input#first_name').val('');
    }).catch(function (e) {
        Materialize.toast('los datos no pudieron ser guardados ' + e, 4000);
    });
};

$(function () { 
    listeningFirebase();
    ObtenerDatos();
    Materialize.showStaggeredList('#listaNombres');
});

$('div#guardarUsuario').click(function () { guardarFirebase(); });