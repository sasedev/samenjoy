<?php

namespace Samenjoy\FrontBundle\Controller;

use SASEdev\Commons\SharedBundle\Controller\BaseController;

/**
 *
 * @author sasedev <seif.salah@gmail.com>
 */
class DefaultController extends BaseController
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

        $this->gvars['menu_active'] = 'home';

    }

    public function indexAction()
    {
        $jsappend = array();
        $jsappend[] = 'js/home.js';
        $this->gvars['end_javascripts'] = $jsappend;

        return $this->renderResponse('SamenjoyFrontBundle:Default:index.html.twig', $this->gvars);
    }
}
