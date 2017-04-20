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
            $customer->setRoles(Customer::ROLE_NoActiveCustomer);
            $manager=$this->getDoctrine()->getManager();
            $hash=$customer->getEmail().$customer->getDateCreate()->format('y-m-d_H:i:s');
            $hash=hash('md5',$hash);
            $customer->setEmailHash($hash);
            $manager->persist($customer);
            $manager->flush();

            $message='http://127.0.0.1:8000/confirm/user/'.$hash;
            $this->get("myshop_admin.sending_letters")->sendLetterToCustomer($customer->getEmail(), $message);
            $this->addFlash('info','Спасибо за Регистрацию');
            return $this->redirectToRoute('showAll');
        }
        return ['form'=>$form->createView()];
    }

    public function confirmCustomerAction($hash)
    {
        $manager=$this->getDoctrine()->getManager();
        $customer=$manager->getRepository('MyShopDefBundle:Customer')->findBy(['emailHash'=>$hash]);
        if ($customer!= null)
        {
            $customer[0]->setRoles(Customer::ROLE_CUSTOMER);
            $manager->persist($customer[0]);
            $manager->flush();
            $this->addFlash('info','ok)');
            return $this->redirectToRoute("showAll");
        }
        else{
            return $this->redirectToRoute('showAll');
        }
    }
}