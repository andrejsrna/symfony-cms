<?php

namespace App\Repository;

use App\Entity\Settings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Settings>
 *
 * @method Settings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Settings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Settings[]    findAll()
 * @method Settings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Settings::class);
    }

    public function getSettings(string $name): ?array
    {
        $settings = $this->findOneBy(['name' => $name]);
        return $settings ? $settings->getValue() : null;
    }

    public function saveSettings(string $name, array $value): void
    {
        $settings = $this->findOneBy(['name' => $name]);
        
        if (!$settings) {
            $settings = new Settings();
            $settings->setName($name);
        }

        $settings->setValue($value);
        
        $this->getEntityManager()->persist($settings);
        $this->getEntityManager()->flush();
    }
} 