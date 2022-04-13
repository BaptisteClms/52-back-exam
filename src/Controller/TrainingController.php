<?php

namespace App\Controller;

use App\Entity\Glad;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TrainingController extends AbstractController
{
    /**
     * @Route("api/training/{id}/Physique", name="app_physique", methods={"POST"})
     */
    public function trainPhysique(Glad $glad, EntityManagerInterface $em)
    {
        if ($glad->getBalance() > 0 && $glad->getStrat() > 0) {
                $addValue = 0;
            if ($glad->getLudi()->getCourseDeChar()) {
                $addValue = rand(2, 4);
            } else if ($glad->getLudi()->getLutte()) {
                $addValue = rand(3, 6);
            } else if ($glad->getLudi()->getAthletisme()) {
                $addValue = rand(3, 5);
            }
            $glad->setAddress($glad->getAddress() + 0.4 * $addValue >= 10 ? 10 : $glad->getAddress() + 0.4 * $addValue)
                ->setStrength($glad->getStrength() + 0.3 * $addValue >= 10 ? 10 : $glad->getStrength() + 0.3 * $addValue)
                ->setBalance($glad->getBalance() - 0.1 * $addValue <= 0 ? 0 : $glad->getBalance() - 0.1 * $addValue)
                ->setSpeed($glad->getSpeed() + 0.5 * $addValue >= 10 ? 10 : $glad->getSpeed() + 0.5 * $addValue)
                ->setStrat($glad->getStrat() - 0.2 * $addValue <= 0 ? 0 : $glad->getStrat() - 0.2 * $addValue);

            $em->persist($glad);
            $em->flush();
            return $this->json($glad, 201, [], ['groups' => "glad_read"]);

        } else {
            throw new \Exception("Vous n'avez plus asser d'equilibre ou de strategie pour entrainer votre gladiateur ");
        }
    }

    /**
     * @Route("api/training/{id}/Tactique", name="app_tactique", methods={"POST"})
     */
    public function trainTactique(Glad $glad, EntityManagerInterface $em)
    {
        if ($glad->getBalance() > 0 && $glad->getStrat() > 0) {
            $addValue = 0;
            if ($glad->getLudi()->getCourseDeChar()) {
                $addValue = rand(3, 6);
            } else if ($glad->getLudi()->getLutte()) {
                $addValue = rand(1, 3);
            } else if ($glad->getLudi()->getAthletisme()) {
                $addValue = rand(2, 3);
            }
            $glad->setAddress($glad->getAddress() + 0.4 * $addValue >= 10 ? 10 : $glad->getAddress() + 0.4 * $addValue)
                ->setStrength($glad->getStrength() + 0.3 * $addValue >= 10 ? 10 : $glad->getStrength() + 0.3 * $addValue)
                ->setBalance($glad->getBalance() - 0.1 * $addValue <= 0 ? 0 : $glad->getBalance() - 0.1 * $addValue)
                ->setSpeed($glad->getSpeed() + 0.5 * $addValue >= 10 ? 10 : $glad->getSpeed() + 0.5 * $addValue)
                ->setStrat($glad->getStrat() - 0.2 * $addValue <= 0 ? 0 : $glad->getStrat() - 0.2 * $addValue);

            $em->persist($glad);
            $em->flush();
            return $this->json($glad, 201, [], ['groups' => "glad_read"]);

        } else {
            throw new \Exception("Vous n'avez plus asser d'equilibre ou de strategie pour entrainer votre gladiateur ");
        }
    }

    /**
     * @Route("api/training/{id}/Combine", name="app_combine", methods={"POST"})
     */
    public function trainCombine(Glad $glad, EntityManagerInterface $em)
    {
        if ($glad->getBalance() > 0 && $glad->getStrat() > 0) {
            $addValue = 0;
            if ($glad->getLudi()->getCourseDeChar()) {
                $addValue = rand(2, 7);
            } else if ($glad->getLudi()->getLutte()) {
                $addValue = rand(1, 5);
            } else if ($glad->getLudi()->getAthletisme()) {
                $addValue = rand(3, 9);
            }
            $glad->setAddress($glad->getAddress() + 0.4 * $addValue >= 10 ? 10 : $glad->getAddress() + 0.4 * $addValue)
                ->setStrength($glad->getStrength() + 0.3 * $addValue >= 10 ? 10 : $glad->getStrength() + 0.3 * $addValue)
                ->setBalance($glad->getBalance() - 0.1 * $addValue <= 0 ? 0 : $glad->getBalance() - 0.1 * $addValue)
                ->setSpeed($glad->getSpeed() + 0.5 * $addValue >= 10 ? 10 : $glad->getSpeed() + 0.5 * $addValue)
                ->setStrat($glad->getStrat() - 0.2 * $addValue <= 0 ? 0 : $glad->getStrat() - 0.2 * $addValue);

            $em->persist($glad);
            $em->flush();
            return $this->json($glad, 201, [], ['groups' => "glad_read"]);

        } else {
            throw new \Exception("Vous n'avez plus asser d'equilibre ou de strategie pour entrainer votre gladiateur ");
        }
    }

}
