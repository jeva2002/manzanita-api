<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    #[Route('/products/create', name: 'create_product', methods: 'POST')]
    public function create_product(): Response
    {
        return new Response(
            '<body>desde el id</body>'
        );
    }

    #[Route('/products/{id}/edit', name: 'update_product', methods: 'PUT')]
    public function update_product(string $id): Response
    {
        return new Response(
            '<body>desde el id</body>'
        );
    }

    #[Route('/products/{id}/delete', name: 'delete_product', methods: 'DELETE')]
    public function delete_product(string $id): Response
    {
        return new Response(
            '<body>desde el id</body>'
        );
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
