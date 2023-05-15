<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'app_api')]
class ApiController extends AbstractController
{
    #[Route('/book', name: 'app_api_book')]
    public function book(BookRepository $repoBook): Response
    {
        $books = $repoBook->findAll();
        $dataBook = [];
        foreach ($books as $key => $books){
            $dataBook[$key]['id'] = $books->getId();
            $dataBook[$key]['title'] = $books->getTitle();



            $authors = [];
            foreach ($books->getAuthor() as $k => $author) {
                $authors[$k]['first_name'] = $author->getFirstName();
                $authors[$k]['last_name'] = $author->getLastName();
                $authors[$k]['status'] = $author->getStatus();
            }
            $dataBook[$key]['authors'] = $authors;

            $translators = [];
            foreach ($books->getTranslator() as $k => $author) {
                $translators[$k]['first_name'] = $author->getFirstName();
                $translators[$k]['last_name'] = $author->getLastName();
                $translators[$k]['status'] = $author->getStatus();
            }
            $dataBook[$key]['trnaslators'] = $translators;

            $editors = [];
            foreach ($books->getEditor() as $k => $author) {
                $editors[$k]['first_name'] = $author->getFirstName();
                $editors[$k]['last_name'] = $author->getLastName();
                $editors[$k]['status'] = $author->getStatus();
            }
            $dataBook[$key]['editors'] = $editors;

            $copyst = [];
            foreach ($books->getCopyst() as $k => $author) {
                $copyst[$k]['first_name'] = $author->getFirstName();
                $copyst[$k]['last_name'] = $author->getLastName();
                $copyst[$k]['status'] = $author->getStatus();
            }
            $dataBook[$key]['copyst'] = $copyst;

            $classifications = [];
            foreach ($books->getClassification() as $k => $classification) {
                $classifications[$k]['category'] = $classification->getCategory();
                $classifications[$k]['description'] = $classification->getDescription();
            }
            $dataBook[$key]['classifications'] = $classifications;
        }
        return new JsonResponse($dataBook);
    }
}
