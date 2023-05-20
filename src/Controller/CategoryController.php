<?php

namespace App\Controller;

use App\Entity\Category;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'all_categories', methods: 'GET')]
    public function all_categories(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Category::class)->findAll();
        return $this->json(array_map(function ($category) {
            return $this->parse_category($category);
        }, $categories));
    }

    #[Route('/categories/{id}', name: 'category_by_id', methods: 'GET')]
    public function category_by_id(Category $category): Response
    {
        return $this->json($this->parse_category($category));
    }

    #[Route('/admin/categories/create', name: 'create_category', methods: 'POST')]
    public function create_category(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $category = new Category();

        $this->set_category($category, $request, $entityManager);

        return $this->json("Se ha creado la categoría con el id {$category->getId()}");
    }

    #[Route('/admin/categories/{id}/edit', name: 'update_category', methods: 'PUT')]
    public function update_category(
        Category $category,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $this->set_category($category, $request, $entityManager);
        return $this->json("Se ha actualizado la categoría con el id {$category->getId()}");
    }

    #[Route('/admin/categories/{id}/delete', name: 'delete_category', methods: 'DELETE')]
    public function delete_category(Category $category, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($category);
        $entityManager->flush();
        return $this->json("Se ha eliminado correctamente la categoría");
    }

    public function set_category(
        Category $category,
        Request $request,
        EntityManagerInterface $entityManager
    ): void {
        $body = json_decode($request->getContent(), true);

        $category->setName($body["name"]);
        $category->setImg($body["img"]);
        $category->setProductType($body["productType"]);

        $entityManager->persist($category);
        $entityManager->flush();
    }

    public function parse_category(Category $category): array
    {
        return [
            "id" => $category->getId(),
            "name" => $category->getName(),
            "productType" => $category->getProductType(),
            "img" => $category->getImg(),
        ];
    }
}
