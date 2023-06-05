window.addEventListener('load', function (e) {

    let selectorForm = 'form[action]'
    let form = $(selectorForm)
    let formAction = form.attr('action')

    form.submit(function (e) {
        e.preventDefault()
        if (selectValidate(selectorForm) === true) {
            ajaxProcess(selectorForm, formAction)
        }
    })

    //Select de semantic
    $('.ui.dropdown').dropdown();

    /**
     * AJAX
     * @param  {String} selectorForm
     * @param  {String} actionSelector
     */
    function ajaxProcess(selectorForm, actionSelector) {

        $.ajax({
            type: 'POST',
            url: actionSelector,
            data: new FormData(document.querySelector(selectorForm)),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (ajaxResponse) {
                //Variables de respuesta 
                let ajaxSuccess = ajaxResponse.success
                let ajaxMessage = ajaxResponse.message

                if (ajaxSuccess) {
                    iziToast.success({ timeout: 2000, icon: 'check icon', title: 'Prueba de diagnóstico', message: ajaxMessage });
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                } else {
                    iziToast.error({ timeout: 2000, icon: 'x icon', title: 'Prueba de diagnóstico', message: ajaxMessage });
                }

            },
            error: function () {
                iziToast.error({ timeout: 5000, icon: 'x icon', title: 'Prueba de diagnóstico', message: 'Ha ocurrido un error al conectar con el servidor' });
            }
        });
    }

    //──── CONFIGURACIÓN DE SELECTS (Filtrado) ────────────────────────────────────────────────────────────────────────────

    const regionSelect = $('select[name=region]');
    const communeSelect = $('select[name=commune]');
    const candidateSelect = $('select[name=candidate]');

    regionSelect.on('change', function () {

        $('select[name=commune] option').remove()
        $('select[name=candidate] option').remove()
        communeSelect.dropdown('clear');
        candidateSelect.dropdown('clear');
        communeSelect.append('<option selected value="">Comunas</option>');
        candidateSelect.append('<option selected value="">Candidatos</option>');

        let regionSelected = regionSelect.dropdown('get value');
        let queryString = '';

        if (regionSelected == null) {
            queryString = `region=0&commune=0&candidate=0`;
        } else {
            queryString = `region=${regionSelected}&commune=0&candidate=0`;
        }

        validateUbication(formAction + '?' + queryString, 'region');
    }).trigger("change");

    communeSelect.on('change', function () {

        $('select[name=candidate] option').remove()
        candidateSelect.dropdown('clear');
        candidateSelect.append('<option selected value="">Candidatos</option>');

        let regionSelected = regionSelect.dropdown('get value');
        let communeSelected = communeSelect.dropdown('get value');
        let queryString = '';

        if (communeSelected !== '') {
            queryString = `region=${regionSelected}&commune=${communeSelected}&candidate=0`;
        }

        validateUbication(formAction + '?' + queryString, 'commune');
    });

    function validateUbication(urlToExtract, toUpdate) {
        $.ajax({
            url: urlToExtract,
            'dataType': "json",
            success: function (response) {

                let regionResponse = response.regionResponse
                let communeResponse = response.communeResponse
                let candidateResponse = response.candidateResponse

                //Si viene como undefined es porque fue automatico, si viene con datos es porque fue manual
                if (toUpdate == 'region' && regionResponse !== undefined) {
                    $.each(regionResponse, function (key, value) {
                        regionSelect.append($('<option>').val('').text('Regiones'));
                        regionSelect.append($('<option>').val(value.id).text(value.name));
                    });
                } else {
                    if (communeSelect !== '') {
                        $.each(communeResponse, function (key, value) {
                            communeSelect.append($('<option>').val(value.id).text(value.name));
                        });
                    }
                }

                if (toUpdate == 'commune') {
                    if (candidateSelect !== '') {
                        $.each(candidateResponse, function (key, value) {
                            candidateSelect.append($('<option>').val(value.id).text(value.name));
                        });
                    }
                }

            }, error: function () {
                iziToast.error({ timeout: 5000, icon: 'x icon', title: 'Prueba de diagnóstico', message: 'Ha ocurrido un error al conectar con el servidor' });
            }
        })
    }

    //──── CONFIGURACIÓN DE SELECTS FIN (Filtrado) ────────────────────────────────────────────────────────────────────────────

    /**
     * Validar los select requeridos (Con el selector customized-required)
     * @param  {String} selectorForm
     * @returns {boolean} true si todos los campos requeridos están completos, false de lo contrario
     */
    function selectValidate(selectorForm) {
        let requiredFields = $(selectorForm).find('select[customized-required]');
        let emptyField = true;

        requiredFields.each(function () {
            let selectObject = $(this);
            let labelText = selectObject.closest('.field').find('label').text();

            if (selectObject.val() === '') {
                iziToast.error({ timeout: 2000, icon: 'x icon', title: labelText, message: 'El campo es obligatorio' });
                emptyField = false;
                return false; // Terminar el bucle si se encuentra un campo vacío
            }
        });

        //Validar los checkbox
        let checkboxesSelected = $("input[name^='meet']:checked").length;
        if (checkboxesSelected <= 1) {
            iziToast.error({ timeout: 2000, icon: 'x icon', title: "Como se enteró de nosotros?", message: 'Seleccione al menos dos opciones' });
            emptyField = false;
        }

        return emptyField;
    }

})