<?php

namespace Miky\Bundle\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MikyCalendarBundle:Default:index.html.twig');
    }
}
