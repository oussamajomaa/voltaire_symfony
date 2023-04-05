<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_ADMIN")]
class UserController extends AbstractController
{
    #[Route('/user/{page<\d+>?1}', name: 'app_user')]
    public function user(UserRepository $repo,
        $page,
        Request $request,
        Session $session,
        PaginatorInterface $paginator,
    ): Response
    {
        if ($page) $session->set('page',$page);
        $users = $repo->findAll();
        $data = $paginator->paginate($users, $page, 3);
        return $this->render('user/user.html.twig', [
            'users' => $data,
        ]);
    }

    #[Route('/user/edit/{id}', name: 'app_user_edit')]
    public function edit(Request $request, User $user, EntityManagerInterface $manager, Session $session): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $role = $user->getRoles()[0];
        if ($form->isSubmitted() && $form->isValid()) {
            $role=$form['roles']->getData();
            if ($role != null and $role != 'ROLE_USER'){
                $user->setRoles([$role]);
            }
        
            $manager->persist($user);
            $manager->flush();
            $this->addFlash("success","{$user->getEmail()} was edited successfully");
            $page = $session->get('page');
            return $this->redirectToRoute('app_user', ['page'=>$page]);
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'role'  => $role
        ]);
    }

    #[Route('/user/delete/{id}', name: 'app_user_delete')]
    public function delete(
        User $user,
        EntityManagerInterface $manager
    ): Response {
        $email = $user->getEmail();
        $manager->remove($user);
        $manager->flush();
        $this->addFlash("danger","User $email was deleted successfully");
        return $this->redirectToRoute('app_user');
    }
}
