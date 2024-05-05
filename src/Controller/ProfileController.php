<?php

namespace App\Controller;
use App\Entity\Utilisateur;
use App\Form\ProfileType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(Request $request,ManagerRegistry $doctrine,SluggerInterface $slugger): Response
    {

        //! I need the person in the form to generate the profile information so when we will change the check of the session to a methode please don't delete the $person
        $repository=$doctrine->getRepository(Utilisateur::class);
        $session=$request->getSession();
        $person=$repository->findOneBy(['id'=>$session->get('id')]);

        if(!$person)
        {
            return $this->redirectToRoute('login_page');
        }

        $form = $this->createForm(ProfileType::class, $person);
        $form->handleRequest($request);

        if($request->isMethod('Post'))
        {
            if ($form->isSubmitted() && $form->isValid()) {

                $manager = $doctrine->getManager();

                /** @var UploadedFile $brochureFile */

                $brochureFile = $form->get('image')->getData();

                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($brochureFile) {
                    $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
                        $brochureFile->move(
                            $this->getParameter('Utilisateur_directory'),
                            $newFilename);

                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload

                    }

                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents

                    $person->setPathImage($newFilename);

                }


                $manager->persist($person);
                $manager->flush();

                $this->addFlash('success', 'Your Profile is updated.');
                return  $this ->redirectToRoute('profile');
            }
            else {

                $this->addFlash('danger', "We're sorry, but your form submission is not valid. Please check the fields and try again.");

            }
        }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'form' => $form->createView(),
            'person'=>$person
        ]);
    }
}
