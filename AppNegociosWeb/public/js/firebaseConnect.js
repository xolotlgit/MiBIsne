// var claves = {};

// var connectionKeys = () => {
//     $.ajax({
//         type: "POST",
//         url: "/claves",
//         dataType: "JSON",
//         headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
//         success: function (response) {
//             claves = response;            
//         },
//         error: function(e){
//             console.error(e);
//         }
//     });
// };
// Llaves para la cuenta de firebase
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyC6-x5bt2f74G90AWh4e4Dp0ehyx6kFF_8",
    authDomain: "dbconsultoriomedico.firebaseapp.com",
    databaseURL: "https://dbconsultoriomedico.firebaseio.com",
    projectId: "dbconsultoriomedico",
    storageBucket: "dbconsultoriomedico.appspot.com",
    messagingSenderId: "843768304221"
  };
  firebase.initializeApp(config);
