<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\AdminBundle\Entity\Users;
use MyShop\AdminBundle\Form\UsersType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     *@Template()
     */
    public function addUserAction(Request $request)
    {
        $user=new Users();
        $form=$this->createForm(UsersType::class,$user);
        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            $plainPassword=$user->getPlainPassword();
            $user->setPassword("");
            $password=$this->get('security.password_encoder')->encodePassword($user,$plainPassword);
            $user->setPassword($password);
            $manager=$this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('show');
        }
        return ['form'=>$form->createView()];
    }

    /**
     * @Template()
     */
    public function showUsersAction()
    {
        $usersList=$this->getDoctrine()->getManager()->getRepository('MyShopAdminBundle:Users')->findAll();
        return['userList'=>$usersList];
    }
}