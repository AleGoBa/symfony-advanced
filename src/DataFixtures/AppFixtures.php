<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\CommentFactory;
use App\Factory\PostFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CategoryFactory::createMany(10);

        PostFactory::createMany(40, [
            'comments' => CommentFactory::new()->many(1, 4),
            'category' => CategoryFactory::random()
        ]);

        $manager->flush();
    }
}
