<?php

use Slim\App;
use App\Infrastructure\Controllers\ContractController;

return function (App $app) {
    $app->get('/', ContractController::class)->setName('home');;

};