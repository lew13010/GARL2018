<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Gamer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Gamer controller.
 *
 */
class GamerController extends Controller
{
    /**
     * Lists all gamer entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $gamers = $em->getRepository('AppBundle:Gamer')->findAll();

        return $this->render('@App/gamer/index.html.twig', array(
            'gamers' => $gamers,
        ));
    }

    /**
     * Creates a new gamer entity.
     *
     */
    public function newAction(Request $request)
    {
        $gamer = new Gamer();
        $form = $this->createForm('AppBundle\Form\GamerType', $gamer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $api = $this->get('app.service.api');

            $req = $api->getRanking($gamer->getSteam());
            $gamer->setSteamId($req['json']['uniqueId']);

            $em->persist($gamer);
            $em->flush();

            $api->setRanking($gamer);


            return $this->redirectToRoute('gamer_show', array('id' => $gamer->getId()));
        }

        return $this->render('@App/gamer/new.html.twig', array(
            'gamer' => $gamer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a gamer entity.
     *
     */
    public function showAction(Gamer $gamer)
    {
        $deleteForm = $this->createDeleteForm($gamer);

        return $this->render('@App/gamer/show.html.twig', array(
            'gamer' => $gamer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing gamer entity.
     *
     */
    public function editAction(Request $request, Gamer $gamer)
    {
        $deleteForm = $this->createDeleteForm($gamer);
        $editForm = $this->createForm('AppBundle\Form\GamerType', $gamer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $api = $this->get('app.service.api');

            $req = $api->getRanking($gamer->getSteam());
            $gamer->setSteamId($req['json']['uniqueId']);

            $api->setUpdate($gamer);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gamer_edit', array('id' => $gamer->getId()));
        }

        return $this->render('@App/gamer/edit.html.twig', array(
            'gamer' => $gamer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a gamer entity.
     *
     */
    public function deleteAction(Request $request, Gamer $gamer)
    {
        $form = $this->createDeleteForm($gamer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gamer);
            $em->flush();
        }

        return $this->redirectToRoute('gamer_index');
    }

    /**
     * Creates a form to delete a gamer entity.
     *
     * @param Gamer $gamer The gamer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Gamer $gamer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gamer_delete', array('id' => $gamer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
