<?php

namespace App\Events;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedSubscriber{
    public function updateJwtData(JWTCreatedEvent $event){
        // Récupérer l'utilisateur
        $user = $event->getUser();
        // Enrichir les data du JWT
        $data = $event->getData();
        $data['firstName'] = $user->getFirstName();
        $data['lastName'] = $user->getLastName();
        $data['id'] = $user->getId();
        $data['coins'] = $user->getCoins();

        $event->setData($data);

    }
}