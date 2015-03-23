<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Unoegohh\AdminBundle\Form\SitePrefForm;
use Symfony\Component\HttpFoundation\Request;
use Unoegohh\AdminBundle\Form\StaticPageForm;
use Doctrine\ORM;
use Unoegohh\AdminBundle\Form\UserForm;
use Unoegohh\EntitiesBundle\Entity\StaticPage;
use Unoegohh\UserBundle\Entity\User;
use FOS\UserBundle\Doctrine\UserManager;

class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $pagesRepo = $em->getRepository('UnoegohhUserBundle:User');

        $pages = $pagesRepo->findBy(array('created' => true));

        return $this->render('UnoegohhAdminBundle:User:index.html.twig', array('data'=>$pages));
    }

    public function editAction(Request $request, User $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        if(!$id){
            throw new Exception("Пользователь не найден");
        }

        $form = $this->createForm(new UserForm(), $id);

        $form->handleRequest($request);

        if($form->isValid()){
            $id = $form->getData();
            $em->persist($id);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Пользователь обновлен!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_user_edit', array("id" => $id->getId())));

        }
        return $this->render('UnoegohhAdminBundle:User:edit.html.twig', array('form'=>$form->createView()));
    }

    public function removeAction(Request $request, User  $id)
    {
        return $this->render('UnoegohhAdminBundle:User:remove.html.twig', array('item'=>$id));
    }

    public function changePasswordAction(Request $request, User  $id)
    {
        $name = $request->query->get('pass');
        $em = $this->container->get('doctrine')->getManager();

        if($name){

            /* @var $userManager UserManager */
            $userManager = $this->container->get('fos_user.user_manager');
            $id->setPlainPassword($name);

            $userManager->updateUser($id, true);
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Пользователь обновлен'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_user'));
        }

        return $this->render('UnoegohhAdminBundle:User:changePassword.html.twig', array('item'=>$id));
    }
    public function removeOkAction(Request $request, User $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();
        $em->remove($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'notice',
            'Пользователь удален!'
        );
        return $this->redirect($this->generateUrl('unoegohh_admin_user'));

    }

}
