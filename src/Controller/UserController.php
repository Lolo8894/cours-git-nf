<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="user_register", methods={"GET", "POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        // j'initialise un objet vide représentant l'utilisateur
        $user = new User();
        // je crée un objet formulaire possédant les propriétés de RegisterType
        $form = $this->createForm(RegisterType::class, $user);
        // j'handle la request, c'est à dire que je fais en sorte que les données de mon formulaire
        // soit automatiquement rempli grâce aux données présent dans le request
        // pour rappel dans le request nous avons toutes les données de type $_POST, $_GET, $_SESSION, $_COOKIE etc...
        $form->handleRequest($request);

        // c'est la partie réservé au POST, c'est à dire à la soumission du formulaire
        // Si le formulaire est soumis et valide
        if($form->isSubmitted() && $form->isValid()) {
            // j'appelle mon gestionnaire d'entité (les models)
            $em = $this->getDoctrine()->getManager();
            // J'encode le mode de passe envoyé par l'utilisateur et je le stocke dans une variable
            $passwordEncode = $userPasswordEncoderInterface->encodePassword($user, $user->getPassword());
            // je remplace la valeur entrée par l'utilisateur pour la mettre par une valeur cryptée
            $user->setPassword($passwordEncode);
            // je prépare mon objet pour qu'il puisse être poussé en base de donnée
            $em->persist($user);
            // je pousse mon objet en base de données
            $em->flush();
        }

        // j'affiche la vue en lui envoyant la vue du formulaire
        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    
}
