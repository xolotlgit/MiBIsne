var database = firebase.database();

var guardarFirebase = (identificador) => {
    database.ref('pacientes').push({
        nombre: $('input#nombre').val(),
        curp: $('input#curp').val(),
        localidad: $('input#loc').val(),
        identificador: identificador
    }).then(function () {
        Materialize.toast('Guardado correctamente', 4000);
    }).catch(function (e) {
        Materialize.toast('los datos no pudieron ser guardados ' + e, 4000);
    });
};

