<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

#Game-tauluun liittyvät
$routes->get('/game', function() {
    GameController::history();
});

$routes->get('/game/', function() {
    GameController::history();
});

$routes->post('/game', function() {
    GameController::store();
});

$routes->get('/game/new', function() {
    GameController::create();
});

$routes->get('/game/:id', function($id) {
    GameController::details($id);
});

$routes->post('/game/:id', function($id) {
    GameController::update($id);
});

$routes->get('/game/:id/delete', function($id) {
    GameController::delete($id);
});

$routes->post('/game/:id/delete', function($id) {
    GameController::delete($id);
});

$routes->get('/game/:id/edit', function($id) {
    GameController::edit($id);
});

$routes->post('/game/:id/edit', function($id) {
    GameController::edit($id);
});


#Participation-tauluun liittyvät
$routes->get('/participation', function() {
    ParticipationController::index();
});

$routes->post('/participation/add', function() {
    ParticipationController::store();
});

$routes->post('/participation/:id/delete', function($id) {
    ParticipationController::delete($id);
});


#Player-tauluun liittyvät
$routes->post('/player', function() {
    PlayerController::storePlayer();
});

$routes->get('/player/login', function() {
    PlayerController::login();
});

$routes->post('/player/login', function() {
    PlayerController::handle_login();
});

$routes->get('/player/logout', function() {
    PlayerController::logout();
});

$routes->get('/player/new', function() {
    PlayerController::create();
});

$routes->get('/player/:id/edit', function($id) {
    PlayerController::edit($id);
});

$routes->post('/player/:id/edit', function($id) {
    PlayerController::edit($id);
});

$routes->get('/player/:id/delete', function($id) {
    PlayerController::delete($id);
});

$routes->post('/player/:id/delete', function($id) {
    PlayerController::delete($id);
});

$routes->get('/player/:id/profile', function($id) {
    PlayerController::show($id);
});

#Tournament-tauluun liittyvät
$routes->get('/tournament', function() {
    TournamentController::index();
});

$routes->post('/tournament', function() {
    TournamentController::store();
});

$routes->get('/tournament/new', function() {
    TournamentController::create();
});

$routes->get('/tournament/:id', function($id) {
    TournamentController::details($id);
});

$routes->post('/tournament/:id', function($id) {
    TournamentController::update($id);
});

$routes->get('/tournament/:id/delete', function($id) {
    TournamentController::delete($id);
});

$routes->post('/tournament/:id/delete', function($id) {
    TournamentController::delete($id);
});

$routes->get('/tournament/:id/edit', function($id) {
    TournamentController::edit($id);
});

$routes->post('/tournament/:id/edit', function($id) {
    TournamentController::edit($id);
});