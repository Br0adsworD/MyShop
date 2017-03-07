<?php


namespace MyShop\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyController extends Controller
{
    public function notification($message, $photo=null)
    {
        $userEmail=$this->getUser()->getEmail();
        $mail=$this->get("myshop_admin.sending_letters");
        $mail->sendLetter($userEmail, $message, $photo);
        $logger=$this->get("logger");
        $logger->addInfo($message);
        $this->addFlash('info', $message);
    }
}