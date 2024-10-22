<?php

$app->map( ["GET"], "/", "App\Controller\Radius\AppController:actionIndex" )
    ->setName( "index" );

$app->map( ["GET", "POST"], "/authenticate", "App\Controller\Radius\AuthController:actionAuthenticate" )
    ->setName( "authenticate" );

$app->map( ["GET", "POST"], "/logout", "App\Controller\Radius\AuthController:actionLogout" )
    ->setName( "logout" );

$app->group( "/protected", function() {

    $this->map( ["GET"], "/error", "App\Controller\Radius\AppController:actionError" )
        ->setName( "error" );

    $this->group("/users", function () {

        $this->map( ["GET"], "/[list]", "App\Controller\Radius\UserController:actionList" )
            ->setName( "user_list" );

        $this->map( ["GET"], "/view", "App\Controller\Radius\UserController:actionView" )
            ->setName( "user_view" );
    
        $this->map( ["POST"], "/store", "App\Controller\Radius\UserController:actionStore" )
            ->setName( "user_stored" );
    
        $this->map( ["GET", "POST"], "/create", "App\Controller\Radius\UserController:actionCreate" )
            ->setName( "user_create" );

        $this->map( ["GET", "POST"], "/update", "App\Controller\Radius\UserController:actionUpdate" )
            ->setName( "user_update" );

        $this->map( ["GET", "POST"], "/delete", "App\Controller\Radius\UserController:actionDelete" )
            ->setName( "user_delete" );

        $this->map( ["GET", "POST"], "/statistic", "App\Controller\Radius\UserController:actionStatistic" )
            ->setName( "user_statistic" );

    });

    $this->group("/groups", function () {

        $this->map( ["GET"], "/[list]", "App\Controller\Radius\GroupController:actionList" )
            ->setName( "group_list" );

        $this->map( ["GET"], "/view", "App\Controller\Radius\GroupController:actionView" )
            ->setName( "group_view" );
    
        $this->map( ["POST"], "/store", "App\Controller\Radius\GroupController:actionStore" )
            ->setName( "group_store" );

        $this->map( ["GET", "POST"], "/create", "App\Controller\Radius\GroupController:actionCreate" )
            ->setName( "group_create" );

        $this->map( ["GET", "POST"], "/update", "App\Controller\Radius\GroupController:actionUpdate" )
            ->setName( "group_update" );

        $this->map( ["GET", "POST"], "/delete", "App\Controller\Radius\GroupController:actionDelete" )
            ->setName( "group_delete" );
    });

    $this->group("/statistics", function () {

        $this->map( ["GET"], "/[list]", "App\Controller\Radius\StatisticController:actionList" )
            ->setName( "statistic_list" );
    });

    $this->group("/clients", function () {

        $this->map( ["GET"], "/view", "App\Controller\Radius\ClientController:actionView" )
            ->setName( "client_view" );

        $this->map( ["GET"], "/[list]", "App\Controller\Radius\ClientController:actionList" )
            ->setName( "client_list" );

        $this->map( ["GET", "POST"], "/create", "App\Controller\Radius\ClientController:actionCreate" )
            ->setName( "client_create" );

        $this->map( ["GET", "POST"], "/update", "App\Controller\Radius\ClientController:actionUpdate" )
            ->setName( "client_update" );

        $this->map( ["GET", "POST"], "/delete", "App\Controller\Radius\ClientController:actionDelete" )
            ->setName( "client_delete" );
    });

    $this->group("/contractors", function () {

        $this->map( ["GET"], "/view", "App\Controller\Radius\ContractorController:actionView" )
            ->setName( "contractor_view" );
   
        $this->map( ["GET"], "/[list]", "App\Controller\Radius\ContractorController:actionList" )
            ->setName( "contractor_list" );

    });

    $this->group("/json", function () {

        $this->group("/groups", function () {
            
            $this->map( ["GET", "POST"], "/[list]", "App\Controller\Radius\GroupController:actionListJSON" )
                ->setName( "json_group_list" );

            $this->map( ["GET", "POST"], "/exist", "App\Controller\Radius\GroupController:actionExistJSON" )
                ->setName( "json_group_exist" );
        });
    });

})->add( new App\Middleware\Radius\AuthMiddleware( $container ) );

