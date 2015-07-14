<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class AppController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
    	$user = $this->getUser();

    	$em = $this->getDoctrine()->getManager();
        $partner = $em->getRepository('AppBundle:Subscribed');
        $query = $partner->createQueryBuilder('p')
            ->where('p.groupToken = :token AND p.friendemail = :email')
            ->setParameter(':token', $user->getGroupToken())
            ->setParameter(':email', $user->getEmail())
            ->getQuery();
        $partner = $query->getResult();

        if (count($partner) == 1) {
        	$partner = $partner[0];
        }else {
            $message = 'There is not friend to match yet. Wait until your friend accept the match';
            return $this->render('Errors/error.html.twig', array('message' => $message));
        }

        return array('user' => $user, 'partner' => $partner);    
    }

}
