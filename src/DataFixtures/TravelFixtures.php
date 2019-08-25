<?php


namespace App\DataFixtures;


use App\Entity\Travel;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class TravelFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $now = new \DateTime("now");
        $today = $now->format("d/m/Y");
        for ($t = 1; $t <= 30; $t++) {
            $travel = new Travel();
            $destination = $faker->country . " (" . $faker->city . ")";
            $fromDate = $faker->dateTimeBetween("now -3 months", "now +5 months");
            $toDate = new \DateTime($fromDate->format("Y-m-d") . " +" . mt_rand(1,3) . " weeks");
            $days = date_diff($fromDate, $toDate)->format("%a");
            $maxGuests = mt_rand(1,9);
            $retailPrice = mt_rand(40,120)*$maxGuests*$days;
            $discountRate = mt_rand(1,7)*10;
            $salePrice = $retailPrice*(100-$discountRate)/100;
            $details = "{$destination}\nDu {$fromDate->format("d/m/Y")} au {$toDate->format("d/m/Y")} pour {$maxGuests}\n
            Pour {$salePrice} (remise de {$discountRate})";
            $img = $faker->imageUrl(600, 600, 'city');
            $description = $faker->sentences(5, true);
            $travel
                ->setDestination($destination)
                ->setDetails($details)
                ->setFromDate($fromDate)
                ->setToDate($toDate)
                ->setMaxGuests($maxGuests)
                ->setRetailPrice($retailPrice)
                ->setDiscountRate($discountRate)
                ->setImg($img)
                ->setDescription($description);
            ;
            $travel->setStatus(0);
            if ($toDate < $now) {
                $travel
                    ->setClient($this->getReference("client_".mt_rand(1, 500)))
                    ->setClientCreditCard($faker->creditCardNumber)
                ;
                $status = mt_rand(1,20);
                if ($status > 15) {
                    $travel->setStatus(5);
                } else {
                    $travel->setStatus(4);
                }

            }

            $manager->persist($travel);
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}