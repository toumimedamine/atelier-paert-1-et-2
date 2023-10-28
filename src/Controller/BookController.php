<?php

namespace App\Controller;
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/addbook', name: 'book.add')]
    public function ajoutBook(ManagerRegistry $manager,Request $req): Response
    {
        $em = $manager->getManager();
        $book = new Book();
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('book.show');
        }
        return $this->renderForm('book/add.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/showbook', name: 'book.show')]
    public function showBook(BookRepository $repo): Response
    {
        $x = $repo->findAll();
        return $this->renderForm('book/show.html.twig', [
            'x' => $x,
        ]);
    }
    #[Route('/editbook/{id}', name: 'book.edit')]
    public function editBook(ManagerRegistry $manager,Request $req,$id,BookRepository $repo): Response
    {
        $em = $manager->getManager();
       $x = $repo->find($id);
        $form = $this->createForm(BookType::class,$x);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            $em->persist($x);
            $em->flush();
            return $this->redirectToRoute('book.show');
        }
        return $this->renderForm('book/edit.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/delbook/{id}', name: 'book.delete')]
    public function DeleteBook(BookRepository $repo,$id,ManagerRegistry $manager): Response
    {     $em = $manager->getManager();

        $x = $repo->find($id);
        $em->remove($x);
        $em->flush();
        return $this->redirectToRoute('book.show');
    }
    #[Route('/redbook', name: 'book.red')]
    public function red(): Response
    {   return $this->redirectToRoute('book.add');
    }
}
