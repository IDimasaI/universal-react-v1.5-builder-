<?php return [
    '#^test$#' => 'PublicController@test',
    '#^test2/([a-zA-Z-_]+)/(DOOM)$#' => 'PublicController@test2',
    '#^test3/([a-zA-Z-_]+)$#' => 'PrivateController@test3',
    '#^test4sadd$#' => 'PrivateController@testdsd3',
]; ?>
