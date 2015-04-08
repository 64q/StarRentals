<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use AppBundle\Form\Type\ClientType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ClientController extends Controller
{
    /**
     * @Route("/c/create")
     * @Template()
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $client = new Client();

        $form = $this->createForm(new ClientType(), $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $m = $this->getDoctrine()->getManager();

            // persist & flush our new client
            $m->persist($client);
            $m->flush();

            $this->addFlash('success', 'Client ' . $client->getFirstname() . ' ' . $client->getLastname() . ' created');

            return $this->redirect($this->generateUrl('app_client_list'));
        }

        return array(
            'client' => $client,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/c/update/{client}")
     * @Template()
     *
     * @param Request $request
     * @param Client $client
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, Client $client)
    {
        $form = $this->createForm(new ClientType(), $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $m = $this->getDoctrine()->getManager();

            // persist & flush our updated client
            $m->persist($client);
            $m->flush();

            $this->addFlash('success',  'Client ' . $client->getFirstname() . ' ' . $client->getLastname() . ' updated');

            return $this->redirect($this->generateUrl('app_client_list'));
        }

        return array(
            'client' => $client,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/c/list")
     * @Template()
     */
    public function listAction()
    {
        $clients = $this->getDoctrine()->getRepository("AppBundle:Client")->findAll();

        return array(
            'clients' => $clients
        );
    }
}
