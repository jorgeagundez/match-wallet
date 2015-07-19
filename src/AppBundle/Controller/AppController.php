<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Subscribed;

class AppController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
    	$user = $this->getUser();

        $groupToken = $user->getGroupToken();
        $friendEmail = $user->getEmail();

    	$em = $this->getDoctrine()->getManager();
        $partner = $em->getRepository('AppBundle:Subscribed');
        $query = $partner->createQueryBuilder('p')
            ->where('p.groupToken = :token AND p.friendemail = :email')
            ->setParameter(':token',  $groupToken)
            ->setParameter(':email', $friendEmail)
            ->getQuery();
        $partner = $query->getResult();


        if (count($partner) == 1) {
        	$partner = $partner[0];
        }else {
            $message = 'Waiting for your friend to accept the match';
            return $this->render('Errors/error.html.twig', array('message' => $message));
        }

        return array('user' => $user, 'partner' => $partner);    
    }


    /**
     * @Route("/match/{user}/{partner}")
     * @ParamConverter("user", class="AppBundle:Subscribed")
     * @ParamConverter("partner", class="AppBundle:Subscribed")
     * @Template()
     */
    public function matchAction(Request $request, $user, $partner)
    {

        $em = $this->getDoctrine()->getManager();
        $useritems = $em->getRepository('AppBundle:Item')->findByCreatedBy($user->getId());
        $partneritems = $em->getRepository('AppBundle:Item')->findByCreatedBy($partner->getId());

        foreach ($useritems as $item) {
            $em->remove($item);
            $em->flush();
        }
           
        foreach ($partneritems as $item) {
            $em->remove($item);
            $em->flush();
        }
      
        return $this->redirectToRoute('app_app_index');
    }

}
