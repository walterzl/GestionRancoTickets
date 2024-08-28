<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
  require_once("../../config/conexion.php");
  if(isset($_SESSION["usu_id"])){
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>

	<meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
	
	<title>Ranco::Flujo Aprobacion Compra</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>

    <?php require_once("../MainNav/nav.php");?>

	<div class="page-content">
		<div class="container-fluid">

			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Flujo Aprobacion Compra - <?php echo $_SESSION["sis_nom"] ?></h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="..\Home\">Home</a></li>
								<li class="active">Flujo Aprobacion Compra</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<form method="post" id="purchaseForm">
				<div class="box-typical box-typical-padding">
				

					<h5 class="m-t-lg with-border">Formulario de Compra</h5>

					<div class="row">

						<input type="hidden" id="usu_id" name="usu_id" value="<?php echo $_SESSION["usu_id"] ?>">
						<input type="hidden" id="area_id" name="area_id" value="<?php echo $_SESSION["area_id"] ?>">
						<input type="hidden" id="suba_id" name="suba_id" value="<?php echo $_SESSION["suba_id"] ?>">
                        

						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label semibold" for="tick_titulo">Ingrese su Rut*</label>
								<input type="text" class="form-control" id="rut" name="rut" placeholder="Ingrese su Rut" required>
							</fieldset>
						</div>

                        <div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label semibold" for="compra">¿Qué necesitas comprar?*</label>
								<input type="text" class="form-control" id="compra" name="compra" placeholder="¿Qué necesitas comprar?" required>
							</fieldset>
						</div>

						<div id="loading-message1" style="display: none; text-align: center; font-style: italic; font-weight: bold;" type="hidden">Cargando...</div>

						<div id="loading-message2" style="display: none; text-align: center; font-style: italic; font-weight: bold;" type="hidden">Problema en la conexion, por favor verifique y vuelva a cargar la web</div>

						<div class="col-lg-12 text-center text-center" text-center>
							<button type="submit" name="action" value="add" class="btn btn-rounded btn-inline btn-primary">Enviar</button>
						</div>

					</div>
				</div>
			</form>

            <div class="col-lg-12">
                <fieldset class="form-group">
                 
                    <table id="flujo_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>item Compra</th>
                            <th>nombre Solicitante</th>
                            <th>correo Solicitante</th>
                            <th>nombre Jefatura</th>
                            <th>correo Jefatura</th>
                            <th>Fecha Respuesta</th>
                            <th>Estado Respuesta</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </fieldset>
            </div>
		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("../MainJs/js.php");?>

	<script type="text/javascript">
         /* // Aplicar la máscara al campo RUT
        document.getElementById('rut').addEventListener('input', function (e) {
            let value = e.target.value;
            value = value.replace(/[.-]/g, ''); // Eliminar puntos y guiones
            if (value.length > 10) {
                value = value.substring(0, 10); // Limitar a 10 caracteres
            }
            e.target.value = value; // Asignar el valor modificado al input
        });

        document.getElementById('purchaseForm').addEventListener('submit', async function(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto del formulario

            // Obtener los valores de los campos del formulario
            const rut = document.getElementById('rut').value;
            const compra = document.getElementById('compra').value;
            //const emailSolicitante = "ldroguett@ranco.cl";

            // Configurar la URL del disparador HTTP de Power Automate
            const endpoint = 'https://prod-02.westus.logic.azure.com:443/workflows/4036ea286bb242fd93fb2d43b77b5b06/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=fpM1_vfIa1-CRlnGrx1Z5LN0FqQK0pHW0rcjooYXFIc';

            try {
                // Enviar los datos al flujo de Power Automate
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        rut:rut,
                        compra: compra,
                        emailSolicitante: emailSolicitante
                    })
                });

                // Verificar si la respuesta es exitosa
                if (!response.ok) {
                    throw new Error('Error en la solicitud: ' + response.statusText);
                }

                // Verificar si la respuesta tiene contenido
                const responseText = await response.text();
                console.log('Respuesta cruda del flujo:', responseText);

                // Intentar analizar la respuesta como JSON
                let responseData = {};
                try {
                    responseData = JSON.parse(responseText);
                } catch (jsonError) {
                    console.warn('No se pudo analizar la respuesta como JSON:', jsonError);
                }

                // Procesar la respuesta del flujo (opcional)
                console.log('Respuesta del flujo:', responseData);

                // Informar al usuario que el envío fue exitoso
                alert('Formulario enviado correctamente.');
            } catch (error) {
                console.error('Error al enviar el formulario:', error);
                alert('Hubo un problema al enviar el formulario.');
            }
        });document.getElementById('purchaseForm').addEventListener('submit', async function(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto del formulario

            // Obtener los valores de los campos del formulario
            const rut = document.getElementById('rut').value;
            const compra = document.getElementById('compra').value;
            //const emailSolicitante = "ldroguett@ranco.cl";

            // Configurar la URL del disparador HTTP de Power Automate
            const endpoint = 'https://prod-02.westus.logic.azure.com:443/workflows/4036ea286bb242fd93fb2d43b77b5b06/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=fpM1_vfIa1-CRlnGrx1Z5LN0FqQK0pHW0rcjooYXFIc';

            try {
                // Enviar los datos al flujo de Power Automate
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        rut:rut,
                        compra: compra,
                        emailSolicitante: emailSolicitante
                    })
                });

                // Verificar si la respuesta es exitosa
                if (!response.ok) {
                    throw new Error('Error en la solicitud: ' + response.statusText);
                }

                // Verificar si la respuesta tiene contenido
                const responseText = await response.text();
                console.log('Respuesta cruda del flujo:', responseText);

                // Intentar analizar la respuesta como JSON
                let responseData = {};
                try {
                    responseData = JSON.parse(responseText);
                } catch (jsonError) {
                    console.warn('No se pudo analizar la respuesta como JSON:', jsonError);
                }

                // Procesar la respuesta del flujo (opcional)
                console.log('Respuesta del flujo:', responseData);

                // Informar al usuario que el envío fue exitoso
                alert('Formulario enviado correctamente.');
            } catch (error) {
                console.error('Error al enviar el formulario:', error);
                alert('Hubo un problema al enviar el formulario.');
            }
        }); */

        // Aplicar la máscara al campo RUT
    document.getElementById('rut').addEventListener('input', function (e) {
        let value = e.target.value;
        value = value.replace(/[.-]/g, ''); // Eliminar puntos y guiones
        if (value.length > 10) {
            value = value.substring(0, 10); // Limitar a 10 caracteres
        }
        e.target.value = value; // Asignar el valor modificado al input
    });

    document.getElementById('purchaseForm').addEventListener('submit', async function(event) {
        event.preventDefault(); // Prevenir el comportamiento por defecto del formulario

        // Mostrar mensaje de espera
        /* $("#loading-message1").show(); */
        // Deshabilitar el botón de envío
        $("#purchaseForm button[type='submit']").prop("disabled", true);

        // Obtener los valores de los campos del formulario
        const rut = document.getElementById('rut').value;
        const compra = document.getElementById('compra').value;

        // Configurar la URL del disparador HTTP de Power Automate
        const endpoint = 'https://prod-02.westus.logic.azure.com:443/workflows/4036ea286bb242fd93fb2d43b77b5b06/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=fpM1_vfIa1-CRlnGrx1Z5LN0FqQK0pHW0rcjooYXFIc';

        try {
            // Enviar los datos al flujo de Power Automate
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    rut: rut,
                    compra: compra,
                    // Agrega cualquier otro dato necesario aquí
                })
            });

            // Verificar si la respuesta es exitosa
            if (!response.ok) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }

            // Verificar si la respuesta tiene contenido
            const responseText = await response.text();
            console.log('Respuesta cruda del flujo:', responseText);

            // Intentar analizar la respuesta como JSON
            let responseData = {};
            try {
                responseData = JSON.parse(responseText);
            } catch (jsonError) {
                console.warn('No se pudo analizar la respuesta como JSON:', jsonError);
            }

            // Procesar la respuesta del flujo (opcional)
            console.log('Respuesta del flujo:', responseData);

            // Acciones después de enviar los datos exitosamente
            $('#rut').val('');
            $('#compra').summernote('reset');
            swal("Correcto!", "Formulario del Flujo enviado correctamente.\n", "success");

            swal({
                title: "Correcto!",
                text: "Formulario del Flujo enviado correctamente.\n\n",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Aceptar",
                closeOnConfirm: false,
            }, function(isConfirm) {
                if (isConfirm) {
                    window.open('../flujo/','_self');
                }
            });

        } catch (error) {
            console.error('Error al enviar el formulario:', error);
            alert('Hubo un problema al enviar el formulario.');
        } finally {
            // Habilitar el botón "submit" nuevamente después de mostrar el mensaje de éxito o error
            $("#purchaseForm button[type='submit']").prop("disabled", false);
            // Ocultar el mensaje de espera
            /* $("#loading-message1").hide(); */
        }
    });

    </script>

    <script type="text/javascript" src="flujo.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>