<?php

namespace PJ\UserBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PJ\UserBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use PJ\UserBundle\Form\RegistrationFormType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use PJ\BlogBundle\Entity\Comment;
use PJ\BlogBundle\Form\CommentType;
use PJ\UserBundle\Form\UserType;
use PJ\UserBundle\Form\UserInscrType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use PJ\UserBundle\Form\UserDeleteType;
use PJ\UserBundle\Form\UserModType;

class SecurityController extends Controller
{
  public function registrationAction(Request $request)
  {
              $user = new User();

     $form = $this->get('form.factory')->create(RegistrationFormType::class, $user);
    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
    {
        
        $em = $this->getDoctrine()->getManager();
        $user->setEnabled(true);
        $em->persist($user);
        $em->flush();
        $username=$form['username']->getData();
        $comment = $em->getRepository('PJBlogBundle:Comment')->findByAuthor($username);
        $favoris = $em->getRepository('PJBlogBundle:Favoris')->findByUsername($username);
        
        return $this->render('PJUserBundle:Security:validation.html.twig');  
    }

      return $this->render('PJUserBundle:Security:registration.html.twig', array('form'=>$form->createView()));
  }
  public function loginAction(Request $request)
  {
     
    // Si le visiteur est déjà identifié, on le redirige vers l'accueil
    if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
        
        return $this->redirectToRoute('pj_platform_home');
    }
    

    // Le service authentication_utils permet de récupérer le nom d'utilisateur
    // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
    // (mauvais mot de  passe par exemple)
    $authenticationUtils = $this->get('security.authentication_utils');

    return $this->render('PJUserBundle:Security:login.html.twig', array(
      'last_username' => $authenticationUtils->getLastUsername(),
      'error'         => $authenticationUtils->getLastAuthenticationError(),
    ));

  }
  public function profileAction(Request $request)
  {
      
      $user = $this->getUser();
      $em = $this->getDoctrine()->getManager();
      $username=$this->getUser()->getUsername();
      
      $comment = $em->getRepository('PJBlogBundle:Comment')->findByAuthor($username);
      $favoris = $em->getRepository('PJBlogBundle:Favoris')->findByUsername($username);
//      dump($comment);
//      die();
      
      
       return $this->render('PJUserBundle:Security:profile.html.twig', array(
            'user'           => $user,
            'comment'        => $comment,
            'favoris'         => $favoris,
        ));
  }
  
  public function modifAction(Request $request, $id)
  {
      $em = $this->getDoctrine()->getManager();
      $user = $this->getUser()->getUsername();
      $userupdate = $em->getRepository('PJUserBundle:User')->find($id);
    
      if (null === $userupdate) {

      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");

    }

      $form = $this->get('form.factory')->create(UserType::class, $userupdate);

      
      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      $user2=$form['username']->getData();
      
      
      if($user2 != $user)
      {
        $favoris = $em->getRepository('PJBlogBundle:Favoris')->findByUsername($user);
        $comment =  $em->getRepository('PJBlogBundle:Comment')->findByAuthor($user);
        foreach($favoris as $favoriss)
        {
            $favoriss->setUsername($user2);

        }
        foreach($comment as $commentt)
        {
            $commentt->setAuthor($user2);

        }
               $em->persist($commentt);
               $em->persist($favoriss);

      }
      $em->flush();
      


      return $this->redirectToRoute('pj_blog_profile', array('id' => $userupdate->getId()));

    }


        return $this->render('PJUserBundle:Security:edit.html.twig', array(

      'user' => $userupdate,

      'form'   => $form->createView(),
      ));
   
      
       
  }

  /*Moderation role/bannissement*/
  public function modeAction(Request $request)
  {

      $em = $this->getDoctrine()->getManager();
      
     
      $form = $this->get('form.factory')->create(UserModType::class);
      /*FORM2 POUR LES BAN*/
      $bannirform = $this->get('form.factory')->create(UserDeleteType::class);
        

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          
   
          //MODIFIER ROLE UTILISATEUR : 
          if(!empty($form))
          {
                $username = $form["username"]->getData();
                
                $roles = $form["roles"]->getData();
                
                
                
                $user = $em->getRepository('PJUserBundle:User')->findOneByUsername($username);
                
                if($user == null) {
                    $user = new User();
                }

      //          dump($user);
      //          die();

                if(empty($user))
                {
                     throw new NotFoundHttpException("L'utilisateur n'existe pas");
                }
                
              $user->setRoles($roles);

      //        dump($user);
      //          die();

                $em->persist($user);
                $em->flush();
          }
         


        return $this->redirectToRoute('pj_blog_home');

      }
      
      /**********************bannir*****************************/
      if ($request->isMethod('POST') && $bannirform->handleRequest($request)->isValid()) {
                if(!empty($bannirform))
                    {
                        $username = $bannirform["username"]->getData();

                        $usernameAdmin = $em->getRepository('PJUserBundle:User')->findOneByUsername($username);
                        
                    
                        $user= $usernameAdmin->getRoles();
                        
                        if($user['0'] == 'ROLE_ADMIN')
                        {
                            return $this->redirectToRoute('pj_blog_home');
                        }
                        $username = $bannirform["username"]->getData();
                        $userban = $em->getRepository('PJUserBundle:User')->findOneByUsername($username);
                        $userban->setEnabled(false);
                        $this->get('fos_user.user_manager')->updateUser($userban);
                    }



        return $this->redirectToRoute('pj_blog_home');
      
      }


          return $this->render('PJUserBundle:Security:moderateur.html.twig', array(


        'form'   => $form->createView(),
        'ban' =>$bannirform->createView(),
        ));
  }
  
  
    public function deletecommentAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('PJBlogBundle:Comment')->find($id);
        $user = $em->getRepository('PJUserBundle:User')->findOneByUsername($comment->getAuthor());
        $username=$this->getUser()->getUsername();
        
        if($username == $user->getUsername())
        {
            $em->remove($comment);
            $em->flush();
            return $this->redirectToRoute('pj_blog_profile');
        }
        else
        {
            throw new NotFoundHttpException("Page not found");

        }
        

    }
    public function deletefavorisAction(Request $request, $id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $favoris = $em->getRepository('PJBlogBundle:Favoris')->find($id);
        
        $user = $em->getRepository('PJUserBundle:User')->findOneByUsername($favoris->getUsername());
        $username=$this->getUser()->getUsername();
        
        if($username == $user->getUsername())
        {
            $em->remove($favoris);
            $em->flush();
            return $this->redirectToRoute('pj_blog_profile');
        }
        else
        {
            throw new NotFoundHttpException("Page not found");

        }
        

    }
    
    public function showprofileAction(Request $request, $username)
    {
       $em = $this->getDoctrine()->getManager();
      
       $user = $em->getRepository('PJUserBundle:User')->findOneByUsername($username);
       
      
       
      $comment = $em->getRepository('PJBlogBundle:Comment')->findByAuthor($username);
      $favoris = $em->getRepository('PJBlogBundle:Favoris')->findByUsername($username);
     
      
       return $this->render('PJUserBundle:Security:profile.html.twig', array(
            'user'           => $user,
            'comment'        => $comment,
           'favoris'         => $favoris,
           
        ));
    }
  
  
  
  public function deleteuserAction(Request $request,$id)
  {
      $em =$this->getDoctrine()->getManager();
      
      $user= $em->getRepository('PJUserBundle:User')->findOneById($id);
      $username=$this->getUser()->getUsername();
      
      if($user == $username)
      {
          $comments = $em->getRepository('PJBlogBundle:Comment')->findByAuthor($user->getUsername());
          $favoris = $em->getRepository('PJBlogBundle:Favoris')->findByUsername($user->getUsername());
          if(!empty($comments))
          {
                foreach($comments as $comment)
                {
                    $em->remove($comment);
                }
          }
          if(!empty($favoris))
          {
                foreach($favoris as $favori)
                {
                    $em->remove($favori);
                }
          }
          
          $em->remove($user);
          $em->flush();
          return new Response();
      }
      
      throw new NotFoundHttpException("Page not found");

      
  }
  
}