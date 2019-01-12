<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


//Route to add new user
$router->post('/api/user', ['uses' => 'UserController@addNewUser']);

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
    //Route to get authenticated user details
    $router->get('/user', ['uses' => 'UserController@getAuthenticatedUser']);

    //Route to add new document
    $router->post('/document', ['uses' => 'DocumentController@addNewDocument']);

    //Route to get document details by its id
    $router->get('/document/{document_id}', ['uses' => 'DocumentController@getDocument']);
});