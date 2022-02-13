<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use App\Repository\ContactRepository;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request): Response
    {


        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

        /**
     * @Route("/contact-list", name="contact_list")
     */
    public function contactList(ContactRepository $contactRepository)
    {   
        $contact = $contactRepository->findAll();
        dump($contact); die;
    }

    public function AddMessage(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('');
        }
    }
}
