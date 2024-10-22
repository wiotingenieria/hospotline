<?php

namespace App\Controller\Radius;

use App\Controller\Controller;
use App\Model\Radius\NAS;
use App\Model\Radius\Client;
use App\Model\Radius\Contractor;

class ContractorController extends Controller {
    
    public function __construct( $container ) {
    
        parent::__construct( $container );
    }
  
    public function actionView( $request, $response ) {
    
        $id = $request->getQueryParam( "id", null );

        $client = Client::getId( $id );

        if( $client === null ) {
        
            return $this->redirect( $response, "error", [
                 
                "error"=>"Cliente não encontrado"
            ]); 
        }

        return $this->view->render( $response, "Radius/Client/view.html",[
            
            "client"=>$client
        ]);
    }

    public function actionCreate( $request, $response ) {
        
        $client = Client::create();

        $errors = [];

        if( $request->isPost() ) {
            
            $data = $request->getParsedBody();

            $client->fill( isset( $data["client"] ) ? $data["client"] : [] );

            if( $client->save() ) {

                return $this->redirect( $response, "client_view", [
                 
                    "id"=>$client->id
                ]); 
            }

            $errors = [ "main"=> [ 
            
                "O campo IP deve ser preenchido com um endereço IP válido",
                "O campo Ports deve ser preenchido com um número inteiro"
            ] ]; 
        }

    $token = $this->getTokenCSRF( $request );

    $types = Client::getTypes();

        return $this->view->render( $response, "Radius/Client/create.html", [

            "token"=>$token,
        "client"=>$client,
        "types"=>$types,
            "errors"=>$errors
        ]);
    }

    public function actionUpdate( $request, $response ) {

        $id = $request->getQueryParam( "id", null );

        $client = Client::getId( $id );

        if( $client === null ) {
        
            return $this->redirect( $response, "error", [
                 
                "error"=>"Cliente não encontrado"
            ]); 
        }

        $errors = [];

        if( $request->isPost() ) {

            $data = $request->getParsedBody();
            
            $client->fill( isset( $data["client"] ) ? $data["client"] : [] );

            if( $client->save() ) {

                return $this->redirect( $response, "client_view", [
                 
                    "id"=>$client->id
                ]); 
            }

            $errors = [ "main"=> [ 
            
                "Erro, você deve preencher o nome e no mínimo um atributo" 
            ] ]; 
        }

        $token = $this->getTokenCSRF( $request );

        $types = Client::getTypes();
    
        return $this->view->render( $response, "Radius/Client/update.html", [

            "token"=>$token,
            "client"=>$client,
            "types"=>$types,
            "errors"=>$errors
        ]);
    }

    public function actionList( $request, $response ) {

        $macName = $request->getQueryParam( "macName", "" );
        $atributeName = $request->getQueryParam( "atributeName", "" );
        $nameName = $request->getQueryParam( "nameName", "" );
        $companyName = $request->getQueryParam( "companyName", "" );
        $dependencyName = $request->getQueryParam( "dependencyName", "" );
        $creationName = $request->getQueryParam( "creationName", "" );
        
        $op = $request->getQueryParam( "op", "" );

        $page = ( int ) $request->getQueryParam( "page", 0 );
    
        if( $page < 0 ) {
                     
            $page = 0;
        }

        $take = 5;

        $skip = $take * $page; 

        $contractors = Contractor::where( "username", "like", "%" . $macName . "%" )          
            ->where( "name", "like", "%" . $nameName . "%" )
            ->where( "company", "like", "%" . $companyName . "%" )
            ->where( "dependency", "like", "%" . $dependencyName . "%" )
            ->where( "created_at", "like", "%" . $creationName . "%" )
            ->skip( $skip )
            ->take( $take )
            ->get();

        return $this->view->render( $response, "Radius/Contractor/list.html", [
        
            "contractors"=>$contractors,
            "macName"=>$macName,
            "nameName"=>$nameName,
            "dependencyName"=>$dependencyName,
            "creationName"=>$creationName,
            "page"=>$page,
        ]);
    }

    public function actionDelete( $request, $response ) {
    
        $id = $request->getQueryParam( "id", null );
 
        $client = Client::getId( $id );
    
        if( $client === null ) {
           
            return $this->redirect( $response, "error" , [
            
                "error"=>"Cliente não encontrado"
            ]);
        }

        if( $request->isPost() ) { 

            $client->delete();
            
            return $this->redirect( $response, "client_list" );
        }
         
        $token = $this->getTokenCSRF( $request );

        return $this->view->render( $response, "Radius/Client/delete.html", [
        
            "token"=>$token,
            "client"=>$client
        ]);
    }
}