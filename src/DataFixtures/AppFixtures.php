<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\CategoryFactory;
use App\Factory\CommentFactory;
use App\Factory\PostFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'name' => 'user',
            'email' => 'user@email.com',
            'password' => 'user',
            'roles' => ["ROLE_USER"]
        ]);
        UserFactory::createOne([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => 'admin',
            'roles' => ["ROLE_ADMIN"]
        ]);

        CategoryFactory::createMany(10);
        UserFactory::createMany(10);

        PostFactory::createMany(40, [
            'comments' => CommentFactory::new()->many(1, 4),
            'category' => CategoryFactory::random(),
            'user' => UserFactory::random()
        ]);

        $manager->flush();
    }
}
