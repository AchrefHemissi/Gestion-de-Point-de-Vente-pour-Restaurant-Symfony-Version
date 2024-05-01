<?php
namespace App\Controller;

use App\Form\LoginType;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
#[Route('/login', name: 'login_page')]
public function login(Request $request)
{
$loginForm = $this->createForm(LoginType::class);
$registrationForm = $this->createForm(RegistrationType::class);

$loginForm->handleRequest($request);
$registrationForm->handleRequest($request);

if ($loginForm->isSubmitted() && $loginForm->isValid()) {

}

if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {

}

return $this->render('auth/login.html.twig', [
'form' => $loginForm->createView(),
'rform' => $registrationForm->createView(),
]);
}
}
