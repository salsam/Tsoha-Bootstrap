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

$routes->get('/game_details', function() {
    HelloWorldController::game_details();
});

$routes->get('/game_edit', function() {
    HelloWorldController::game_edit();
});

$routes->get('/game_history', function() {
    HelloWorldController::game_history();
});

$routes->get('/organizer_edit', function() {
    HelloWorldController::organizer_edit();
});

$routes->get('/organizer_register', function() {
    HelloWorldController::organizer_register();
});

$routes->get('/player_edit', function() {
    HelloWorldController::player_edit();
});

$routes->get('/register', function() {
    HelloWorldController::register();
});

$routes->get('/tournament_details', function() {
    HelloWorldController::tournament_details();
});

$routes->get('/tournament_list', function() {
    HelloWorldController::tournament_list();
});
