<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class InvitationController extends Controller
{
    /**
     * @Route("/invitation/invite-to")
     * @Template()
     */
    public function invitetoAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createFormBuilder($user)
            ->add('friendemail', 'email', array('label' => false, 'attr' => array( 'placeholder' => 'Tip Email here' ) ))
            ->add('send', 'submit', array('label' => 'Invite Friend', 'attr' => array('class' => 'btn-success' )))
            ->getForm();

        $form->handleRequest($request);
      
        if ($form->isValid()) {

            $friendemail = $request->request->get('form')['friendemail'];

            $token = md5( uniqid('auth', true) );
            $groupToken = substr($token, 0, 8);

            $user->setGroupToken($groupToken);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('Join Match Wallet App')
                ->setFrom($user->getEmail())
                ->setTo($friendemail)
                ->setBody($this->renderView('Emails/inviteto-email.html.twig', array('grouptoken' => $groupToken, 'username' => $user->getUsername() )),'text/html');
            
            $this->get('mailer')->send($message);
            return $this->redirectToRoute('app_app_index');
        }

        return array('form' => $form->createView());    
    }

    /**
     * @Route("/invitation/invited-by")
     * @Template()
     */
    public function invitedbyAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createFormBuilder($user)
            ->add('groupToken', 'text', array('label' => false, 'attr' => array( 'placeholder' => 'Insert the code here' ) ))
            ->add('send', 'submit', array('label' => 'Send', 'attr' => array('class' => 'btn-success' )))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $groupToken = $request->request->get('form')['groupToken'];

            $em = $this->getDoctrine()->getManager();
            $hostfriend = $em->getRepository('AppBundle:Subscribed')->findByGroupToken($groupToken);
            
            if ( count($hostfriend) == 0 ) {

                $this->addFlash(
                'notice',
                'There is not host friend with this code. Maybe your friend has deleted his account. You can become the host and invite a friend'
                );

            }elseif( count($hostfriend) > 1 ) {
               
                $this->addFlash(
                'notice',
                'This code is already used by another couple of friends, please make sure you entered the correct code.'
                );

            }else{

                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('app_app_index');
            };

        }

        return array('form' => $form->createView());    
    }

}
