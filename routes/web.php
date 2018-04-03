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

$router->post('radius/user/register', 'RadiusUserController@register');
$router->post('radius/user/confirm', 'RadiusUserController@confirm');


$router->post('message', 'MessageController@store');
$router->get('message', ['middleware' => 'jsonApi', 'middleware' => 'auth', 'uses' => 'MessageController@index']);

$router->get('message/{id}', [
    'as' => 'message.show', 'uses' => 'MessageController@show'
]);

$router->get('message/{id}/relationships/sender', [
    'as' => 'messageSenderRelationship.show', 'uses' => 'MessageSenderRelationshipController@show'
]);

$router->patch('message/{id}/relationships/sender', [
    'as' => 'messageSenderRelationship.update', 'uses' => 'MessageSenderRelationshipController@update'
]);

$router->get('message/{id}/sender', [
    'as' => 'messageSenderChild.show', 'uses' => 'MessageSenderRelationshipController@show'
]);

$router->get('message/{id}/relationships/receiver', [
    'as' => 'messageReceiverRelationship.show', 'uses' => 'MessageSenderRelationshipController@receiver'
]);

$router->get('message/{id}/receiver', [
    'as' => 'messageReceiverChild.show', 'uses' => 'MessageSenderRelationshipController@show'
]);

$router->get('message/{id}/relationships/sender-client', [
    'as' => 'messageSenderClientRelationship.show', 'uses' => 'MessageSenderRelationshipController@show'
]);

$router->get('message/{id}/sender-client', [
    'as' => 'messageSenderClientChild.show', 'uses' => 'MessageSenderRelationshipController@show'
]);

$router->get('message/{id}/relationships/receiver-client', [
    'as' => 'messageReceiverClientRelationship.show', 'uses' => 'MessageSenderRelationshipController@show'
]);

$router->get('message/{id}/receiver-client', [
    'as' => 'messageReceiverClientChild.show', 'uses' => 'MessageSenderRelationshipController@show'
]);


$router->post('contact', 'ContactController@store');
$router->get('contact', 'ContactController@index');

$router->get('contact/{id}', [
    'as' => 'contact.show', 'uses' => 'ContactController@show'
]);

$router->get('contact/{id}/relationships/message', [
    'as' => 'contactRelationship.show', 'uses' => 'ContactRelationshipController@message'
]);

$router->get('contact/{id}/message', [
    'as' => 'contactChild.show', 'uses' => 'ContactRelationshipController@show'
]);