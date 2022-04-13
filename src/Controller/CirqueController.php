<?php

namespace App\Controller;

use App\Entity\Glad;
use App\Repository\GladRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CirqueController extends AbstractController
{
    /**
     * @Route("api/cirque/game", name="app_cirque", methods={"POST"})
     */
    public function gameCirque(GladRepository $glad, EntityManagerInterface $em)
    {
        $randomGame = rand(1, 3);

        $glads = $glad->findAll();
        $result = [];
        if ($randomGame === 1) {
            foreach ($glads as $g) {
                $gladiateur = [
                    'id' => $g->getId(),
                    'perfChar' => $g->getValeurChar()
                ];
                $result[] = $gladiateur;
            }
            array_multisort(array_column($result, 'perfChar'), SORT_DESC, $result);
            $winner = $glad->find($result[0]['id']);
            $winnerGained = $winner->getBalance() + 1 >=10 ? 10 : $winner->getBalance() + 1 ;
            $winner->setBalance($winnerGained);
        }else if ($randomGame === 2) {
            foreach ($glads as $g) {
                $gladiateur = [
                    'id' => $g->getId(),
                    'perfLutte' => $g->getValeurLutte()
                ];
                $result[] = $gladiateur;
            }
            array_multisort(array_column($result, 'perfLutte'), SORT_DESC, $result);
            $winner = $glad->find($result[0]['id']);
            $winnerGained = $winner->getStrength() + 1 >=10 ? 10 : $winner->getStrength() + 1 ;
            $winner->setStrength($winnerGained);
        }else if ($randomGame === 3) {
            foreach ($glads as $g) {
                $gladiateur = [
                    'id' => $g->getId(),
                    'perfAthletisme' => $g->getValeurAthletique()
                ];
                $result[] = $gladiateur;
            }
            array_multisort(array_column($result, 'perfAthletisme'), SORT_DESC, $result);
            $winner = $glad->find($result[0]['id']);
            $address = $winner->getAddress() + 0.2 >=10 ? 10 : $winner->getAddress() + 0.2;
            $strength = $winner->getStrength() + 0.2 >=10 ? 10 : $winner->getStrength() + 0.2;
            $balance = $winner->getBalance() + 0.2 >=10 ? 10 : $winner->getBalance() + 0.2;
            $speed = $winner->getSpeed() + 0.2 >=10 ? 10 : $winner->getSpeed() + 0.2;
            $strat = $winner->getStrat() + 0.2 >=10 ? 10 : $winner->getStrat() + 0.2;
            $winner->setStrength($strength)
                    ->setAddress($address)
                    ->setSpeed($speed)
                    ->setStrat($strat)
                    ->setBalance($balance);
        }
        $user = $winner->getLudi()->getUsers();
        $rest = $user->getCoins() + 2;
        $user->setCoins($rest);
        $em->persist($user);
        $em->persist($winner);
        $em->flush();
        return $this->json($winner, 200, [], ['groups' => 'glad_read']);
    }
}
