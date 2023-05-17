<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'all_products', methods: 'GET')]
    public function all_products(Request $request): Response
    {
        return $this->json($request);
    }

    #[Route('/products/{id}', name: 'product_by_id', methods: 'GET')]
    public function product_by_id(string $id): Response
    {
        return new Response(
            $id
        );
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
}
