<?php

namespace QcmBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    /**
     * @Route("/",name="qcm_homepage")
     */
    public function indexAction()
    {
        return $this->render('QcmBundle:Default:index.html.twig');
    }


    /**
     * @Route("/reponse",name="qcm_reponsepage")
     */
    public function reponseAction()
    {
        return $this->render('QcmBundle:Default:index.html.twig');
    }
}
