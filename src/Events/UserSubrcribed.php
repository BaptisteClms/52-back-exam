<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserSubrcribed implements EventSubscriberInterface
{
    private $encoder;
    private $repository;

    public function __construct(UserPasswordHasherInterface $encoder, UserRepository $repository)
    {
        $this->encoder = $encoder;
        $this->repository = $repository;
    }


    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE]
        ];
    }

    public function encodePassword(ViewEvent $event){
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if($user instanceof User && $method === "POST"){
            $hash = $this->encoder->hashPassword($user,$user->getPassword());
            $user->setPassword($hash);
            if(!empty($this->repository->findAll())){
                $user->setRoles(["ROLE_USER"]);
            }else{
                $user->setRoles(["ROLE_ADMIN"]);
            }
            $user->setCoins(10);
        }
        if ($user instanceof User && $method === "PUT"){
            if(substr($user->getPassword(),0,7) !== "$2y$13$"){
                $hash = $this->encoder->hashPassword($user,$user->getPassword());
                $user->setPassword($hash);
            }
        }
    }
}