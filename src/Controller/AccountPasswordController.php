<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;
    function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/compte/password", name="account_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $notification=null;
        $user=$this->getUser();
        $form=$this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $old_password=$form->get('old_password')->getData();
            if($passwordEncoder->isPasswordValid($user,$old_password)){
                $new_password=$form->get('new_password')->getData();
                $password=$passwordEncoder->encodePassword($user,$new_password);
                $user->setPassword($password);
                $this->entityManager->flush();
                $notification="Votre mot de passe a été bien mis à jour";
            }else{
                $notification="Votre mot de passe actuel n'est pas le bon";
            }
            }
           
        return $this->render('account/password.html.twig',[
            'form' => $form->createView(),
            'notification' => $notification
        ]);
             
    }
  }
