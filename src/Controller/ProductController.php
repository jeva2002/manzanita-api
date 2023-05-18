<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    #[Route('/products', name: 'all_products', methods: 'GET')]
    public function all_products(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager->getRepository(Product::class)->findAll();

        return $this->json(array_map(function ($product) {
            return $this->parse_product($product);
        }, $products));
    }

    #[Route('/products/{id}', name: 'product_by_id', methods: 'GET')]
    public function product_by_id(Product $product): Response
    {
        return $this->json($this->parse_product($product));
    }

    #[Route('/products/create', name: 'create_product', methods: ['POST', 'GET'])]
    public function create_product(
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ): Response {
        $product = new Product();
        $this->set_product($product, $request, $entityManager);
        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
        return $this->json("Se ha creado un producto con el id {$product->getId()}");
    }

    #[Route('/products/{id}/edit', name: 'update_product', methods: 'PUT')]
    public function update_product(
        Product $product,
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ): Response {
        $this->set_product($product, $request, $entityManager);
        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
        return $this->json("Se ha actualizado un producto con el id {$product->getId()}");
    }

    #[Route('/products/{id}/delete', name: 'delete_product', methods: 'DELETE')]
    public function delete_product(Product $product, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->json("El producto fue eliminado con éxito");
    }

    public function set_product(Product $product, Request $request, EntityManagerInterface $entityManager): void
    {
        $body = json_decode($request->getContent(), true);

        $product->setName($body["name"]);
        $product->setColor($body["color"]);
        $product->setSizes($body["sizes"]);
        $product->setPrice($body["price"]);
        $product->setImg($body["img"]);
        $category = $entityManager->getRepository(Category::class)->find($body["category"]);
        $product->setCategory($category);

        $entityManager->persist($product);

        $entityManager->flush();
    }

    public function parse_product(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'sizes' => $product->getSizes(),
            'colors' => $product->getColor(),
            'price' => $product->getPrice(),
            'img' => $product->getImg(),
            'category' => $product->getCategory()->getId(),
        ];
    }
}
