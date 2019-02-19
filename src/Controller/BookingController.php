<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Computer;
use App\Entity\User;
use App\Form\BookingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
{
  /**
   * @Route("/", name="booking_index", methods={"GET"})
   * #Return All booking in json format
   */
  public function index(): Response
  {
    $encoders = [new XmlEncoder(), new JsonEncoder()];
    $normalizers = [new ObjectNormalizer()];

    $serializer = new Serializer($normalizers, $encoders);
    $result = $this->getDoctrine()
      ->getRepository(Booking::class)
      ->findAll();

    $bookings = [];
    foreach ($result as $booking) {
      $bookings[] = [
        'id' => $booking->getId(),
        'title' => $booking->getName(),
        'resourceId' => $booking->getComputer()->getId(),
        'start' => $booking->getBeginAt()->format("Y-m-d H:i:s"),
        'end' => $booking->getEndAt()->format("Y-m-d H:i:s")
      ];
    }

    return new Response($serializer->serialize($bookings, 'json'));
  }

  /**
   * @Route("/new", name="booking_new", methods={"POST"})
   * #Create a new booking
   * #Params {startDate, endDate, resourceId, userId}
   * #Return a new booking
   */
  public function new(Request $request): Response
  {
    $entityManager = $this->getDoctrine()->getManager();

    $booking = new Booking();
    $booking->setBeginAt(new \DateTime($request->get('start')));
    $booking->setEndAt(new \DateTime($request->get('end')));

    $computer = $entityManager->getRepository(Computer::class)
        ->find($request->get("resourceId"));

    $booking->setComputer($computer);

    $user = $entityManager->getRepository(User::class)
        ->find($request->get("userId"));

    $booking->setUser($user);
    $booking->setName($user->getFirstname() . ' ' . $user->getName());

    $entityManager->persist($booking);

    $entityManager->flush();

    $encoders = [new XmlEncoder(), new JsonEncoder()];
    $normalizers = [new ObjectNormalizer()];

    $serializer = new Serializer($normalizers, $encoders);
    return new Response($serializer->serialize([
        'id' => $booking->getId(),
        'title' => $booking->getName(),
        'resourceId' => $booking->getComputer()->getId(),
        'start' => $booking->getBeginAt()->format("Y-m-d H:i:s"),
        'end' => $booking->getEndAt()->format("Y-m-d H:i:s")
      ], 'json'));
  }

  /**
   * @Route("/{id}", name="booking_delete", methods={"DELETE"}, defaults={"id" = null})
   * #Delete a booking
   * #Params {bookingId}
   * #Return deleted bookingId
   */
  public function delete(Request $request, Booking $booking): Response
  {
    $entityManager = $this->getDoctrine()->getManager();

    $res = ['id' => $booking->getId()];

    $entityManager->remove($booking);
    $entityManager->flush();

    $encoders = [new XmlEncoder(), new JsonEncoder()];
    $normalizers = [new ObjectNormalizer()];

    $serializer = new Serializer($normalizers, $encoders);
    return new Response($serializer->serialize($res , 'json'));
  }
}
