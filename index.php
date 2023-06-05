<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <base href="">
    <title>Prueba de diagnóstico</title>
    <link rel="stylesheet" href="statics/plugins/izitoast/iziToast.min.css">
    <link rel="stylesheet" href="statics/plugins/semantic/semantic.min.css">
    <link rel="stylesheet" href="statics/css/style.css">
</head>

<body>
    <form enctype="multipart/form-data" class="ui form" action="<?= 'AppController.php'; ?>">
        <h1>FORMULARIO DE VOTACIÓN</h1>
        <br><br>

        <div class="fields two">
            <div class="field">
                <label>Nombre y apellido</label>
                <input type="text" name="names" required>
            </div>
            <br>
            <div class="field">
                <label>Alias</label>
                <input type="text" name="alias" pattern="^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9]{5,}$" required>
            </div>
        </div>
        <br>

        <div class="fields two">
            <div class="field">
                <label>RUT</label>
                <input type="text" name="rut" pattern="\d+-\d$" required>
            </div>
            <br>
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}" required>
            </div>
        </div>
        <br>
        <div class="fields two">
            <div class="field">
                <label>Región</label>
                <select name="region" customized-required class="ui dropdown"> </select>
            </div>
            <br>
            <div class="field">
                <label>Comuna</label>
                <select name="commune" customized-required class="ui dropdown"> </select>
            </div>
        </div>
        <br>

        <div class="field">
            <label>Candidato</label>
            <select name="candidate" customized-required class="ui dropdown"> </select>
        </div>
        <br>

        <div class="field">
            <label>Como se enteró de nosotros?</label>
            <div class="inline fields">
                <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" name="meet[web]" value="WEB">
                        <label>WEB</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" name="meet[tv]" value="TV">
                        <label>TV</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" name="meet[socialNetworks]" value="Redes sociales">
                        <label>Redes sociales</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" name="meet[friend]" value="Amigo">
                        <label>Amigo</label>
                    </div>
                </div>
            </div>
        </div>
        <br><br>

        <button class="ui button fluid large blue">Votar</button>

    </form>
</body>

<script src="statics/plugins/jquery/jquery-3.5.1.min.js"></script>
<script src="statics/plugins/semantic/semantic.min.js"></script>
<script src="statics/plugins/izitoast/iziToast.min.js"></script>
<script src="statics/js/main.js"></script>

</html>