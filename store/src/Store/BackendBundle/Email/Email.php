<?php
namespace Store\BackendBundle\Email;

/**
 * Class Email
 * @package Store\BackendBundle\Email
 */
class Email {

    /**
     * @var \Twig_Environment Twig Template Engine
     */
    protected $twig;

    /**
     * Constructeur de ma classe email
     * J'ai besoin du service Swift Mailer et du service Twig
     *
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $twig
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig){
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     *  Fonction qui envoi un mail à un utilisateur
     */
    public function send(){

        $message = \Swift_Message::newInstance()
            ->setSubject('Test Email')
            ->setFrom('phv@philiaweb.com')
            ->setTo('phv@philiaweb.com')
            ->setContentType('Text/html')
            ->setBody( // le corps du mail qui sera une vue en twig
                $this->twig->render('StoreBackendBundle:Email:email.html.twig')
            );
        $this->mailer->send($message);
        // Utilise le service Mailer et envoie mon email
        // avec la méthode send()

    }


} 