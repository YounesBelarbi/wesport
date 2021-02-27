<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class RequestCity
{
    public function getDepartement()
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://geo.api.gouv.fr/departements');    
        $choices = [];

        foreach ($response->toArray() as $key => $choice) {
        $choices[$choice['nom']] = $choice['code'];
        }     
        
        ksort($choices);        
        return $choices;
    }

    
    public function getCity($id)
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', "https://geo.api.gouv.fr/departements/".$id."/communes");
        $departementCytiesName = [];
 
        return $response->toArray();
    } 


    public function cityPerDepartement() {    
    
        // $httpClient = HttpClient::create();
        // $departement = $httpClient->request('GET', 'https://geo.api.gouv.fr/departements');

        // $arrayDepartement =  $departement->toArray();

        // foreach ($arrayDepartement as $key => $value) {

        //     $citiesDepartement[$value['nom']]= $this->getCity($value['code']);
        // }
        // return $citiesDepartement;
    }

}



