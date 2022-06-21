  var ruta_ = $('#txtruta').val();
  var sis_id = $('#sis_id').val();

  const login = () => {
    const config = {
      auth: {
        clientId: 'a8878676-4b9b-4490-9dd7-522b41867735',
        redirectUri: ruta_,
        postLogoutRedirectUri: ruta_,
      },
    }

    const loginRequest = {
      scopes: ['User.ReadWrite'],
    }

    const myMsal = new Msal.UserAgentApplication(config)

    myMsal
      .loginPopup(loginRequest)
      .then( async function  (loginResponse) {
        //login success
        const {name,userName} = myMsal.account;
        console.log(userName)
        $.ajax({
          type: 'POST',
          url: "controller/usuario.php?op=login",
          data: {usu_correo: userName,sis_id:sis_id},
          success: function( data ) {
            console.log(data);
            window.location.assign(ruta_+"/view/Home");
          }
      });
      })
      .catch(function (error) {
        console.log(error,'error al iniciar sesion')
      })
  }

   const logout = () => {
    const config = {
      auth: {
        clientId: 'a8878676-4b9b-4490-9dd7-522b41867735',
        redirectUri: ruta_, //defaults to application start page
        postLogoutRedirectUri: ruta_,
      },
    }

    const loginRequest = {
      scopes: ['User.ReadWrite'],
    }

    const myMsal = new Msal.UserAgentApplication(config)

    myMsal.logout();

  }