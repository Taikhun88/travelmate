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

        // handleRequest gets all data sent throught the submit action of the form
        // 
        $form->handleRequest($request);

        // We make sure that content of form is filled and valid, meaning respecting the format we expect so it grants more safety to content sent through the form
        // isSubmitted checks existence of action Submit
        // isValid checks existence of content as said previously

        if ($form->isSubmitted() && $form->isValid()) {

            // enables to upload image manually from the backoffice interface
            $imageFile = $imageUploader->upload($form, 'imgupload');
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
            return $this->redirectToRoute('backoffice_category_index');
        }

        // createView is the render of the form, it comes after createForm
        return $this->render('backoffice/category/new.html.twig', [
            'formView' => $form->createView()
        ]);
    }
}
