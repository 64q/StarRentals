<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vehicle;
use AppBundle\Form\Type\VehicleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class VehicleController extends Controller
{
    /**
     * @Route("/v/create")
     * @Template()
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $vehicle = new Vehicle();

        $form = $this->createForm(new VehicleType(), $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $m = $this->getDoctrine()->getManager();

            // persist & flush our new vehicle
            $m->persist($vehicle);
            $m->flush();

            $this->addFlash('success', 'Vehicle ' . $vehicle->getName() . ' created');

            return $this->redirect($this->generateUrl('app_vehicle_list'));
        }

        return array(
            'vehicle' => $vehicle,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/v/update/{vehicle}")
     * @Template()
     *
     * @param Request $request
     * @param Vehicle $vehicle
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, Vehicle $vehicle)
    {
        $form = $this->createForm(new VehicleType(), $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $m = $this->getDoctrine()->getManager();

            // persist & flush our updated vehicle
            $m->persist($vehicle);
            $m->flush();

            $this->addFlash('success', 'Vehicle ' . $vehicle->getName() . ' updated');

            return $this->redirect($this->generateUrl('app_vehicle_list'));
        } else {
            if (Vehicle::BASIC === $vehicle->getRange()) {
                $form->remove('color');
            }
        }

        return array(
            'vehicle' => $vehicle,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/v/list")
     * @Template()
     */
    public function listAction()
    {
        $vehicles = $this->getDoctrine()->getRepository("AppBundle:Vehicle")->findAll();

        return array(
            'vehicles' => $vehicles
        );
    }
}