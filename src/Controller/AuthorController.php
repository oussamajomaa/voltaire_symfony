<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Copyst;
use App\Entity\Editor;
use App\Entity\Translator;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted("ROLE_USER")]
class AuthorController extends AbstractController
{
    #[Route('/author/{page<\d+>?1}/{order?}/{column?}', name: 'app_author')]
    public function author(
        $page, $order, $column,
        Request $request,
        Session $session,
        AuthorRepository $repo,
        PaginatorInterface $paginator): Response
    {
        $session->remove('search');
        // Store page number in session
        if ($page) $session->set('page',$page);
        dump($order, $column);
        // Get request search and store it in session
        $search = $request->query->get('search');
        if (!empty($search)) {
            $session->set('search', $request->query->get('search'));
        }

        if ($column == 'first_name' or $column == null){
            $authors = $repo->findByNameOrderFirst($search,$order);
        }
        if ($column == 'last_name' ){
            $authors = $repo->findByNameOrderLast($search,$order);
        }
        $data = $paginator->paginate($authors, $page, 10);
        return $this->render('author/author.html.twig', [
            'authors' => $data,
        ]);
    }

    #[Route('/author/new', name: 'app_author_new')]
    public function new(Request $request, EntityManagerInterface $manager, Session $session): Response
    {
        $session->remove('search');
        $author = new Author();
        $editor = new Editor();
        $copyst = new Copyst();
        $translator = new Translator();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $first_name = $form->get('first_name')->getData();
            $last_name = $form->get('last_name')->getData();
            $link_viaf = $form->get('link_viaf')->getData();
            
            $notes = $form->get('notes')->getData();
            if (empty($first_name) and (empty($last_name))){
                $this->addFlash("warning","First name or Last name cannot be empty");
                return $this->render('author/new.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
            $editor->setFirstName($first_name)
                ->setLastName($last_name)
                ->setLinkViaf($link_viaf)
                ->setNotes($notes)
                ->setStatus("editor")
                ;
            $copyst->setFirstName($first_name)
                ->setLastName($last_name)
                ->setLinkViaf($link_viaf)
                ->setNotes($notes)
                ->setStatus("copyst")
                ;
            $translator->setFirstName($first_name)
                ->setLastName($last_name)
                ->setLinkViaf($link_viaf)
                ->setNotes($notes)
                ->setStatus("translator")
                ;
            $manager->persist($author);
            $manager->persist($editor);
            $manager->persist($copyst);
            $manager->persist($translator);
            $manager->flush();
            $this->addFlash("success","{$author->getLastName()} {$author->getFirstName()} was added successfully");
            return $this->redirectToRoute('app_author');
        }
        return $this->render('author/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/author/edit/{id}', name: 'app_author_edit')]
    public function edit(
        Author $author,
        Copyst $copyst,
        Editor $editor,
        Translator $translator,
        Request $request,
        Session $session,
        EntityManagerInterface $manager): Response
    {
        // $session->remove('search');
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $first_name = $form->get('first_name')->getData();
            $last_name = $form->get('last_name')->getData();
            $link_viaf = $form->get('link_viaf')->getData();
            $notes = $form->get('notes')->getData();
            if (empty($first_name) and (empty($last_name))){
                $this->addFlash("warning","First name or Last name cannot be empty");
                return $this->render('author/new.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
            $editor->setFirstName($first_name)
                ->setLastName($last_name)
                ->setLinkViaf($link_viaf)
                ->setNotes($notes)
                ;
            $copyst->setFirstName($first_name)
                ->setLastName($last_name)
                ->setLinkViaf($link_viaf)
                ->setNotes($notes)
                ;
            $translator->setFirstName($first_name)
                ->setLastName($last_name)
                ->setLinkViaf($link_viaf)
                ->setNotes($notes)
                ;
            $manager->persist($author);
            $manager->persist($editor);
            $manager->persist($copyst);
            $manager->persist($translator);
            $manager->flush();

            $page = $session->get('page');
            $search = $session->get('search');
            $this->addFlash("success","{$author->getLastName()} {$author->getFirstName()} was modified successfully");
            return $this->redirectToRoute('app_author', ['search' => $search,'page'=>$page]);
        }
        return $this->render('author/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/author/delete/{id}', name: 'app_author_delete')]
    public function delete(
        Author $author,
        Copyst $copyst,
        Editor $editor,
        Translator $translator,
        EntityManagerInterface $manager
    ): Response {
        $name = $author->getFirstName() . ' '. $author->getLastName();
        $manager->remove($author);
        $manager->remove($copyst);
        $manager->remove($editor);
        $manager->remove($translator);
        $manager->flush();

        $this->addFlash("danger","$name was deleted successfully");
        return $this->redirectToRoute('app_author');
    }

    
    // Clear search value
    #[Route('/author/clear', name: 'app_author_clear')]
    public function clear(Session $session){
        $session->clear('search');
        return $this->redirectToRoute('app_author');
    }
}
