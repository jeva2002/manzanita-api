<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register', methods: 'POST')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();

        $body = json_decode($request->getContent(), true);

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $body['password']
        );

        $user->setEmail($body['username']);
        $user->setPassword($hashedPassword);
        $user->setRoles(["ROLE_ADMIN"]);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json('Se ha creado correctamente un usuario');
    }
}
