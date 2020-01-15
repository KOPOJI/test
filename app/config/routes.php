<?php

return array(
    '/' => 'Koj\\Controllers\\TaskController@index',
    '/tasks/create' => 'Koj\\Controllers\\TaskController@create',
    '/tasks/edit/(?P<id>\d+)' => 'Koj\\Controllers\\TaskController@edit',
    '/login' => 'Koj\\Controllers\\LoginController@login',
    '/logout' => 'Koj\\Controllers\\LoginController@logout',
);