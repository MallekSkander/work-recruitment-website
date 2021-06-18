<?php

namespace QCMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('QCMBundle:Default:index.html.twig');
    }

}
