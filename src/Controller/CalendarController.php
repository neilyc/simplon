<?php 
namespace App\Controller;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class CalendarController extends AbstractController
{
  /**
  * @Route("/", name="calendar_index", methods={"GET"})
  * #Display Calendar
  */
  public function index()
  {
    $users = $this->getDoctrine()
      ->getRepository(User::class)
      ->findAll();

    return $this->render('calendar/index.html.twig', [
      'users' => $users,
    ]);
  }
}