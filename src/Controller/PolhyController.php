<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;
use App\Form\ContactType;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;

class PolhyController extends Controller
{
    /**
     * @Route("/", name="polhy")
     */
    public function index(KernelInterface $kernel, Request $request, \Swift_Mailer $mailer)
    {
        $values = Yaml::parseFile($kernel->getProjectDir().'/public/polhy.yml');

        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        $success = false;
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $success = true;

            $message = (new \Swift_Message('Nouveau contact site internet'))
            ->setFrom('nozutbm@gmail.com')
            ->setTo('polhy.entertainment@gmail.com')
            ->setBody(
                "Contenu du message : <br/>"
                .$contact->getContent() . "<br/>"
                ."Address email du contact : ".$contact->getEmail(),
                'text/html'
            )
        ;
    
        $mailer->send($message);
    
        }

        return $this->render('polhy/index.html.twig', $values +
        [
            'form' => $form->createView(),
            'success' => $success
        ]);
    }
}
