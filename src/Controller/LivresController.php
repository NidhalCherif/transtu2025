<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Form\LivresForm;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LivresController extends AbstractController
{
    #[Route('/admin/livres/delete/{id}', name: 'admin_livres_delete')]
public function delete(EntityManagerInterface $em,Livres $livre): Response
{   $em->remove($livre);
    $em->flush();
    return $this->redirectToRoute("admin_livres");

}


    // paramConverter
    #[Route('/admin/livres/{id<\d+>}', name: 'admin_livres_detail')]
    public function detail(Livres $livre): Response
    {
        //dd($livre);
        return $this->render('livres/detail.html.twig',["livre"=>$livre]);
    }
    #[Route('/admin/livres/add', name: 'admin_livres_add')]
    public function add(EntityManagerInterface $em,Request $request): Response
    { $livre = new Livres();
        $form=$this->createForm(LivresForm::class,$livre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($livre);
            $em->flush();
            return $this->redirectToRoute("admin_livres");
        }
        return $this->render('livres/add.html.twig',["f"=>$form]);

    }
    #[Route('/livres', name: 'app_livres')]
    public function index(): Response
    {
        return $this->render('livres/index.html.twig',);
    }
    #[Route('/admin/livres', name: 'admin_livres')]
    public function lister(LivresRepository $rep): Response
    { $livres = $rep->findAll();
        //dd($livres);
        return $this->render('livres/lister.html.twig',["livres"=>$livres]);
    }



}
