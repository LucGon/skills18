<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Messages;
use App\Entity\Users;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function main()
    {
        $entityManager = $this->getDoctrine()->getManager();
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'messages' => $entityManager->getRepository(Messages::Class)->findAll(),
            'users' => $entityManager->getRepository(Users::Class)->findAll()
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function search()
    {
        $em = $this->getDoctrine()->getManager();
        $resultado = $em->getRepository(Users::class)->findOneBy(['name' => $_POST['search']]);
        if ($resultado) {
            $messages = $em->getRepository(Messages::class)->findBy(['author' => $resultado->getId()]);
            $search =  [$resultado, $messages];
        } else {
            $search = false;
        }
        return $this->render('main/search.html.twig', [
            'controller_name' => 'MainController',
            'users' => $em->getRepository(Users::Class)->findAll(),
            'search' => $search
        ]);
    }
}