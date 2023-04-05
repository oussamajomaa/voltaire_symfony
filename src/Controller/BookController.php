<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted("ROLE_USER")]
class BookController extends AbstractController
{
    #[Route('/book/{page<\d+>?1}/{order?}/{column?}', name: 'app_book')]
    public function book(
        $page, $order, $column,
        Request $request,
        Session $session,
        PaginatorInterface $paginator,
        BookRepository $repo): Response
    {
        
        $session->remove('search');
        // Store page number in session
        if ($page) $session->set('page',$page);
        // Get request search and store it in session
        $search = $request->query->get('search');
        if (!empty($search)) {
            $session->set('search', $request->query->get('search'));
        }
        if ($column == 'title' or $column == null){
            $books = $repo->findByTitleOrder($search,$order);
        }
        if ($column == 'source'){
            $books = $repo->findBySourceOrder($search,$order);
        }
        if ($column == 'notes'){
            $books = $repo->findByNoteseOrder($search,$order);
        }
        
        $data = $paginator->paginate($books, $page, 10);
        return $this->render('book/book.html.twig', [
            'books' => $data,
        ]);
    }

    #[Route('/book/new', name: 'app_book_new')]
    public function new(Request $request,
        EntityManagerInterface $manager, 
        Session $session): Response
    {
        $session->remove('search');
        $book = new Book();
        $classifications = $book->getClassification();
        dump($classifications);
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($book);
            
            $manager->flush();
            
            $this->addFlash("success","{$book->getTitle()} was added successfully");
            return $this->redirectToRoute('app_book');
        }
        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/book/edit/{id}', name: 'app_book_edit')]
    public function edit(
        Book $book,
        Request $request,
        EntityManagerInterface $manager,
        Session $session): Response
    {

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($book);
            
            $manager->flush();
            $page = $session->get('page');
            $search = $session->get('search');
            $this->addFlash("success","{$book->getTitle()} was edited successfully");
            return $this->redirectToRoute('app_book', ['search' => $search,'page'=>$page]);
        }
        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Clear search value
    #[Route('/book/clear', name: 'app_book_clear')]
    public function clear(Session $session){
        $session->clear('search');
        return $this->redirectToRoute('app_book');
    }
}
