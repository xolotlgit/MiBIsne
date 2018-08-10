// metodo para inciar sesión con firebase
var signInAccount = () => {
    firebase.auth().signInWithEmailAndPassword($("#email").val(), $("#password").val()).catch(function(error) {
        let errorCode = error.code;
        let errorMessage = error.message;
        console.warn(errorMessage);
    });
};
var signOutAccount = () => {
    if (firebase.auth().currentUser) {
        firebase.auth().signOut();       
    }
};


$('#salirCuenta').click(function () { signOutAccount() });
$('#logearCuenta').click(function () { signInAccount() });