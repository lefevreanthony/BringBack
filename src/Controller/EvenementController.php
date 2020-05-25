<?php

namespace App\Controller;
use App\Entity\Personne;
use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement", methods={"GET"})
     */
    public function index(EvenementRepository $repo): Response
    {
        return $this->render('evenement/index.html.twig',[
            'evenement' => $repo->findAll(),
        ]);
    }
    /**
     * @Route("/evenement/create", name="evenement_create", methods={"GET","POST"})
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
    
        $evenement = new Evenement;
        $form = $this->createFormBuilder($evenement)
            ->add('name', TextType::class)
            ->add('place', TextType::class)
            ->add('whattime', DateType::class)
            ->getForm()
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($evenement);
            $em->flush();

            return $this->redirectToRoute('personne_list', ['id' => $evenement->getId()]);
        }

        return $this->render('evenement/create.html.twig', [
            'myForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/evenement/list/{id<[0-9]+>}", name="evenement_list")
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/list.html.twig', compact('evenement'));
    }

}
