<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{



    #[Route('/showauthor', name: 'author.show')]
    public function showAuthor(AuthorRepository $authorRepo): Response
    {
        $x = $authorRepo->findAll();

        return $this->render('author/show.html.twig', [
            'authors' => $x,
        ]);
    }

    #[Route('/addstatic', name: 'author.addstatic')]
    public function addStaticAuthor(ManagerRegistry $manager): Response
    {
        $em = $manager->getManager();
        $author = new Author();
        $author->setUsername("ahmed");
        $author->setEmail("ahmed@gmail.com");
        $em->persist($author);
        $em->flush();

        return new Response('ajout avec succée ');
    }

    #[Route('/addAuthor', name: 'author.add')]
    public function addAuthor(ManagerRegistry $manager, Request $req): Response
    {
        $em = $manager->getManager();
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($req);

        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('author.show');
        }

        return $this->renderForm('author/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/editAuthor/{id}', name: 'author.edit')]
    public function editAuthor($id, ManagerRegistry $manager, Request $req, AuthorRepository $authorRepo): Response
    {
        $em = $manager->getManager();
        $idData = $authorRepo->find($id);

        $form = $this->createForm(AuthorType::class, $idData);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($idData);
            $em->flush();
            return $this->redirectToRoute('author.show');
        }

        return $this->renderForm('author/edit.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/deleteAuthor/{id}', name: 'author.delete')]
    public function DeleteAuthor($id, ManagerRegistry $manager, AuthorRepository $authorRepo): Response
    {
        $em = $manager->getManager();
        $idData = $authorRepo->find($id);
        $em->remove($idData);
        $em->flush();


        return $this->redirectToRoute('author.show');
    }
    #[Route('/orderAuthor', name: 'author.order')]
    public function Order( AuthorRepository $authorRepo): Response
    {

        $idData = $authorRepo->OrderByDesc1();


       return $this->render('author/index.html.twig',
        [   'authors' => $idData
        ]);

    }
    #[Route('/showbyid/{id}', name: 'author.byid')]
    public function showById( AuthorRepository $authorRepo,$id): Response
    {

        $idData = $authorRepo->showBookAuthor($id);
          dd($idData);

        return $this->render('author/showby.html.twig',
            [   'authors' => $idData
            ]);

    }

}
