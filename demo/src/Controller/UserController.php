<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    public function __construct(
        private UserService $userService,
    ) {}

    #[Route('/', name: 'user_list')]
    public function index(Request $request): Response
    {
        $search = $request->query->get('search', '');

        if ($search) {
            $users = $this->userService->searchUsers($search);
        } else {
            $users = $this->userService->getAllUsers();
        }

        return $this->render('user/index.html.twig', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    #[Route('/user/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $role = $request->request->get('role', 'user');

            $this->userService->createUser($username, $email, $password, $role);

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/new.html.twig');
    }

    #[Route('/user/{id}', name: 'user_show')]
    public function show(int $id): Response
    {
        $user = $this->userService->getUserById($id);

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/{id}/toggle', name: 'user_toggle', methods: ['POST'])]
    public function toggle(int $id): Response
    {
        $this->userService->toggleUserStatus($id);

        return $this->redirectToRoute('user_list');
    }

    #[Route('/user/{id}/delete', name: 'user_delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        $this->userService->deleteUser($id);

        return $this->redirectToRoute('user_list');
    }

    #[Route('/user/{id}/role', name: 'user_role', methods: ['POST'])]
    public function changeRole(int $id, Request $request): Response
    {
        $role = $request->request->get('role');
        $this->userService->changeRole($id, $role);

        return $this->redirectToRoute('user_show', ['id' => $id]);
    }
}
