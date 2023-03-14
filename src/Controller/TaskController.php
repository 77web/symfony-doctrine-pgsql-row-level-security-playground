<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Task;
use App\Service\EntityManagerResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TaskController extends AbstractController
{
    #[Route('/{member}', name: 'members_tasks')]
    public function list(
        Member $member,
        EntityManagerResolver $emResolver,
        SerializerInterface $serializer,
    ): Response {
        $em = $emResolver->resolve($member);

        return new Response(
            $serializer->serialize($em->getRepository(Task::class)->findAll(), 'json'),
        );
    }
}