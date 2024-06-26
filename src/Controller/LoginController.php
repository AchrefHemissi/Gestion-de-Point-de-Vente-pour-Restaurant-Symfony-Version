<?php
namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\LoginType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class LoginController extends AbstractController
{
#[Route('/login', name: 'login_page')]
public function login(Request $request,EntityManagerInterface $entityManager)
{
$session=$request->getSession();//start session

    if($session->has("id")){
        return $this->redirectToRoute("home");
    }

$loginForm = $this->createForm(LoginType::class);
$registrationForm = $this->createForm(RegistrationType::class);
$loginForm->handleRequest($request);
$registrationForm->handleRequest($request);
if ($loginForm->isSubmitted() && $loginForm->isValid() ) {
    $user=new Utilisateur();
    $formData = $loginForm->getData();
    $email = $formData->getEmail();
    $password = $formData->getPass();
    $user = $entityManager->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);
    if (!$user) {
        $this->addFlash('danger', 'Invalid credentials.');
    }
    else{
        $storedPassword = $user->getPass();
        if ($password=== $storedPassword) {
            if(!$user->get_is_Admin()){
                if($user->get_is_Banned()){
                   return $this->render('banned/banned.html.twig');
                }

                $session->set('id', $user); // store user id in session
                return $this->redirectToRoute('home');
                }
            else
            {   $session->set('id', $user); // store user id in session
                $session->set('admin', true);
                return $this->redirectToRoute('dashboard');
            }
        } else {
            $this->addFlash('danger', 'Invalid credentials.');
        }
    }
}

if ($registrationForm->isSubmitted() && $registrationForm->isValid() && !$loginForm->isSubmitted()) {
$user=new Utilisateur();
    $formData = $registrationForm->getData();
    $email = $formData->getEmail();
    $user = $entityManager->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);
    if(!$user)
    {   $newuser=new Utilisateur();
        $newuser->setNom($formData->getNom());
        $newuser->setPrenom($formData->getPrenom());
        $newuser->setPass($formData->getPass());
        $newuser->setEmail($email);
        $newuser->setNumTel($formData->getNumTel());
        $newuser->set_is_Banned(false);
        $newuser->set_is_Admin(false);
        $entityManager->persist($newuser);
        $entityManager->flush();
        $this->addFlash('success', 'Registration successful!');
        //return $this->redirectToRoute('home');  ken t7b tredirigiha l page d'accueil
    }
    else{
        $this->addFlash('danger', 'This email is already in use');
    }


}

return $this->render('auth/login.html.twig', [
'form' => $loginForm->createView(),
'rform' => $registrationForm->createView(),
]);
}
}
