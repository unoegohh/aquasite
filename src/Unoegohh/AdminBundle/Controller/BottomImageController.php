<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Unoegohh\AdminBundle\Form\BottomImageForm;
use Unoegohh\AdminBundle\Form\FoodCategoryForm;
use Unoegohh\AdminBundle\Form\MainBannerForm;
use Unoegohh\AdminBundle\Form\SitePrefForm;
use Symfony\Component\HttpFoundation\Request;
use Unoegohh\EntitiesBundle\Entity\BottomImage;
use Unoegohh\EntitiesBundle\Entity\FoodCategory;
use Doctrine\ORM;
use Unoegohh\EntitiesBundle\Entity\MainBanner;

class BottomImageController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $bannerRepo = $em->getRepository('UnoegohhEntitiesBundle:BottomImage');

        $banners = $bannerRepo->findAll();

        return $this->render('UnoegohhAdminBundle:BottomImage:index.html.twig', array('items'=>$banners));
    }

    public function createAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $banner = new BottomImage();

        $form = $this->createForm(new BottomImageForm(), $banner);

        $form->handleRequest($request);

        if($form->isValid()){
            $cat = $form->getData();
            $em->persist($cat);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Картинка добавлена!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_bottom_images_edit', array("id" => $cat->getId())));
        }
        return $this->render('UnoegohhAdminBundle:BottomImage:create.html.twig', array('form'=>$form->createView()));
    }

    public function editAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $catRepo = $em->getRepository('UnoegohhEntitiesBundle:BottomImage');
        $cat = $catRepo->find($id);

        if(!$cat){
            throw new Exception("Картинка не найден");
        }

        $form = $this->createForm(new BottomImageForm(), $cat);

        $form->handleRequest($request);

        if($form->isValid()){
            $cat = $form->getData();
            $em->persist($cat);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Картинка обновлена!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_bottom_images_edit', array("id" => $cat->getId())));

        }
        return $this->render('UnoegohhAdminBundle:BottomImage:edit.html.twig', array('form'=>$form->createView()));
    }

    public function removeAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $catRepo = $em->getRepository('UnoegohhEntitiesBundle:BottomImage');
        $cat = $catRepo->find($id);

        if(!$cat){
            throw new Exception("Картинка не найдена");
        }
        return $this->render('UnoegohhAdminBundle:BottomImage:remove.html.twig', array('cat'=>$cat));
    }

    public function removeOkAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $catRepo = $em->getRepository('UnoegohhEntitiesBundle:BottomImage');
        $cat = $catRepo->find($id);

        if(!$cat){
            throw new Exception("Картинка не найдена");
        }

        $em->remove($cat);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'notice',
            'Картинка удалена!'
        );
        return $this->redirect($this->generateUrl('unoegohh_admin_bottom_images'));

    }
}
