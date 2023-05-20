<?php

namespace App\DataFixtures;

use App\Factory\ProductFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ProductFactory::createMany(20);
        UserFactory::createOne([
            "email" => "juanito@gmail.com",
            "password" => "1234"
        ]);
        UserFactory::createOne();
    }
}
