<?php


namespace App\DataFixtures\Faker;

use \Faker\Provider\Base as BaseProvider;

class Provider extends BaseProvider
{
    protected static $roles = [
        ['ROLE_USER'],
        ['ROLE_ADMIN'],
    ];

    protected static $sports = [

        'Alpinisme',
        'Aquagym',
        'Aviron',
        'Baseball',
        'Course à pied',
        'Futsal',
        'Badmington',
        'Kitesurf',
        'Kung-fu',
        'Lutte / Grappling',
        'Marche rapide',
        'Musculation',
        'Natation',
        'Padel',
        'Patin à glace',
        'Pétanque',
        'Planche à voile',
        'Plongée',
        'Quad',
        'Raid',
        'Randonnée',
        'Raquette à neige',
        'Roller',
        'Rugby',
        'Skateboard',
        'Ski',
        'Snowboard',
        'Basketball',
        'Bodyboard',
        'Boxe',
        'Dériveur',
        'Équitation',
        'Fléchettes',
        'Football',
        'Football américain',
        'Gym / Fitness',
        'Handball',
        'Hockey',
        'Sports de plage',
        'Squash',
        'Stand up paddle',
        'Surf',
        'Taekwondo',
        'Tennis',
        'Tennis de table',
        'Trail',
        'Trottinette',
        'Vélo / VTT',
        'Via ferrata',
        'Voile',
        'Volleyball',
        'Wakeboard',
        'Sports d\'eau',
        'Tir à l\'arc',
        'Yoga',
    ];    

    public static function roles()
    {
        return static::randomElement(static::$roles);
    }

    public static function sports()
    {
        return static::randomElement(static::$sports);
    }

}
