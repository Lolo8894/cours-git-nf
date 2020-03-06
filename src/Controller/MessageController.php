<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/message")
 * @IsGranted("ROLE_USER")
 */
class MessageController extends AbstractController
{

    /**
     * Affichage de la liste complet des messages 
     * On affichera uniquement la personne qui a envoyé le message
     * et le message
     * @Route("/", methods={"GET"}, name="message_index")
     */
    public function index(MessageRepository $messageRepository)
    {
        $listOfMessages = $messageRepository->sortedByIdWithMax($this->getUser(), 5);

        return $this->render('message/index.html.twig',
            [
                'title' => 'Mes messsages',
                'messages' => $listOfMessages
            ]
        );
    }

    /**
     * Le but de cette fonction est d'indiquer toutes les infos
     * (message, date, sender, receiver, id)
     * La fonction récupère l'id et le gestionnaire de message
     * et renvoie a la vu l'objet message


    
     * @Route("/new", methods={"GET", "POST"}, name="message_new")
     */
    public function new(Request $request)
    {

        $message = new Message();
        $message->setCreatedAt(new \DateTime());
        $message->setSender($this->getUser());

        $form = $this->createForm(MessageType::class, $message);;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($message);
            $entityManager->flush();
            return $this->redirectToRoute('message_index');
        }
        return $this->render('message/new.html.twig',
        [
            'formMessage' => $form->createView()
        ]);

    }

     /**
     * @Route("/{id}/edit", name="message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, message $message)
    {
        $form = $this->createForm(messageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();            
            return $this->redirectToRoute('message_index');
        }

        return $this->render('message/new.html.twig', 
        [
            'formMessage' => $form->createView(),
        ]);
    }
       /**
     * @Route("/{id}", name="message_show", methods={"GET"})
     */
    public function show(message $message)
    {
        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }
}