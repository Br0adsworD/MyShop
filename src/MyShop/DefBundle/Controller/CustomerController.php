<?php

namespace MyShop\DefBundle\Controller;


use MyShop\DefBundle\Entity\Customer;
use MyShop\DefBundle\Form\CustomerType;
use Symfony\Component\HttpFoundation\Request;
use MyShop\AdminBundle\Controller\MyController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CustomerController extends MyController
{
    /**
     * @Template()
     */
    public function loginCustomerAction()
    {
        return [];
    }

    /**
     * @Template()
     */
    public function registrationCustomerAction(Request $request)
    {
        $customer=new Customer();
        $form=$this->createForm(CustomerType::class,$customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $password=$this->get('security.password_encoder')->encodePassword($customer,$customer->getPlainPassword());
            $customer->setPassword($password);
            $manager=$this->getDoctrine()->getManager();
            $manager->persist($customer);
            $manager->flush();

            $this->addFlash('info','Спасибо за Регистрацию');
            return $this->redirectToRoute('showAll');
        }
        return ['form'=>$form->createView()];
    }
}