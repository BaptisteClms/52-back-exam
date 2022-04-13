<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Ludi;
use App\Repository\LudiRepository;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class LudiCreate implements EventSubscriberInterface
{
    private $security;
    private $em;
    private $repository;

    public function __construct(Security $security, LudiRepository $repository, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->repository = $repository;
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['createLudi', EventPriorities::PRE_WRITE]
        ];
    }

    public function createLudi(ViewEvent $event)
    {
        $ludi = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        $user = $this->security->getUser();

        if ($ludi instanceof Ludi && $method === "POST") {
            $rest = $user->getCoins() - 60;
            $ludi->setUsers($user);
            $ludis = $this->repository->findBy(["users" => $user]);
            if (!empty($ludis)) {
                if ($rest >= 0) {

                    $user->setCoins($rest);
                    $this->em->persist($user);
                    $this->em->flush();
                } else {
                    throw new \Exception("Vous n'avez pas assez d'argent");
                }
            }
        }
    }
}