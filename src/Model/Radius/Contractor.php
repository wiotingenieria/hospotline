<?php

namespace App\Model\Radius;

use Illuminate\Database\Eloquent\Model;

class Contractor extends Model {

    public $timestamps = false;

    protected $table = "radcheck";

    protected $connection = "radius";

    protected $fillable = [
        "id",
        "username",
        "attribute",
        "op",
        "value",
        "name",
        "email",
        "company",
        "dependency",
        "created_at",
        "updated_at"



    ];

    public function __construct() {

        parent::__construct();
    }

    public static function getOperators() {
    
        return [
            "=",
            ":=",
            "==",
            "+=",
            "!=",
            ">",
            ">=",
            "<",
            "<=",
            "=~",
            "!~",
            "=*",
            "!*"
        ];
    }


}