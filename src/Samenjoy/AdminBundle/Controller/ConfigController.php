<?php

namespace Samenjoy\AdminBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Samenjoy\AdminBundle\Form\Role\AddTForm;
use Samenjoy\AdminBundle\Form\Role\EditTForm;
use Samenjoy\AdminBundle\Form\Role\PicklistParentsTForm;
use Samenjoy\DataBundle\Entity\Role;
use SASEdev\Commons\SharedBundle\Controller\BaseController;

/**
 *
 * @author sasedev <seif.salah@gmail.com>
 */
class ConfigController extends BaseController
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

        $this->gvars['menu_active'] = 'gears';

    }

    public function roleListAction($page = 1)
    {

        $em = $this->getEntityManager();
        $roles = $em->getRepository('SamenjoyDataBundle:Role')->getAll();
        
        $this->gvars['roles'] = $roles;

        $this->gvars['pagetitle_txt'] = 'Liste des Privilèges';
        $this->gvars['pagetitle'] = 'Liste des Privilèges';
        $this->gvars['smenu_active1'] = 'role.list';

        return $this->renderResponse('SamenjoyAdminBundle:Config:roleList.html.twig', $this->gvars);
    }

    /**
     * Role Add
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function roleAddGetAction()
    {
        $role = new Role();
        $roleAddForm = $this->createForm(new AddTForm(), $role);

        $this->gvars['role'] = $role;
        $this->gvars['RoleAddForm'] = $roleAddForm->createView();

        $this->gvars['pagetitle_txt'] = 'Nouveau Privilège';
        $this->gvars['pagetitle'] = 'Nouveau Privilège';
        $this->gvars['smenu_active1'] = 'role.add';

        return $this->renderResponse('SamenjoyAdminBundle:Config:roleAdd.html.twig', $this->gvars);
    }

    /**
     * Role Add
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function roleAddPostAction()
    {
        $role = new Role();
        $roleAddForm = $this->createForm(new AddTForm(), $role);

        $this->gvars['role'] = $role;
        $this->gvars['RoleAddForm'] = $roleAddForm->createView();

        $request = $this->getRequest();
        $reqData = $request->request->all();

        if (isset($reqData['RoleAddForm'])) {
            $roleAddForm->bind($request);
            if ($roleAddForm->isValid()) {
                $em = $this->getEntityManager();
                foreach ($role->getParents() as $parent) {
                    $parent->addChild($role);
                    $em->persist($parent);
                }
                $em->persist($role);
                $em->flush();
                $this->flashMsgSession(
                    'success',
                    'Ajout Avec Succès du Role '.$role->getName()
                );

                return $this->redirect($this->generateUrl('_admin_config_role_editGet', array('uid' => $role->getId())));
            } else {
                $this->flashMsgSession(
                    'error',
                    'Une Erreur s\'est produite lors de la tentative d\'ajout du Role '.$role->getName()
                );
            }
        }

        $this->gvars['pagetitle_txt'] = 'Nouveau Privilège';
        $this->gvars['pagetitle'] = 'Nouveau Privilège';
        $this->gvars['smenu_active1'] = 'role.add';

        return $this->renderResponse('SamenjoyAdminBundle:Config:roleAdd.html.twig', $this->gvars);
    }

    /**
     * Role Edit
     *
     * @param guid $uid
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function roleEditGetAction($uid)
    {
        $urlFrom = $this->getReferer();
        if (null == $urlFrom || trim($urlFrom) == '') {
            $urlFrom = $this->generateUrl('_admin_config_role_list');
        }

        $em = $this->getEntityManager();
        try {
            $role = $em->getRepository('SamenjoyDataBundle:Role')->find($uid);

            if (null == $role) {
                $this->flashMsgSession('warning', 'Role inconnu');
            } else {
                $roleEditForm = $this->createForm(new EditTForm(), $role);
                $rolePicklistParentsForm = $this->createForm(new PicklistParentsTForm(), $role);

                $this->gvars['role'] = $role;
                $this->gvars['RoleEditForm'] = $roleEditForm->createView();
                $this->gvars['RolePicklistParentsForm'] = $rolePicklistParentsForm->createView();

                $this->gvars['tabActive'] = $this->getSession()->get('tabActive', 1);
                $this->getSession()->remove('tabActive');

                $this->gvars['pagetitle_txt'] = 'Edition du Privilège '.$role->getName();

                $this->gvars['pagetitle'] = 'Edition du Privilège <b>'.$role->getName().'</b>';

                $this->gvars['smenu_active1'] = 'role.edit';

                return $this->renderResponse('SamenjoyAdminBundle:Config:roleEdit.html.twig', $this->gvars);
            }
        } catch (\Exception $e) {
            $logger = $this->getLogger();
            $logger->addCritical($e->getLine().' '.$e->getMessage().' '.$e->getTraceAsString());
        }

        return $this->redirect($urlFrom);
    }

    /**
     * Role Edit (Post Method)
     *
     * @param guid $uid
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function roleEditPostAction($uid)
    {
        $urlFrom = $this->getReferer();
        if (null == $urlFrom || trim($urlFrom) == '') {
            return $this->redirect($this->generateUrl('_admin_config_role_list'));
        }

        $em = $this->getEntityManager();
        try {
            $role = $em->getRepository('SamenjoyDataBundle:Role')->find($uid);

            if (null == $role) {
                $this->flashMsgSession('warning', 'Role.editNotfound');
            } else {
                $roleEditForm = $this->createForm(new EditTForm(), $role);
                $rolePicklistParentsForm = $this->createForm(new PicklistParentsTForm(), $role);

                $originalParents = new ArrayCollection();
                foreach ($role->getParents() as $parent) {
                    $originalParents->add($parent);
                }

                $this->gvars['tabActive'] = $this->getSession()->get('tabActive', 2);
                $this->getSession()->remove('tabActive');

                $request = $this->getRequest();
                $reqData = $request->request->all();

                if (isset($reqData['RoleEditForm'])) {
                    $this->gvars['tabActive'] = 2;
                    $this->getSession()->set('tabActive', 2);
                    $roleEditForm->bind($request);
                    if ($roleEditForm->isValid()) {
                        $em->persist($role);
                        $em->flush();
                        $this->flashMsgSession(
                            'success',
                            'Modification avec succès du Role '.$role->getName()
                        );

                        return $this->redirect($urlFrom);
                    } else {
                        $em->refresh($role);

                        $this->flashMsgSession(
                            'error',
                            'Erreur lors de la modification du Role '.$role->getName()
                        );
                    }
                } elseif (isset($reqData['RolePicklistParentsForm'])) {
                    $this->gvars['tabActive'] = 2;
                    $this->getSession()->set('tabActive', 2);
                    $rolePicklistParentsForm->bind($request);
                    if ($rolePicklistParentsForm->isValid()) {
                        foreach ($originalParents as $parent) {
                            if (false === $role->getParents()->contains($parent)) {
                                $parent->removeChild($role);
                            } else {
                                $parent->addChild($role);
                            }
                            $em->persist($parent);
                        }
                        foreach ($role->getParents() as $parent) {
                            $parent->addChild($role);
                            $em->persist($parent);
                        }

                        $em->persist($role);
                        $em->flush();
                        $this->flashMsgSession(
                            'success',
                            'Modification avec succès du Role '.$role->getName()
                        );

                        return $this->redirect($urlFrom);
                    } else {
                        $em->refresh($role);

                        $this->flashMsgSession(
                            'error',
                            'Erreur lors de la modification du Role '.$role->getName()
                        );
                    }
                }

                $this->gvars['tabActive'] = 2;

                $this->gvars['role'] = $role;
                $this->gvars['RoleEditForm'] = $roleEditForm->createView();
                $this->gvars['RolePicklistParentsForm'] = $rolePicklistParentsForm->createView();

                $this->gvars['pagetitle_txt'] = 'Edition du Privilège '.$role->getName();

               $this->gvars['pagetitle'] = 'Edition du Privilège <b>'.$role->getName().'</b>';

                $this->gvars['smenu_active1'] = 'role.edit';

                return $this->renderResponse('SamenjoyAdminBundle:Config:roleEdit.html.twig', $this->gvars);
            }
        } catch (\Exception $e) {
            $logger = $this->getLogger();
            $logger->addCritical($e->getLine().' '.$e->getMessage().' '.$e->getTraceAsString());
        }

        return $this->redirect($urlFrom);

    }

    /**
     * Role Delete
     *
     * @param guid $uid
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function roleDeleteAction($uid)
    {
        $urlFrom = $this->getReferer();
        if (null == $urlFrom || trim($urlFrom) == '') {
            return $this->redirect($this->generateUrl('_admin_config_role_list'));
        }

        $em = $this->getEntityManager();
        try {
            $role = $em->getRepository('SamenjoyDataBundle:Role')->find($uid);
            if (null == $role) {
                $this->flashMsgSession('warning', 'Role introuvable');
            } else {
                $em->remove($role);
                $em->flush();

                $this->flashMsgSession(
                    'success',
                    'Le Privilège '.$role->getName().' a été supprimé abec succès'
                );
            }
        } catch (\Exception $e) {
            $logger = $this->getLogger();
            $logger->addCritical($e->getLine().' '.$e->getMessage().' '.$e->getTraceAsString());

            $this->flashMsgSession('error', $this->translate('Erreur lors de la tentative de suppression de Role'));
        }

        return $this->redirect($urlFrom);
    }
}
