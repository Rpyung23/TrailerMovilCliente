const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");
const formIniciarSesion = document.getElementById("formIniciarSesion")

getDataClient();

sign_up_btn.addEventListener("click", () => {
   container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
   container.classList.remove("sign-up-mode");
});

formIniciarSesion.addEventListener('submit', async e => {
   e.preventDefault();
   const url = "https://rest.roman-company.com/view/login.php";
   const data = {
      codigo: "cliente",
      email: formIniciarSesion.email_login.value,
      pass: formIniciarSesion.pass_login.value,
   }
   try {
      const request = await fetch(url, {
         method: "POST",
         body: JSON.stringify(data),
         headers: {
            'Content-Type': 'application/json'
         }
      })
      const response = await request.json();
      console.log(response)
      if (response.status == 200) {
         sendDataRest(response.datos)
      } else {
         Swal.fire(
            'Oppss!',
            'El usuario o la contraseña no son correctas',
            'error'
         )
      }
   } catch (error) {
      console.log("ERROR INDEX.JS")
      console.log(error);
   } finally {
      formIniciarSesion.reset();
   }
});

async function sendDataRest(data) {
   const request = await fetch("./rest/session.php", {
      method: "POST",
      body: JSON.stringify(data),
      headers: {
         'Content-Type': 'application/json'
      }
   });
   const response = await request.json();
   if (response.status == 200) {
      location.href = "index.php";
   } else {
      Swal.fire(
         'Oppss!',
         'Hubo un error interno, intentalo de nuevo',
         'error'
      )
   }
}



function getDataClient() {
   const regis_form = document.getElementById("r_formulario");
   const btn_log = document.getElementById("sign-in-btn");
   if (!regis_form) return;

   regis_form.addEventListener("submit", e => {
      e.preventDefault();
      const datos = {
         nombres: regis_form.r_name.value,
         email: regis_form.r_email.value,
         password: regis_form.r_password.value,
         telefono: regis_form.r_tel.value,
         direccion: "",
         foto: "",
         dni_ruc: "",
      }
      clientRegister(datos);
      regis_form.reset();
      btn_log.click();
   });
}

