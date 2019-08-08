<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create("fr_FR");

        // create admin users
        for($u = 1; $u <= 9; $u++) {
            $user = new User();
            $user
                ->setEmail("admin{$u}@bovoyages.fr")
                ->setPassword("{$u}{$u}{$u}")
                ->setName("Admin {$u}")
                ->setRole(0);
            $manager->persist($user);
            $this->addReference("admin_$u", $user);
        }

        // create client users
        for($c = 1; $c <= 500; $c++) {
           $client = new User();
           $client
               ->setEmail($faker->email)
               ->setPassword("123")
               ->setName($faker->name)
               ->setRole(1);
           $manager->persist($client);
           $this->addReference("client_$c", $client);
        }

        // flush to database
        $manager->flush();
    }

}