  const login = () => {
    const config = {
      auth: {
        clientId: "a8878676-4b9b-4490-9dd7-522b41867735",
        redirectUri: "https://testing.ticket.ranco.cl/GestionRanco/", 
        postLogoutRedirectUri: "https://testing.ticket.ranco.cl/GestionRanco/",
      },
    }

    const loginRequest = {
      scopes: ["User.ReadWrite"],
    }

    const myMsal = new Msal.UserAgentApplication(config)

    myMsal
      .loginPopup(loginRequest)
      .then( async function  (loginResponse) {
        //login success
        const {name,userName} = myMsal.account;
        $.ajax({
          type: "POST",
          url: "https://testing.ticket.ranco.cl/GestionRanco/models/Usuario.php",
          data: {
              usu_correo: userName
          },
          success: function( data ) {
              window.location.assign("https://testing.ticket.ranco.cl/GestionRanco/view/Home");
              //window.location.assign("https://testing.ticket.ranco.cl/gestionranco/models/Usuario.php");
          }
      });
      })
      .catch(function (error) {
        //login failure
        console.log(error,"error al iniciar sesion")
      })
  }

   const logout = () => {
    const config = {
      auth: {
        clientId: "a8878676-4b9b-4490-9dd7-522b41867735",
        redirectUri: "https://testing.ticket.ranco.cl/GestionRanco/", 
        postLogoutRedirectUri: "https://testing.ticket.ranco.cl/GestionRanco/",
      },
    }

    const loginRequest = {
      scopes: ["User.ReadWrite"],
    }

    const myMsal = new Msal.UserAgentApplication(config)

    myMsal.logout();
  
  }