<?php

namespace PJ\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use PJ\BlogBundle\Entity\Comment;
use PJ\BlogBundle\Entity\Favoris;
use PJ\BlogBundle\Entity\Gallery;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use PJ\BlogBundle\Form\CommentType;
use PJ\BlogBundle\Form\GameEditType;
use PJ\BlogBundle\Form\GameSearchType;
use PJ\BlogBundle\Form\GameType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use PJ\UserBundle\Entity\User;
use PJ\BlogBundle\Entity\Game;
use Symfony\Component\Security\Core\SecurityContext;
use PJ\BlogBundle\Entity\Console;

class AdvertController extends Controller
{
      /*TEST FAVORIS*/
  public function favorisAction(Request $request, $id)
  {
//      dump($userId);
//      die();
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('PJBlogBundle:Game')->find($id);
//        $user=$em->getRepository('PJUserBundle:User')->findAll();
//        $user= $this->getUser();
        
//        dump($game);
//        die();

//      $gamename->set
//      dump($user);
//      die();
        $username=$this->getUser()->getUsername();
        $favorissearch = $em->getRepository('PJBlogBundle:Favoris')->findByUsername($username);
        foreach($favorissearch as $search)
        {
            $gamefind=$search->getGame()->getId();
            $gamefind2 = $game->getId();
            if($gamefind == $gamefind2){
                return $this->redirectToRoute('pj_blog_caracjeu', array('id' => $id));
            }
        }
      
        
        $favoris = new Favoris();
        $favoris->setGame($game);
        $favoris->setUsername($username);
        $em->persist($favoris);
        $em->flush();
        return $this->redirectToRoute('pj_blog_caracjeu', array('id' => $id));
  }
     
  public function indexAction(Request $request)
  {
    $games='';
    return $this->render('PJBlogBundle:Advert:index.html.twig',array('games' => $games));

  }
  /*********MONTRE LES PAGES CONSOLES*****************/
  public function consoleAction(Request $request, $console)
  {
      
      return $this->render('PJBlogBundle:Advert:console.html.twig', array('console' => $console));
  }
  /**********MONTRE LES CARACTERISTIQUES DES JEUX**************/
  public function caracjeuAction(Request $request,$id)
  {
      
              
    $em = $this->getDoctrine()->getManager();
    /**
     * @var Game $game
     */
    $game = $em->getRepository('PJBlogBundle:Game')->findFull($id);

    //$gallery= $em->getRepository('PJBlogBundle:Gallery')->findBy(array('game'=> $id));

//    dump($game);
//    die();
    $listComment = $em

      ->getRepository('PJBlogBundle:Comment')

      ->findBy(array('game' => $game))
            ;

    
    $comment = new Comment();

    $form = $this->get('form.factory')->create(CommentType::class, $comment);
    
    
    
    if ($request->isMethod('POST')) {
        
      $form->handleRequest($request);

      if ($form->isValid()) {

        $username=$this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
        $comment->setGame($game);
//      dump($comment);
//      die();
//      $comment->setUser($user);
        $comment->setAuthor($username);
        $em->persist($comment);

        $em->flush();


        $request->getSession()->getFlashBag()->add('notice', 'Commentaire bien enregistrée.');


        // On redirige vers la page de visualisation de l'annonce nouvellement créée

        return $this->redirectToRoute('pj_blog_caracjeu', array('id' => $id));

      }

    }
   
    return $this->render('PJBlogBundle:Advert:caracJeu.html.twig', array(
      'game'        => $game,
      'listComment' =>  $listComment,
      'form'        =>  $form->createView(),
      'id'          =>  $id,
    ));
      
      
      
      
      
  }
  /********JEUX AUX HAZARD SUR LES PAGES ***************/
   public function randomJeuAction()
  {
       //$query= $this->createQueryB
       
    $em = $this->getDoctrine()->getManager();

    $game = $em->getRepository('PJBlogBundle:Game')->findAll();  



    return $this->render('PJBlogBundle:Advert:randomJeu.html.twig', array(
 
      'listAdverts' => $game
    ));

  }
  
  
    /*Add Annonce*/
    public function addAction(Request $request)
    {
     

        $game = new Game();
            
        $form   = $this->get('form.factory')->create(GameType::class, $game);
        
      
        

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            
          
          //$game->getImage()->upload();
          //$game->getGallery()->getImages()->first()->upload();
          //$game->getImage()->setGallery($gallery);
          //$game->getGallery()->setGame($game);
           
        
       
          $em = $this->getDoctrine()->getManager();
          
          $em->persist($game);
          $em->flush();
// dump($game);
//          die();
          


          return $this->redirectToRoute('pj_blog_caracjeu', array('id' => $game->getId()));


        }
        

        return $this->render('PJBlogBundle:Advert:add.html.twig', array(

          'form' => $form->createView(),

        ));

        
    }
  
  public function editAction($id, Request $request)
  {
 
    $em = $this->getDoctrine()->getManager();
    

    $game = $em->getRepository('PJBlogBundle:Game')->find($id);

    if (null === $game) {

      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");

    }
    

    $form = $this->get('form.factory')->create(GameEditType::class, $game);


    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
       
      $em->flush();
      
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');


      return $this->redirectToRoute('pj_blog_caracjeu', array('id' => $game->getId()));

    }


        return $this->render('PJBlogBundle:Advert:edit.html.twig', array(

      'game' => $game,

      'form'   => $form->createView(),
      ));
      

      
  }

  public function deleteAction(Request $request, $id)
  {

    $em = $this->getDoctrine()->getManager();


    $game = $em->getRepository('PJBlogBundle:Game')->find($id);
    $comment = $em->getRepository('PJBlogBundle:Comment')->findBygame($id);
    $favoris = $em->getRepository('PJBlogBundle:Favoris')->findBygame($id);
    $gallery = $em->getRepository('PJBlogBundle:Gallery')->findOneBygame($id);
    if(!empty($gallery))
    {
        $idimage=$gallery->getId();
        $galleryy = $em->getRepository('PJBlogBundle:Gallery')->find($idimage);
        $images = $em->getRepository('PJBlogBundle:Image')->findBygallery($idimage);
    }
    

//    dump($galleryy);
//    die();

    if (null === $game) {

      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");

    }


    // On crée un formulaire vide, qui ne contiendra que le champ CSRF

    // Cela permet de protéger la suppression d'annonce contre cette faille

    $form = $this->get('form.factory')->create();


    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        /*suppression des commentaires*/
       foreach($comment as $comments)
       {
           $em->remove($comments);
       }
               /*suppression des favoris*/

       foreach($favoris as $favoriss)
       {
           $em->remove($favoriss);
       }
               /*suppression des images dans la gallerie*/

       if(!empty($gallery))
       {
            foreach($images as $imagess)
            {
                $em->remove($imagess);
            }
       }
               /*suppression de la gallerie*/

       if(!empty($gallery))
        {
            $em->flush();
           $em->remove($galleryy);
           $em->flush();
        }
      $em->remove($game);
      
      $em->flush();


      $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");


      return $this->redirectToRoute('pj_blog_home');

    }

    

    return $this->render('PJBlogBundle:Advert:delete.html.twig', array(

      'game' => $game,

      'form'   => $form->createView(),

    ));

  }
  
//  public function showprofileAction(Request $request, $username)
//{
//   $em = $this->getDoctrine()->getManager();
//
//   $user = $em->getRepository('PJUserBundle:User')->findByUsername($username);
//   dump($user);
//   die();
//
//}
    
    
    
     public function listConsoleAction(Request $request, $console)
        {
            $em=$this->getDoctrine()->getManager();
            
            //$blogPosts=$em->getRepository('PJBlogBundle:Game')->findByConsole('pc');
            $gameWithConsole = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('PJBlogBundle:Game')
            ->getGameWithConsole($console)
            ;
           
         
   
//            $cons = =$em->getRepository('PJBlogBundle:Console')->findByName('pc');
           /**
            * @var $paginator \Knp\Component\Pager\Paginator
            */
           //$currentPage = $_GET['page'];
                if(empty($_GET['page']))
                {
                    $currentPage=1;
                }
                else
                {
                    $currentPage = $_GET['page'];
                }
                $paginator  = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                    $gameWithConsole, /* query NOT result */
                    $request->query->getInt('page',$currentPage)/*page number*/,
                    5/*limit per page*/
                );

            
          
            // parameters to template
            return $this->render('PJBlogBundle:Advert:list.html.twig', array('paginate' => $pagination));
        }
    
    
    
    
    
    
    
        public function listAction(Request $request)
        {
            $em=$this->getDoctrine()->getManager();
            $blogPosts=$em->getRepository('PJBlogBundle:Game')->findAll();
       
            if(empty($_GET['page']))
            {
                $currentPage=1;
            }
            else
            {
                $currentPage = $_GET['page'];
            }
                $paginator  = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                    $blogPosts, /* query NOT result */
                    $request->query->getInt('page',$currentPage)/*page number*/,
                    5/*limit per page*/
                );
            
          
            // parameters to template
            return $this->render('PJBlogBundle:Advert:list.html.twig', array('paginate' => $pagination));
        }
    
    
    
    
        public function rechercheAction(Request $request)
        {
            
            //l'idéal serait d'utiliser un form symfony
                     $keyword = '';
                     $year = '';
                     $console = '';

            if(!empty($_GET['keyword']) || !empty($_GET['year']) || !empty($_GET['console']))
            {
                $em=$this->getDoctrine()->getManager();
                if($request->query->get('keyword') !== null)
                {
                   $keyword = $request->query->get('keyword');
                }
                 if($request->query->get('year') !== null)
                {
                    $year = $request->query->get('year');

                }
                if($request->query->get('console') !== null)
                {
                    $console = $request->query->get('console');
                        $gameWithConsole = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('PJBlogBundle:Console')
                        ->findOneBy(['name'=>$request->query->get('console')])
                        ;
                        
               
                }
                else{
                    $gameWithConsole = null;
                }
                
                $games=$em->getRepository('PJBlogBundle:Game')->search($request->query->get('keyword'),$request->query->get('year'),$gameWithConsole);
                if($games == null)
                {
                    return $this->render('PJBlogBundle:Advert:rechercheerror.html.twig');

                }

                return $this->render('PJBlogBundle:Advert:index.html.twig', array(
               
                    'games'=>$games
                        ));
            }
       
               return $this->render('PJBlogBundle:Advert:rechercheerror.html.twig');
            
        }
    
    
    

   
}