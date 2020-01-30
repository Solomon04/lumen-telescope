<?php

/** @var \Laravel\Lumen\Routing\Router $router */

// pages
$router->get('/', ['as' => 'meter_home', 'uses' => 'PagesController@home']);
$router->get('requests', ['as' => 'meter_requests', 'uses' => 'PagesController@requests']);
$router->get('queries', ['as' => 'meter_queries', 'uses' => 'PagesController@queries']);
$router->get('commands', ['as' => 'meter_commands', 'uses' => 'PagesController@commands']);
$router->get('events', ['as' => 'meter_events', 'uses' => 'PagesController@events']);
$router->get('schedules', ['as' => 'meter_schedules', 'uses' => 'PagesController@schedules']);
$router->get('server_stats', ['as' => 'meter_server_stats', 'uses' => 'PagesController@serverStats']);

// tables
$router->get('requests_table', ['as' => 'meter_requests_table', 'uses' => 'TablesController@requestsTable']);
$router->get('queries_table', ['as' => 'meter_queries_table', 'uses' => 'TablesController@queriesTable']);
$router->get('commands_table', ['as' => 'meter_commands_table', 'uses' => 'TablesController@commandsTable']);
$router->get('events_table', ['as' => 'meter_events_table', 'uses' => 'TablesController@eventsTable']);
$router->get('schedules_table', ['as' => 'meter_schedules_table', 'uses' => 'TablesController@schedulesTable']);
