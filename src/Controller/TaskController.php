<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TaskController
{
    #[Route('/{member}', name: 'members_tasks')]
    public function list(
        Member $member,
        EntityManagerInterface $em,
    ): JsonResponse {
        return new JsonResponse(
            $em->getRepository(Task::class)->findBy(['member' => $member->getId()]),
        );
    }
}