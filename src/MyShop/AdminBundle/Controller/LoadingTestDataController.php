<?php

namespace MyShop\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoadingTestDataController extends Controller
{
    public function loadingAdminAction()
    {
        $this->get("loadingTestData")->loadingAdmin();
        $this->addFlash("info","Test admin added");
        return $this->redirectToRoute("show");
    }

    public function loadingProductAction()
    {
        $this->get("loadingTestData")->loadingProduct();
        $this->addFlash("info","Test product added");
        return $this->redirectToRoute("show");
    }
}