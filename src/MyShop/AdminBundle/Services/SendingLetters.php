<?php

namespace MyShop\AdminBundle\Services;



class SendingLetters
{
    private $photoDir;

    private $mailer;

    private $twig;

    public function __construct($photoDir,  $mailer, $twig)
    {
        $this->photoDir=$photoDir;
        $this->mailer=$mailer;
        $this->twig=$twig;
    }

    public function sendLetter($email, $mes, $photo=null)
    {
        $message=new \Swift_Message();
        $message->setTo($email);
        $message->setFrom('myshop@mail.ru');
        $message->setSubject("MyShop");
        $html=$this->twig->render("MyShopAdminBundle:Email:email.html.twig", array("mas"=>$mes,"photo"=>$photo));
        $message->setBody($html,'text/html');
        if($photo!=null) {
            $message->attach(\Swift_Attachment::fromPath($this->photoDir."small/".$photo));
        }
        $this->mailer->send($message);
    }

    public function sendLetterToCustomer($email, $mes)
    {
        $message=new \Swift_Message();
        $message->setTo($email);
        $message->setFrom('myshop@mail.ru');
        $message->setSubject("MyShop");
        $html=$this->twig->render("MyShopDefBundle:Email:emailCustomer.html.twig",array("link"=>$mes));
        $message->setBody($html,'text/html');
        $this->mailer->send($message);
    }
}