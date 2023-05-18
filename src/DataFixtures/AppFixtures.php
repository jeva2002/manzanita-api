<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Factory\CategoryFactory;
use App\Factory\ProductFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // //instanciar
        // $category = new Category();
        // $product = new Product();

        // //configurar
        // $category->setName('CategoriaPrueba');
        // $category->setImg('asdasdasdasdasd');
        // $category->setProductType('tipo');
        // $category->addProduct($product);

        // $product->setName('productoPrueba');
        // $product->setColor(['#333']);
        // $product->setSizes(['XL']);
        // $product->setPrice(3000);
        // $product->setImg("dasdasdsasdadsdasd");
        // $product->setCategory($category);

        // //preparar
        // $manager->persist($product);
        // $manager->persist($category);

        // //guardar
        // $manager->flush();

        ProductFactory::createMany(20);
    }
}
