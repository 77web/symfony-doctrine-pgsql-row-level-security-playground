<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Member;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class NewMemberPersister
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function persist(string $username): void
    {
        $member = new Member();
        $member->setUsername($username);
        $this->em->persist($member);

        $task = new Task();
        $task->setMember($member);
        $task->setTitle('first task of '.$username);
        $this->em->persist($task);

        $this->em->flush();

        $conn = $this->em->getConnection();

        $conn->executeQuery(sprintf('CREATE ROLE "%s" LOGIN', $username));
        $conn->executeQuery(sprintf('ALTER ROLE "%s" WITH PASSWORD \'%s\'', $username, $username));
        $conn->executeQuery(sprintf('GRANT member to "%s"', $username));
    }
}