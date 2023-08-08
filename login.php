<?php
session_start();
if (isset($_SESSION["session_trailer_cliente"])) {
   if ($_SESSION["session_trailer_cliente"] == "active") {
      header("location: index.php");
   }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="./css/login_styles.css" />

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
   <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>

    <title>Iniciar Sesión</title>
</head>

<body>
   <div class="container">
      <div class="forms-container">
         <div class="signin-signup">
            <!-- form iniciar -->
            <form id="formIniciarSesion" class="sign-in-form" autocomplete="off">
               <h2 class="title">Iniciar Sesión </h2>
               <div class="input-field">
                  <i class="fas fa-envelope"></i>
                  <input type="email" id="email_login" required placeholder="Email" autocomplete="off" />
               </div>
               <div class="input-field">
                  <i class="fas fa-lock"></i>
                  <input type="password" id="pass_login" required placeholder="Contraseña" autocomplete="off" />
               </div>
               <input type="submit" value="Iniciar Sesión" class="btn solid" />
            </form>




            <!-- form registrar -->
            <form class="sign-up-form" id="r_formulario" autocomplete="off">
               <h2 class="title">Registrate</h2>
               <div class="input-field">
                  <i class="fas fa-user"></i>
                  <input id="r_name" type="text" placeholder="Nombres" autocomplete="off" pattern="[a-zA-Z ]{2,254}" required />
               </div>
               <div class="input-field">
                  <i class="fas fa-envelope"></i>
                  <input id="r_email" type="email" placeholder="Email" autocomplete="off" required />
               </div>
               <div class="input-field">
                  <i class="fas fa-lock"></i>
                  <input id="r_password" type="password" autocomplete="off" placeholder="Contraseña" required />
               </div>
               <div class="input-field">
                  <input id="r_tel" style="height: 100%" type="tel" name="phone" autocomplete="off" pattern="[0-9]{10}" required />
               </div>
               <input id="id_btn_register" disabled type="button" class="btn" value="Registrarse" />
            </form>




         </div>
      </div>

      <div class="panels-container">
         <div class="panel left-panel">
            <div class="content">
               <div class="ctn-imagen-login">
                  <img src="./img/logo-text.png" alt="">
               </div>
               <h3>Eres nuevo?</h3>
               <p>
                  Registrate en nuestra página para obtener más información acerca de los eventos que te podemos ofrecer
               </p>
               <button class="btn transparent" id="sign-up-btn">
                  Registrarse
               </button>
            </div>
         </div>
         <div class="panel right-panel">
            <div class="content">
               <div class="ctn-imagen-login">
                  <img src="./img/logo-text.png" alt="">
               </div>
               <h3>Ya tienes cuenta?</h3>
               <p>
                  Inicia sesión en nuestra página para obtener más información acerca de los eventos que te podemos ofrecer
               </p>
               <button class="btn transparent" id="sign-in-btn">
                  Iniciar Sesión
               </button>
            </div>
         </div>
      </div>
   </div>
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="./js/index.js"></script>

   <script>

       var inputTelefono = document.querySelector("#r_tel");
       var id_btn_register = document.getElementById("id_btn_register")

       const iti = window.intlTelInput(inputTelefono, {
           onlyCountries: ["ec", "mx", "es", "co","pe","ar"],
           utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
       });


       function getPhoneNumber() {
           var inputElement = document.getElementById("r_tel");
           var intlTelInput = window.intlTelInputGlobals.getInstance(inputElement);
           var phoneNumber = intlTelInput.getNumber(); // Obtiene el número completo con el código de país
           var countryCode = intlTelInput.getSelectedCountryData().iso2; // Obtiene el código de país

           console.log("Número completo: " + phoneNumber);
           console.log("Código de país: " + countryCode);

           return phoneNumber
       }



       // on blur: validate
       inputTelefono.addEventListener('blur', () => {

           if (inputTelefono.value.trim()) {
               if (iti.isValidNumber()) {
                   console.log(iti)
                   document.getElementById("id_btn_register").disabled = false;
                   getPhoneNumber()
                   //alert("NUMERO VALIDO")
               } else {
                   const Toast = Swal.mixin({
                       toast: true,
                       position: 'top-end',
                       showConfirmButton: false,
                       timer: 3000,
                       timerProgressBar: true,
                       didOpen: (toast) => {
                           toast.addEventListener('mouseenter', Swal.stopTimer)
                           toast.addEventListener('mouseleave', Swal.resumeTimer)
                       }
                   })
                   Toast.fire({
                       icon: 'warning',
                       title: 'Número no válido'
                   })
               }
           }
       });

       id_btn_register.addEventListener('click',()=>{
           clientRegister()
       })

       function clientRegister()
       {
           if(document.getElementById("r_name").value == "" ||
               document.getElementById("r_email").value == ""  ||
               document.getElementById("r_password").value == "" )
           {
               let Toast = Swal.mixin({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 3000,
                   timerProgressBar: true,
                   didOpen: (toast) => {
                       toast.addEventListener('mouseenter', Swal.stopTimer)
                       toast.addEventListener('mouseleave', Swal.resumeTimer)
                   }
               })
               Toast.fire({
                   icon: 'warning',
                   title: 'No pueden existir datos vacíos.!'
               })
               return
           }

           var obj_client = {
               nombres: document.getElementById("r_name").value,
               email: document.getElementById("r_email").value,
               password: document.getElementById("r_password").value,
               telefono: getPhoneNumber(),
               direccion: "",
               foto: "",
               dni_ruc: ""
           }
           console.log(obj_client)
           url = "https://rest.roman-company.com/view/cliente.php";
           fetch(url, {
               method: 'POST',
               body: JSON.stringify(obj_client),
               headers: {
                   'Content-Type': 'application/json'
               }
           })
               .then(res => res.json())
               .then(response => {
                   const Toast = Swal.mixin({
                       toast: true,
                       position: 'top-end',
                       showConfirmButton: false,
                       timer: 3000,
                       timerProgressBar: true,
                       didOpen: (toast) => {
                           toast.addEventListener('mouseenter', Swal.stopTimer)
                           toast.addEventListener('mouseleave', Swal.resumeTimer)
                       }
                   })

                   Toast.fire({
                       icon: 'success',
                       title: 'Registrado con Éxito'
                   })

                   document.getElementById("r_formulario").reset();
                   document.getElementById("sign-in-btn").click()
                   document.getElementById("id_btn_register").disabled = true
               })
               .catch(console.log);
       }


   </script>
</body>

</html>