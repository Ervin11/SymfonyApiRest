<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    $faker = Factory::create('fr_FR');

    $categories = ['Action', 'Sci-Fi', 'Horror', 'Thriller', 'Anime'];
    $categoriesTab = [];

    for ($i = 0; $i < sizeof($categories); $i++)
    {
      $category = new Category();
      $category->setTitle($categories[$i]);

      $categoriesTab[] = $category;

      $manager->persist($category);
    }

    $actors = [];

    for ($a = 0; $a < 10; $a++)
    {
      $people = new Actor();
      $people->setLastname($faker->lastName)
          ->setFirstname($faker->firstName)
          ->setDescription($faker->sentence)
          ->setPicture('https://randomuser.me/api/portraits/men/'.$a.'.jpg');

      $actors[] = $people;

      $manager->persist($people);
    }


    for ($b = 0; $b < 10; $b++)
    {
      $movie = new Movie();
      $movie->setTitle($faker->realText(30))
          ->setReleasedAt($faker->dateTime)
          ->setImage('http://picsum.photos/500/200?random'.$b)
          ->setSynopsis($faker->realText(200));

      $movieActors = $faker->randomElements($actors, $faker->numberBetween(0, 10));

      foreach ($movieActors as $actor)
      {
        $movie->addActor($actor);
      }

      $movieCategories = $faker->randomElements($categoriesTab, $faker->numberBetween(0, 4));

      foreach ($movieCategories as $category)
      {
        $movie->addCategory($category);
      }

      $manager->persist($movie);
    }

    $manager->flush();
  }
}
