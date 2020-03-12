<?php

namespace App\Model\Radius;

use Illuminate\Database\Capsule\Manager;
use Respect\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;

class Contry {

    private $radcheck;

    private $validator;

    public function __construct( $radcheck = null ) {

        $this->radcheck = new Contractor();
        
        if( $radcheck !== null ) {
        
            $this->radcheck = $radcheck;
        }

    }   

    public function __get( $propertie ) {
    
        return $this->radcheck->$propertie;
    }

    public function __set( $propertie, $value ) {
    
        $this->radcheck->$propertie = $value;
    }

    public function __isset( $propertie ) {

        return isset( $this->radcheck->$propertie );
    }
       
    public function validate() {

        return Validator::ip()->validate( $this->nasname ) &&
            Validator::intVal()->validate( $this->ports );
    }

    public function save( $oldName = null ) {
        
        if( $this->validate() ) {

            $this->nas->save();

            return true;
        }

        return false;
    }

    public function delete() {
        
        $this->radcheck->delete();
    }

    public function fill( $data ) {
   
        $this->radcheck->fill( $data );    
    }
   
    public static function create() {
   
        return new Client();
    }
           
    public static function exists( $nasName ) {
    
        $qt = NAS::where( "nasname", $nasName )->count();
        
        return $qt > 0 ; //only $qt 
    }    
 
    public static function getId( $id ) {
        
        $nas = NAS::find( $id );
    
        if( $nas !== null ) {
        
            return new Client( $nas ) ;
        } 

        return null;
    }
        
    public static function get( $nasName ) {
 
        if( empty( $nasName ) ) {
            
            return null;
        }

        $nas = NAS::where( "nasname", $name )->first();

        if( $nas !== null ) {
        
            return  new Client( $nas );
        }
        
        return null;
    }    
 
    public static function getAll() {
    
        $contractors = [];

        $radchecks = Contractor::all();
        
        foreach( $radchecks as $radcheck ) {
        
            $contractors[] = new Contractor( $radcheck );
        }

        return $contractors;
    }

    public static function getTypes() {

        return [
            "cisco",
            "computone",
            "livingstone",
            "juniper",
            "max40xx",
            "multitech",
            "netserver",
            "pathras",
            "patton",
            "portslave",
            "tc",
            "usrhiper",
            "other"
        ];
    }
   
}