<?php

namespace App\Controller;

use Doctrine\Migrations\Query\Query;
use App\Entity\Book;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BookController extends AbstractController
{
    /**
     * @Route("/", name="book")
     */
    public function index()
    {
       
        $books =$this->getDoctrine()->getRepository(Book::class)->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books]);
    }
  
    

    /**
     * @Route("/edit/{id}", name="book_edit")
     */
   public function edit(int $id)
   {
    $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );}

            return $this->render('book/single.html.twig', ['book' => $book]);
   }

    /**
    * @Route("/update/{id}", name="book_update", methods={"GET","POST"})
    */

    public function update(Request $request, $id):Response
    {
     
    // if ($request->isMethod('POST')) {
    //     $id = $request->request->get('id');
    // }

    $author = $request->request->get('author');
    $title = $request->request->get('title');
    $year = $request->request->get('year');
 
     $entityManager = $this->getDoctrine()->getManager();
     $book = $entityManager->getRepository(Book::class)->find($id);
 
     $book->setTitle($title);
     $book->setAuthor($author);
     $book->setYear($year);
 
     $entityManager->persist($book);
 
     $entityManager->flush();

     return new Response(json_encode(['response' => 'Отредактировано']));
    }
 

    /**
     * @Route("/add", name="book_add")
     */
    public function add(){

    return $this->render('book/add.html.twig');
    }

   /**
     * @Route("/addForm", methods={"GET","POST"})
     */

    public function addForm(Request $request):Response
    {
    
    $author = $request->request->get('author');
    $title = $request->request->get('title');
    $year = $request->request->get('year');

    $book = new Book();

    $entityManager = $this->getDoctrine()->getManager();

     $book->setTitle($title);
     $book->setAuthor($author);
     $book->setYear($year);

    $entityManager->persist($book);

    $entityManager->flush();

    return new Response(json_encode(['result' => 'Добавлено']));
}

}