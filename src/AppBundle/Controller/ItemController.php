<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ItemType;
use AppBundle\Entity\Item;


class ItemController extends Controller
{
    /**
     * @Route("/item/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        
        $user = $this->getUser();
        $item = new Item();
        $item->setCreatedBy($user);

        $form = $this->createForm(new ItemType(), $item);

        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash(
                'notice',
                'Item added'
            );

            return $this->redirectToRoute('app_app_index');
        }


        return array('form' => $form->createView());

    }

     /**
     * @Route("/item/show/{id}")
     * @ParamConverter("item", class="AppBundle:Item")
     * @Template()
     */
    public function showAction($item)
    {
        return array( 'item' => $item );    
    }

    /**
     * @Route("/item/edit/{id}")
     * @Template()
     */
    public function editAction($id)
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/item/delete/{id}")
     * @ParamConverter("item", class="AppBundle:Item")
     * @Template()
     */
    public function deleteAction($item)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Item')->find($item->getId());
        $em->remove($item);
        $em->flush();

        $this->addFlash(
                'notice',
                'Item removed'
            );


        return $this->redirectToRoute('app_app_index');

    }

}
