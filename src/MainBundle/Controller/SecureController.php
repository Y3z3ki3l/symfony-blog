<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * Secure controller.
 *
 * @Route("secure")
 */
class SecureController extends Controller
{
	/**
     * Main secure page
     *
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {	


    	return [];
    }
}
