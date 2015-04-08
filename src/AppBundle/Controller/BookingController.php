<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Entity\Client;
use AppBundle\Entity\Vehicle;
use AppBundle\Form\Type\BookingType;
use AppBundle\Form\Type\ClientType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class BookingController extends Controller
{
    /**
     * @Route("/b/create")
     * @Template()
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $booking = new Booking();

        $form = $this->createForm(new BookingType(), $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $m = $this->getDoctrine()->getManager();

            // persist & flush our new booking
            $m->persist($booking);
            $m->flush();

            $this->addFlash('success', 'Booking ' . $booking->getId() . ' created');

            return $this->redirect($this->generateUrl('app_booking_list'));
        }

        return array(
            'booking' => $booking,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/b/update/{booking}")
     * @Template()
     *
     * @param Request $request
     * @param Booking $booking
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, Booking $booking)
    {
        $form = $this->createForm(new BookingType(), $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $m = $this->getDoctrine()->getManager();

            if ($booking->getUpgraded() && Vehicle::BASIC === $booking->getVehicle()->getRange()) {
                // if we can upgrade the rental, just choose the first available ELITE vehicle
                $booking->setVehicle(
                    $this->get('star_rentals_app.service.upgrader_service')->upgradeVehicle($booking)
                );
            }

            // persist & flush our updated booking
            $m->persist($booking);
            $m->flush();

            $this->addFlash('success',  'Booking ' . $booking->getId() . ' updated');

            return $this->redirect($this->generateUrl('app_booking_list'));
        }

        return array(
            'booking' => $booking,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/b/list")
     * @Template()
     */
    public function listAction()
    {
        $bookings = $this->getDoctrine()->getRepository("AppBundle:Booking")->findAll();

        return array(
            'bookings' => $bookings
        );
    }

    /**
     * @Route("/b/ajax_upgrade/")
     *
     * @param Request $request
     * @return Response
     */
    public function ajaxUpgradeAction(Request $request)
    {
        $ranges = Vehicle::listHumanRanges();
        $booking = new Booking();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $form = $this->createForm(new BookingType(), $booking);

        if ($request->isMethod('POST')) {
            $formData = $request->request->get($form->getName());
            // force upgraded to trigger the constraint
            $formData['upgraded'] = true;

            $form->submit($formData);

            $response->setContent(json_encode(array(
                'client' => array(
                    'firstname' => $booking->getClient()->getFirstname(),
                    'lastname' => $booking->getClient()->getLastname()
                ),
                'basic_range' => $ranges[Vehicle::BASIC],
                'elite_range' => $ranges[Vehicle::ELITE],
                'is_upgradable' => $form->isValid(),
            )));
        } else {
            $response->setContent(json_encode(array(
                'is_upgradable' => false,
            )));
        }

        return $response;
    }
}
