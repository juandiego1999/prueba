<?php

use Database\Database;

require_once __DIR__ . '/Database.php';

/**
 *
 * Controlador de la aplicación
 *
 * @author      Juan Diego Villar Hernandez <juandiegom78@gmail.com>
 * @copyright   Copyright (c) 2023
 */

class AppController extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * addContentForm
     *
     * @return object
     * 
     */
    public function addContentForm()
    {
        //Mensajes de respuesta
        $saved = 'Datos guardados correctamente';
        $error = 'El RUT ingresado es duplicado';

        // Validar datos enviados por post
        $names = isset($_POST['names']) && !empty($_POST['names']) ? $_POST['names'] : null;
        $alias = isset($_POST['alias']) && !empty($_POST['alias']) ? $_POST['alias'] : null;
        $rut = isset($_POST['rut']) && !empty($_POST['rut']) ? $_POST['rut'] : null;
        $email = isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : null;
        $region = isset($_POST['region']) && !empty($_POST['region']) ? $_POST['region'] : null;
        $commune = isset($_POST['commune']) && !empty($_POST['commune']) ? $_POST['commune'] : null;
        $candidate = isset($_POST['candidate']) && !empty($_POST['candidate']) ? $_POST['candidate'] : null;
        $meet = isset($_POST['meet']) && !empty($_POST['meet']) ? implode(", ", $_POST['meet']) : null;

        $fieldsArray = [
            'names',
            'alias',
            'rut',
            'email',
            'region',
            'commune',
            'candidate',
            'meet',
        ];

        $valuesArray = [
            $names,
            $alias,
            $rut,
            $email,
            $region,
            $commune,
            $candidate,
            $meet,
        ];

        if (!is_null(Database::extractDataFromDatabase('votes', 'rut', "rut = '$rut'"))) {
            $success = false;
        } else {
            $success = Database::createSaveQuery('votes', $fieldsArray, $valuesArray);
        }

        if ($success) {
            echo json_encode(['message' => $saved, 'success' => true]);
        } else {
            echo json_encode(['message' => $error, 'success' => false]);
        }
    }

    /**
     * validateUbication 
     * Para validar que coincidan las regiones, ciudades y candidatos
     *
     * @return object
     */
    public function validateUbication()
    {
        // Validar datos enviados por get
        $region = $_GET['region'] == 0 ? null : $_GET['region'];
        $commune = $_GET['commune'] == 0 ? null : $_GET['commune'];
        $candidate = $_GET['candidate'] == 0 ? null : $_GET['candidate'];

        if (is_null($region) && is_null($commune) && is_null($candidate)) {
            $DbInformation = ['regionResponse' => Database::extractDataFromDatabase('regions', 'id, name', '', '', false, true)];
        } else if (!is_null($region) && is_null($commune) && is_null($candidate)) {
            $DbInformation = ['communeResponse'  => Database::extractDataFromDatabase('communes', 'id, name', "region = $region", '', false, true)];
        } else if (!is_null($region) && !is_null($commune) && is_null($candidate)) {
            $DbInformation = ['candidateResponse'  => Database::extractDataFromDatabase('candidates', 'id, name', "commune = $commune", '', false, true)];
        }

        echo json_encode($DbInformation);
    }
}

// Rutas improvisadas, es decir se ejecuta la función necesaria
if (isset($_GET['region'])) {
    $appController = new AppController;
    $appController->validateUbication();
}

if (isset($_POST['names'])) {
    $appController = new AppController;
    $appController->addContentForm();
}
