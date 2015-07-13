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

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            echo 'is valid';
            die();
            // return $this->redirectToRoute('task_success');
        }

        dump($form->isValid());

        return array('form' => $form->createView());    
    }

    /**
     * @Route("/invitation/invited-by")
     * @Template()
     */
    public function invitedbyAction()
    {
        return array();    }

}
