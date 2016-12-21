<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/game_history', function() {
    HelloWorldController::game_history();
});

$routes->get('/register', function() {
    HelloWorldController::register();
});

$routes->get('/tournament_list', function() {
    HelloWorldController::tournament_list();
});
