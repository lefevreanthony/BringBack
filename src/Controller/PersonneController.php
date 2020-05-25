<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Personne;
use App\Repository\EvenementRepository;
use App\Repository\PersonneRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    /**
     * @Route("/personne", name="personne"), methods={"GET","POST"}
     */
    public function index(): Response
    {
        
        return $this->render('personne/index.html.twig');
    }
   

    /**
     * @Route("/personne/create", name="personne_create", methods={"GET","POST"})
     */
    public function create(EvenementRepository $repo, Request $request, EntityManagerInterface $em): Response
    {
       
        $personne = new Personne;
        $form = $this->createFormBuilder($personne)
            ->add('name', TextType::class)
            ->add('food', TextType::class)
            ->add('drink', TextType::class)
            ->add('memo', TextareaType::class)
            
            ->getForm()
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
            $em->persist($personne);
            $em->flush();

            return $this->redirectToRoute('personne_list', ['id' => $evenement->getId()]);
        }

        return $this->render('personne/create.html.twig', [
            'myperForm' => $form->createView(),
            
        ]);
    }
    /**
     * @Route("/personne/list", name="personne_list", methods={"GET","POST"})
     */
    public function show(PersonneRepository $perrepo): Response
    {
        
        return $this->render('personne/list.html.twig', [
            'personne' => $perrepo->findAll(),
        ]);
    }
}
