<?php


namespace App\DataFixtures\Faker;

use \Faker\Provider\Base as BaseProvider;

class Provider extends BaseProvider
{
    protected static $roles = [
        ['ROLE_USER'],
        ['ROLE_ADMIN'],
        ['ROLE_ANONYMOUS']
    ];


    protected static $sports = [
        'football',
        'rugby',
        'tennis',
        'ping-pong',
        'course à pied',
        'hanball',
        'basket',
        'marche rapide',
        'musculation',
        'futsal',
        'badmington'
    ];

    protected static $levels = [
        'debutant',
        'moyen',
        'bon niveau',
        'exellent niveau',
        'haut niveau'
    ];






    public static function roles(){
        return static::randomElement(static::$roles);
    }


    public static function sports(){
        return static::randomElement(static::$sports);
    }


    public static function levels(){
        return static::randomElement(static::$levels);
    }


    
    


}