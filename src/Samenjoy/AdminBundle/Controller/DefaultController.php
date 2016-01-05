<?php

namespace Samenjoy\AdminBundle\Controller;

use SASEdev\Commons\SharedBundle\Controller\BaseController;

/**
 *
 * @author sasedev <seif.salah@gmail.com>
 */
class DefaultController extends BaseController
{
    public function indexAction()
    {
        return $this->renderResponse('SamenjoyAdminBundle:Default:index.html.twig');
    }
}
