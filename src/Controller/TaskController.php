<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Task;
use App\Service\EntityManagerResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TaskController
{
    #[Route('/{member}', name: 'members_tasks')]
    public function list(
        Member $member,
        EntityManagerResolver $emResolver,
    ): JsonResponse {
        $em = $emResolver->resolve($member);

        return new JsonResponse(
            $em->getRepository(Task::class)->findAll(),
        );
    }
}