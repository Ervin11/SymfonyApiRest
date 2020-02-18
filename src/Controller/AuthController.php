<?php

namespace App\Controller;

use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpClient\HttpClient;




class AuthController extends AbstractController
{
  public function home()
  {
    return $this->redirectToRoute('api');
  }

  public function register(Request $request, UserPasswordEncoderInterface $encoder)
  {
    $em = $this->getDoctrine()->getManager();

    $username = $request->request->get('username');
    $password = $request->request->get('password');

    $user = new User();

    $user->setUsername($username);
    $user->setPassword($encoder->encodePassword($user, $password));

    $em->persist($user);
    $em->flush();

    return $this->redirectToRoute('login');
  }

  public function api()
  {
    return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
  }

  public function registration_page() {

    return $this->render('auth/register_page.html.twig');

  }

  public function login(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $username = $request->request->get('username');
    $password = $request->request->get('password');

    $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);

    if ($user != null)
    {
      $hashed_pwd = $user->getPassword();

      $pwd_check = password_verify($password, $hashed_pwd);

      if ($pwd_check == true)
      {
        $client = HttpClient::create();
        $response = $client->request('POST', 'http://localhost:8000/login_check', ['json' =>['username' => $username, 'password' => $password]]);

        $content = $response->getContent();
        $content = json_decode($content, true);
        //printf($content["token"]);

        return $this->render('auth/login_page.html.twig', [
            'token' => $content['token'],
        ]);
      }

    }

    return $this->render('auth/login_page.html.twig');

  }

}