<?php

namespace Unoegohh\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Unoegohh\EntitiesBundle\Entity\Item;
use Unoegohh\EntitiesBundle\Entity\ItemCategory;
use Unoegohh\EntitiesBundle\Entity\Order;
use Unoegohh\ShopBundle\Form\CashForm;

class ShopController extends Controller
{
    public function indexAction(Request $request, $categoryName = null)
    {
        $em = $this->getDoctrine()->getManager();
        $currentPage = $request->query->get('page',1);

        $category = $em->getRepository("UnoegohhEntitiesBundle:ItemCategory")->findOneBy(array('engName' => $categoryName));
        $categories = $em->getRepository("UnoegohhEntitiesBundle:ItemCategory")->getCategoriesMenu();
        if(!$category){
            $products = $em->getRepository("UnoegohhEntitiesBundle:Item")->findBy(array('active' => true, 'top' => true));
            $pages = 1;
        }else{
            $products = $em->getRepository("UnoegohhEntitiesBundle:Item")->findBy(array('category_id' => $category, 'active' => true),array("itemOrder" => "ASC"),15,($currentPage-1)*15);
            $pages = ceil(count($em->getRepository("UnoegohhEntitiesBundle:Item")->findBy(array('category_id' => $category, 'active' => true),array())) /15);
        }
        return $this->render('UnoegohhShopBundle:Item:category.html.twig', array(
            'category' => $category,
            'categories' => $categories,
            'products' => $products,
            'pages' => $pages,
            'currentPage' => $currentPage,
            'catName' => $categoryName
        ));
    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $name = $request->query->get('query');

        $categories = $em->getRepository("UnoegohhEntitiesBundle:ItemCategory")->getCategoriesMenu();

        $products = $em->getRepository("UnoegohhEntitiesBundle:Item")->getNamedProducts($name);
        return $this->render('UnoegohhShopBundle:Item:category.html.twig', array(
            'products' => $products,
            'categories' => $categories,
            'category' => array('name' => 'Результаты поиска')
        ));

    }

    public function itemAction(Item $id)
    {
        return $this->render('UnoegohhShopBundle:Item:item.html.twig', array('product' => $id, 'category' => $id->getCategoryId()));
    }

    public function updateCartAction(Request $request)
    {
        $sessions = $this->get('session');
        $sessions->set("cart", $request->request->get('data'));

        return new JsonResponse("ok");
    }

    public function cartAction(Request $request)
    {
        return $this->render('UnoegohhShopBundle:Item:cart.html.twig');
    }

    public function cashPaymentAction(Request $request)
    {

        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $order = new Order();

        $form = $this->createForm(new CashForm(), $order);

        $form->handleRequest($request);

        if($form->isValid()){
            $order = $form->getData();
            $order->setStatus(1);
            $order->setOrder($this->mres(serialize(json_decode($order->getOrder()))));
            $order->setPaymentType(1);
            $order->setDateCreated(new \Datetime('now'));
            $em->persist($order);
            $em->flush();
            $sessions = $this->get('session');
//            $message = $this->get('mailer')->createMessage()
//                ->setSubject("Заказ с сайта")
//                ->setFrom(array($this->container->getParameter('mail_from') => $this->container->getParameter('mail_name')))
//                ->setBody($this->renderView('UnoegohhShopBundle:Item:mail.html.twig', array('data' => $order, 'cart' =>unserialize($this->mres($order->getOrder())))), 'text/html')
//                ->addTo($order->getEmail());
//
//            $this->get('mailer')->send($message);

            $sessions->set("cart", '{"items": []}');
            return $this->redirect($this->generateUrl('unoegohh_shop_cash_order_sent'));
        }
        return $this->render('UnoegohhShopBundle:Item:order.html.twig', array('form' => $form->createView()));
    }

    public function orderSentAction(Request $request)
    {
        return $this->render('UnoegohhShopBundle:Item:orderSent.html.twig');
    }
    public function mres($value)
    {
        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
        $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

        return str_replace($search, $replace, $value);
    }

    public function mresp($value)
    {
        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
        $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

        return str_replace($replace, $search, $value);
    }
}
