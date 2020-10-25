<?php

namespace App\Controller;

use Doctrine\Migrations\Query\Query;
use App\Entity\Book;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    /**
     * @Route("/", name="book")
     */
    public function index()
    {
        $query = $this->getDoctrine()->getRepository(Book::class)
        ->createQueryBuilder('b');

        $books = $query->getQuery()->getResult();
        // the `render()` method returns a `Response` object with the
        // contents created by the template

        return $this->render('book/index.html.twig', [
            'books' => $books]);
    }
  
    // /**
    //  * @Route("/book/create", name="book_create")
    //  */

    // public function createBook(): Response
    // {
   
    //     // you can fetch the EntityManager via $this->getDoctrine()
    //     // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
    //     $entityManager = $this->getDoctrine()->getManager();

    //     $book = new Book();
    //     $book->setTitle('The old man and the sea');
    //     $book->setYear(1999);
    //     $book->setAuthor('Ernest Hemingway');

    //     // tell Doctrine you want to (eventually) save the Product (no queries yet)
    //     $entityManager->persist($book);

    //     // actually executes the queries (i.e. the INSERT query)
    //     $entityManager->flush();

    //     return new Response('Saved new product with id '.$book->getId());
    // }

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
     $params = $request->request->all();
 
    if ($request->isMethod('POST')) {
        $id = $request->request->get('id');
    }

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

     return new Response(json_encode(array('response' => 'success')));
     // return $this->redirectToRoute('book_show', ;
     // ])
 
    }
 
    /**
    * @Route("/delete/{id}", name="book_delete")
    */

public function delete($id){

    $entityManager = $this->getDoctrine()->getManager();
    $book = $entityManager->getRepository(Book::class)->find($id);
    $entityManager->remove($book);
    $entityManager->flush();
}

    /**
     * @Route("/add", name="book_add")
     */
    public function add(){
    
    $entityManager = $this->getDoctrine()->getManager();

    $book = new Book();

    $form = $this->createFormBuilder($book)
            ->add('task', TextType::class)
            ->add('author',TextType::class)
            ->add('year', IntegerType::class)
            ->add('save', SubmitType::class)
            ->getForm();

    return $this->render('book/addd.html.twig', [
        'form' => $form->createView(),
    ]);

}


// /**
//      * @Route("/form", name="book_form")
//      */
// public function newForn(Request $request, $id)
//     {
//         $entityManager = $this->getDoctrine()->getManager();
//         $book = $entityManager->getRepository(Book::class)->find($id);

//         $form = $this->createFormBuilder($book)
//             ->add('title', TextType::class)
//             ->add('author', EmailType::class)
//             ->add('year', TextareaType::class)
//             ->add('send', SubmitType::class)
//             ->getForm();
    
//         $form->handleRequest($request);
    
//         if ($form->isSubmitted() && $form->isValid()) {
//             // data is an array with "name", "email", and "message" keys
//             $data = $form->getData();
//         }
//     }
}