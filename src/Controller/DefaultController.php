<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Member;
use App\Service\NewMemberPersister;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    #[Route('', name: 'home')]
    public function index(
        EntityManagerInterface $em,
        NewMemberPersister $newMemberPersister,
    ): Response
    {
        if ($em->getRepository(Member::class)->count([]) === 0) {
            for ($i = 1; $i <=2 ;$i++) {
                $newMemberPersister->persist('member'.$i);
            }
            $em->flush();
        }

        return new Response();
    }
}