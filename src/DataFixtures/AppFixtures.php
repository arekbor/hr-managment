<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Entity\Position;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Positions
        $hr = new Position();
        $hr->setName("HR");
        $manager->persist($hr);
        // $this->setReference("hr", $hr);

        $accountant = new Position();
        $accountant->setName("Accountant");
        $manager->persist($accountant);
        // $this->setReference("accountant", $accountant);

        $copywriter = new Position();
        $copywriter->setName("Copywriter");
        $manager->persist($copywriter);
        // $this->setReference("copywriter", $copywriter);

        $it_manager = new Position();
        $it_manager->setName("IT Manager");
        $manager->persist($it_manager);
        // $this->setReference("it_manager", $it_manager);

        //Employees
        $ryszard_kowalski = new Employee();
        $ryszard_kowalski
            ->setFirstname("Ryszard")
            ->setLastname("Kowalski")
            ->setEmail("kowalski@rysz.com.pl")
            ->addPosition($accountant)
            ->addPosition($copywriter)
        ;
        $manager->persist($ryszard_kowalski);

        $marian_wlodarczyk = new Employee();
        $marian_wlodarczyk
            ->setFirstname("Marian")
            ->setLastname("Włodarczyk")
            ->setEmail("wlodarczyk@email.com")
            ->addPosition($hr)
        ;
        $manager->persist($marian_wlodarczyk);

        $manager->flush();
    }
}
