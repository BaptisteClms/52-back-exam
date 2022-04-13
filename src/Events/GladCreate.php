<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Glad;
use App\Repository\GladRepository;
use App\Repository\LudiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class GladCreate implements EventSubscriberInterface
{

    private $security;
    private $em;
    private $repository;
    private $ludiRepository;

    public function __construct(Security $security, EntityManagerInterface $em, GladRepository $repository, LudiRepository $ludiRepository)
    {
        $this->security = $security;
        $this->repository = $repository;
        $this->em = $em;
        $this->ludiRepository = $ludiRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['createGlad', EventPriorities::PRE_WRITE]
        ];
    }

    public function createGlad(ViewEvent $event)
    {
        $glad = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        $user = $this->security->getUser();
        if ($glad instanceof Glad && $method === "POST") {
        $rest = $user->getCoins() - 5;
        $getLudi = $glad->getLudi();
        $ludi = $this->ludiRepository->findBy(["users" => $user, "id" => $getLudi->getId()]);
        $full = $this->repository->findBy(["ludi" => $getLudi]);
            if (!empty($ludi)) {
                if (count($full) < 10) {
                    if ($rest >= 0) {
                        $strength = rand(0, 3);
                        $address = rand(0, 3);
                        $balance = rand(0, 3);
                        $speed = rand(0, 3);
                        $strat = rand(0, 3);
                        $glad->setStrength($strength)
                            ->setAddress($address)
                            ->setBalance($balance)
                            ->setSpeed($speed)
                            ->setStrat($strat);

                        $user->setCoins($rest);
                        $this->em->persist($user);
                        $this->em->flush();
                    } else {
                        throw new \Exception("Vous n'avez pas assez d'argent");
                    }
                } else {
                    throw new \Exception("Ce ludi est déja complet");
                }
            } else {
                throw new \Exception("Vous n'avez la permission de créer un gladiateur pour ce ludi");
            }

        }
    }
}