<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Session\Session;

#[IsGranted("ROLE_USER")]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {

        return $this->render('admin/admin.html.twig');
    }





    #[Route('/admin/insert', name: 'app_admin_insert_book')]
    public function insert_book(Connection $connection): Response
    {
        try {
            $sql = ('SELECT * FROM voltaire.book');
            $data = $connection->fetchAllAssociative($sql);
            dump($data);
            if (!empty($data)) {
                $connection->executeQuery('delete from book');
                foreach ($data as $row) {
                    $connection->insert('book', $row);
                }
            }


            // Get data from contributor table
            $sql = ('SELECT * FROM voltaire.contributor');
            $data = $connection->fetchAllAssociative($sql);
            if (!empty($data)) {
                // Delete all data in next table
                $connection->executeQuery('delete from author');
                $connection->executeQuery('delete from translator');
                $connection->executeQuery('delete from editor');
                $connection->executeQuery('delete from copyst');
                $connection->executeQuery('delete from book_author');
                $connection->executeQuery('delete from book_translator');
                $connection->executeQuery('delete from book_editor');
                $connection->executeQuery('delete from book_copyst');

                // Insert data from contributor table into for tables
                foreach ($data as $row) {
                    $connection->insert('author', $row);
                    $connection->insert('translator', $row);
                    $connection->insert('editor', $row);
                    $connection->insert('copyst', $row);
                }
                // Update the status column in the for tables
                $connection->executeQuery('UPDATE author SET status = "author"');
                $connection->executeQuery('UPDATE translator SET status = "translator"');
                $connection->executeQuery('UPDATE editor SET status = "editor"');
                $connection->executeQuery('UPDATE copyst SET status = "copyst"');
            }

            // Disable foreign key check
            $connection->exec('SET FOREIGN_KEY_CHECKS = 0');

            // Insert into book_author all contributor when status = author
            $sql = ('SELECT book_id, contributor_id from voltaire.book_contributor WHERE status = "author"');
            $data = $connection->fetchAllAssociative($sql);
            foreach ($data as $row) {
                $query = sprintf('insert into book_author (book_id,author_id) values (%s,%s)', $row['book_id'], $row['contributor_id']);
                $connection->executeQuery($query);
            }

            // Insert into book_copyst all contributor when status = copyst
            $sql = ('SELECT book_id, contributor_id from voltaire.book_contributor WHERE status = "copyste"');
            $data = $connection->fetchAllAssociative($sql);
            foreach ($data as $row) {
                $query = sprintf('insert into book_copyst (book_id,copyst_id) values (%s,%s)', $row['book_id'], $row['contributor_id']);
                $connection->executeQuery($query);
            }

            // Insert into book_editor all contributor when status = editor
            $sql = ('SELECT book_id, contributor_id from voltaire.book_contributor WHERE status = "editor"');
            $data = $connection->fetchAllAssociative($sql);
            foreach ($data as $row) {
                $query = sprintf('insert into book_editor (book_id,editor_id) values (%s,%s)', $row['book_id'], $row['contributor_id']);
                $connection->executeQuery($query);
            }

            // Insert into book_translator all contributor when status = translator
            $sql = ('SELECT book_id, contributor_id from voltaire.book_contributor WHERE status = "translator"');
            $data = $connection->fetchAllAssociative($sql);
            foreach ($data as $row) {
                $query = sprintf('insert into book_translator (book_id,translator_id) values (%s,%s)', $row['book_id'], $row['contributor_id']);
                $connection->executeQuery($query);
            }

            // Insert into book_classification 
            $sql = ('SELECT book_id,id from voltaire.classification 
                inner JOIN classification on voltaire.classification.description = db_voltaire.classification.description');
            $data = $connection->fetchAllAssociative($sql);
            $connection->exec('SET FOREIGN_KEY_CHECKS = 0');
            if (!empty($data)) {
                $connection->executeQuery('delete from book_classification');
                foreach ($data as $row) {
                    $query = sprintf('insert into book_classification (book_id,classification_id) values (%s,%s)', $row['book_id'], $row['id']);
                    $connection->executeQuery($query);
                }
            }
            $connection->commit();

        } catch (Exception $e) {
            // Handle any exceptions that occurred during the process
            // $connection->rollBack();
            $this->addFlash('danger', 'An error occurred while inserting data: ' . $e->getMessage());
        }
        return $this->redirectToRoute('app_admin');
    }
}
