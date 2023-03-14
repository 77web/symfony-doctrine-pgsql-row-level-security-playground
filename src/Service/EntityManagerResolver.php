<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Member;
use Doctrine\Bundle\DoctrineBundle\ManagerConfigurator;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class EntityManagerResolver
{
    private array $managers = [];

    public function __construct(
        private readonly EntityManagerInterface $defaultEntityManager,
        private readonly ManagerConfigurator $managerConfigurator,
    ) {
    }

    public function resolve(Member $member): EntityManagerInterface
    {
        $key = $member->getUsername();
        if (!isset($this->managers[$key])) {
            $defaultConn = $this->defaultEntityManager->getConnection();
            $params = array_merge($defaultConn->getParams(), ['user' => $key, 'password' => $key]);
            unset($params['url']);

            $conn = DriverManager::getConnection(
                $params,
                $defaultConn->getConfiguration(),
                $defaultConn->getEventManager(),
            );
            $em = new EntityManager(
                $conn,
                $this->defaultEntityManager->getConfiguration(),
            );
            $this->managerConfigurator->configure($em);
            $this->managers[$key] = $em;
        }

        return $this->managers[$key];
    }
}