<?php

namespace MyShop\AdminBundle\Services;


class SendingLetters
{
    private $photoDir;

    public function __construct($photoDir)
    {
        $this->photoDir=$photoDir;
    }

    public function sendLetter($mail, $mes, $photo=null)
    {
        $message=new \Swift_Message();

        $message->setTo($mail);
        $message->setFrom('myshop@mail.ru');
        $message->setBody($mes,'text/html');
        if($photo!=null)
        {
            $message->attach(\Swift_Attachment::fromPath($this->photoDir.$photo));
        }
        return $message;

    }


}