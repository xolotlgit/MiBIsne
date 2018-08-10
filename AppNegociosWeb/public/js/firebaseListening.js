var listeningFirebase = () => {
    firebase.auth().onAuthStateChanged( function (user) {
        user ? Materialize.toast(user.email + ' logeado en firebase', 4000) : Materialize.toast('no se pudo establecer conección con firebase', 4000);
    });
};

$(document).ready(function () { listeningFirebase(); })

// var listeningFirebase = () => {
//     firebase.auth().onAuthStateChanged( function (user) {
//         user ? Materialize.toast(user.email + ' logeado en firebase', 4000) : Materialize.toast('no se pudo establecer conección con firebase', 4000);
//     });
// };
