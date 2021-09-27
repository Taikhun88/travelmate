<?php

namespace App\Controller\Backoffice;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Group the route, gives a suffix to all routes created within the class
 * 
 * @Route("/backoffice/category", name="backoffice_category_")
 */
class CategoryController extends AbstractController
{
    /**
     * Displays a list of all the categories of Events
     * 
     * URL : /backoffice/category/
     * Route : backoffice_category_index
     * 
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        // Uses the category repository to find all data related to categories in database then displays them on twig file as such below
        return $this->render('backoffice/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * Page enables creation of a new Category
     * 
     * @Route("/new", name="new", methods={"GET", "POST"})
     *
     * @return Response
     */
    public function new(Request $request, SluggerInterface $slugger, ImageUploader $imageUploader): Response
    {
        // We start to instantiate an empty object of Category to fill it
        $category = new Category();

        // As we use different fields of properties contained in Category entity, we create a form with the command
        // createForm links the category entity to the form type Category, so all properties are contained in it. Form can be customized
        $form = $this->createForm(CategoryType::class, $category);

        // handleRequest gets all data sent through the submit action of the form
        // 
        $form->handleRequest($request);

        // We make sure that content of form is filled and valid, meaning respecting the format we expect so it grants more safety to content sent through the form
        // isSubmitted checks existence of action Submit
        // isValid checks existence of content as said previously

        if ($form->isSubmitted() && $form->isValid()) {

            // enables to upload image manually from the backoffice interface
            $imageFile = $imageUploader->upload($form, 'image');
            if ($imageFile) {
                $category->setImage($imageFile);
            }

            $nameCategory = $category->getName();

            $slug = $slugger->slug(strtolower($nameCategory));

            $category->setName($slug);

            // We call the manager to get new data presaved with persist then we save them permanently with flush within the object filled thanks to the variable
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();


            // addFlash will display a message at the top of the page each time we succesfully create a new Category
            $this->addFlash('success', 'La nouvelle catégorie ' . $category->getName() . ' a bien été créée');

            // Redirects to all categories page afterwards
            return $this->redirectToRoute('backoffice_category_index', [], Response::HTTP_SEE_OTHER);
        }

        // createView is the render of the form, it comes after createForm
        return $this->render('backoffice/category/new.html.twig', [
            'formView' => $form->createView()
        ]);
    }

    /**
     * Displays details of the categories
     * 
     * URL : /backoffice/category/{id}
     * Route : backoffice_category_show
     * 
     * @Route("/{id}", name="show", methods={"GET"})
     *
     * @return Response
     */
    public function show(int $id, CategoryRepository $categoryRepository)
    {
        // use the method find to get the ID which is typehinted as int
        $category = $categoryRepository->find($id);

        // Checks existence of the ID if not throw will display the custom error message
        if (!$category) {
            throw $this->createNotFoundException('La catégorie d\'événement recherché ' . $id . ' n\'existe pas');
        }

        // Category $category ==> $category = $categoryRepository->find($id)
        return $this->render('backoffice/category/show.html.twig', [
            'categories' => $category
        ]);
    }

    /**
     * Enables to upload the details of category
     * 
     * URL : /backoffice/category/{id}/edit
     * 
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     *
     * @return Response
     */
    public function edit(Category $category, Request $request, ImageUploader $imageUploader): Response
    {
        $form = $this->createForm(CategoryType::class, $category);

        // We call the method handle of createForm so we can get, retrieve request data submitted through the categorytype form
        $form->handleRequest($request);

        // Checks existence AND valid content submitted via form
        if ($form->isSubmitted() && $form->isValid()) {
            // Updates data by using the setters of desired fields, properties
            $imageFile = $imageUploader->upload($form, 'image');

            if ($imageFile) {
                $category->setImage($imageFile);
            }

            $this->getDoctrine()->getManager()->flush();

            // Flash displays message in case of a successful creation of the category with customised message
            $this->addFlash('success', 'La catégorie ' . $category->getName() . ' a bien été modifiée');

            // proceeds right after to the redirection basing on the id
            return $this->redirectToRoute('backoffice_category_index');
        }

        // displays the form fiels to upload new image and field to change name
        return $this->render('backoffice/category/edit.html.twig', [
            'categories' => $category,
            'form' => $form->createView()
        ]);
    }

    /**
     * Enables to delete a category based on previous ID clicked
     * 
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backoffice_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
