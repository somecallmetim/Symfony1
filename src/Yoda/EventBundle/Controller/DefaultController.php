<?php

namespace Yoda\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name, $count)
    {
        return $this->render(
            'EventBundle:Default:index.html.twig',
            array('name' => $name, 'count' => $count)
        );
    }
}
