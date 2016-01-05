<?php

namespace Samenjoy\FrontBundle\Controller;

use SASEdev\Commons\SharedBundle\Controller\BaseController;

/**
 *
 * @author sasedev <seif.salah@gmail.com>
 */
class MenuController extends BaseController
{

    /**
     *
     * @var array
     */
    protected $gvars = array();

    /**
     * Constructor
     */
    public function __construct()
    {

        $this->gvars['menu_active'] = 'cart';

    }

    public function mobileAction()
    {
        /*$em = $this->getEntityManager();
        $cart = $this->getSession()->get('cart');
        if (null == $cart) {
            $cart = new Cart();
            $em->persist($cart);
            $em->flush();
        } else {
            $cart = $em->getRepository('SamenjoyDataBundle:Cart')->findOneBy(array('id' => $cart->getId()));
            if (null == $cart) {
                $cart = new Cart();
                $em->persist($cart);
                $em->flush();
            }
        }
        $em->persist($cart);
        $em->flush();
        $this->getSession()->set('cart', $cart);
        */
        return $this->renderResponse('SamenjoyFrontBundle:Menu:cartmobile.html.twig', $this->gvars);
    }

    public function normalAction()
    {
        /*$em = $this->getEntityManager();
        $cart = $this->getSession()->get('cart');
        if (null == $cart) {
            $cart = new Cart();
            $em->persist($cart);
            $em->flush();
        } else {
            $cart = $em->getRepository('SamenjoyDataBundle:Cart')->findOneBy(array('id' => $cart->getId()));
            if (null == $cart) {
                $cart = new Cart();
                $em->persist($cart);
                $em->flush();
            }
        }
        $em->persist($cart);
        $em->flush();
        $this->getSession()->set('cart', $cart);
        $this->gvars['cart'] = $cart;*/
        return $this->renderResponse('SamenjoyFrontBundle:Menu:cart.html.twig', $this->gvars);
    }

public function pcpAction()
    {
        $gvars = array();
        $em = $this->getEntityManager();
        $collectionTypes = $em->getRepository('SamenjoyDataBundle:ColType')->getAll();
        $collectionGroups = $em->getRepository('SamenjoyDataBundle:ColGroup')->getAll();
        $brands = $em->getRepository('SamenjoyDataBundle:Brand')->getAll();

        $gvars['collectionTypes'] = $collectionTypes;
        $gvars['collectionGroups'] = $collectionGroups;
        $gvars['brands'] = $brands;

        return $this->renderResponse('SamenjoyFrontBundle:Menu:pcp.html.twig', $gvars);
    }
}