<?php

namespace Samenjoy\AdminBundle\Controller;

use SASEdev\Commons\SharedBundle\Controller\BaseController;
use Samenjoy\DataBundle\Entity\BrandTrans;
use Samenjoy\DataBundle\Entity\Brand;
use Samenjoy\AdminBundle\Form\Brand\AddTForm;
use Samenjoy\AdminBundle\Form\Brand\EditTForm;

/**
 *
 * @author sasedev <seif.salah@gmail.com>
 */
class BrandController extends BaseController
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

	public function listAction($page = 1)
	{

		$em = $this->getEntityManager();
		$brands = $em->getRepository('SamenjoyDataBundle:Brand')->getAll();

		$this->gvars['brands'] = $brands;

		$this->gvars['pagetitle_txt'] = 'Liste des Marques';
		$this->gvars['pagetitle'] = 'Liste des Marques';
		$this->gvars['smenu_active1'] = 'brand.list';

		return $this->renderResponse('SamenjoyAdminBundle:Brand:list.html.twig', $this->gvars);
	}

	/**
	 * Brand Add
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function addGetAction()
	{
		$langFR = 'fr';
		$langEN = 'en';
		$langNL = 'nl';

		$brand = new Brand();

		$brandFR = new BrandTrans();
		$brandFR->setBrand($brand);
		$brandFR->setLang($langFR);
		$brand->addTranslation($brandFR);

		$brandEN = new BrandTrans();
		$brandEN->setBrand($brand);
		$brandEN->setLang($langEN);
		$brand->addTranslation($brandEN);

		$brandNL = new BrandTrans();
		$brandNL->setBrand($brand);
		$brandNL->setLang($langNL);
		$brand->addTranslation($brandNL);

		$brandAddForm = $this->createForm(new AddTForm(), $brand);

		$this->gvars['brand'] = $brand;
		$this->gvars['BrandAddForm'] = $brandAddForm->createView();

		$this->gvars['pagetitle_txt'] = 'Nouvelle Marque';
		$this->gvars['pagetitle'] = 'Nouvelle Marque';
		$this->gvars['smenu_active1'] = 'brand.add';

		return $this->renderResponse('SamenjoyAdminBundle:Brand:add.html.twig', $this->gvars);
	}

	/**
	 * Brand Add Post
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function addPostAction()
	{
		$langFR = 'fr';
		$langEN = 'en';
		$langNL = 'nl';

		$brand = new Brand();

		$brandFR = new BrandTrans();
		$brandFR->setBrand($brand);
		$brandFR->setLang($langFR);
		$brand->addTranslation($brandFR);

		$brandEN = new BrandTrans();
		$brandEN->setBrand($brand);
		$brandEN->setLang($langEN);
		$brand->addTranslation($brandEN);

		$brandNL = new BrandTrans();
		$brandNL->setBrand($brand);
		$brandNL->setLang($langNL);
		$brand->addTranslation($brandNL);

		$brandAddForm = $this->createForm(new AddTForm(), $brand);

		$request = $this->getRequest();
		$reqData = $request->request->all();

		if (isset($reqData['BrandAddForm'])) {
			$brandAddForm->bind($request);
			if ($brandAddForm->isValid()) {

				$imageFile = $brandAddForm['image']->getData();
				$logoFile = $brandAddForm['logo']->getData();
				$bannerFile = $brandAddForm['banner']->getData();
				$frontBannerFile = $brandAddForm['frontBanner']->getData();

				if (null != $imageFile) {
					$imagesDir = __DIR__.'/../../../../web/images/brand/images';
					$newfilename = sha1(uniqid(mt_rand(), true)).'.'.$imageFile->guessExtension();
					$imageFile->move($imagesDir, $newfilename);
					$brand->setImage($newfilename);
				}

				if (null != $logoFile) {
					$logosDir = __DIR__.'/../../../../web/logos/brand/logos';
					$newfilename = sha1(uniqid(mt_rand(), true)).'.'.$logoFile->guessExtension();
					$logoFile->move($logosDir, $newfilename);
					$brand->setLogo($newfilename);
				}

				if (null != $bannerFile) {
					$bannersDir = __DIR__.'/../../../../web/banners/brand/banners';
					$newfilename = sha1(uniqid(mt_rand(), true)).'.'.$bannerFile->guessExtension();
					$bannerFile->move($bannersDir, $newfilename);
					$brand->setBanner($newfilename);
				}

				if (null != $frontBannerFile) {
					$frontBannersDir = __DIR__.'/../../../../web/frontBanners/brand/frontBanners';
					$newfilename = sha1(uniqid(mt_rand(), true)).'.'.$frontBannerFile->guessExtension();
					$frontBannerFile->move($frontBannersDir, $newfilename);
					$brand->setFrontBanner($newfilename);
				}

				$em = $this->getEntityManager();
				$em->persist($brand);
				$em->flush();
				$this->flashMsgSession(
					'success',
					'Ajout Avec Succès de la Marque '.$brand->getName()
				);

				return $this->redirect($this->generateUrl('_admin_brand_editGet', array('uid' => $brand->getId())));
			} else {
				$this->flashMsgSession(
					'error',
					'Une Erreur s\'est produite lors de la tentative d\'ajout de la Marque '.$brand->getName()
				);
			}
		}

		$this->gvars['brand'] = $brand;
		$this->gvars['BrandAddForm'] = $brandAddForm->createView();

		$this->gvars['pagetitle_txt'] = 'Nouvelle Marque';
		$this->gvars['pagetitle'] = 'Nouvelle Marque';
		$this->gvars['smenu_active1'] = 'brand.add';

		return $this->renderResponse('SamenjoyAdminBundle:Brand:add.html.twig', $this->gvars);
	}

	/**
	 * Role Edit
	 *
	 * @param guid $uid
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function editGetAction($uid)
	{
		$urlFrom = $this->getReferer();
		if (null == $urlFrom || trim($urlFrom) == '') {
			$urlFrom = $this->generateUrl('_admin_brand_list');
		}

		$em = $this->getEntityManager();
		try {
			$brand = $em->getRepository('SamenjoyDataBundle:Brand')->find($uid);

			if (null == $brand) {
				$this->flashMsgSession('warning', 'Marque inconnue');
			} else {
				$brandEditForm = $this->createForm(new EditTForm(), $brand);

				$this->gvars['brand'] = $brand;
				$this->gvars['BrandEditForm'] = $brandEditForm->createView();

				$this->gvars['tabActive'] = $this->getSession()->get('tabActive', 1);
				$this->getSession()->remove('tabActive');

				$this->gvars['pagetitle_txt'] = 'Edition de la Marque '.$brand->getName();

				$this->gvars['pagetitle'] = 'Edition de la Marque <b>'.$brand->getName().'</b>';

				$this->gvars['smenu_active1'] = 'brand.edit';

				return $this->renderResponse('SamenjoyAdminBundle:Brand:edit.html.twig', $this->gvars);
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
	public function deleteAction($uid)
	{
		$urlFrom = $this->getReferer();
		if (null == $urlFrom || trim($urlFrom) == '') {
			return $this->redirect($this->generateUrl('_admin_brand_list'));
		}

		$em = $this->getEntityManager();
		try {
			$brand = $em->getRepository('SamenjoyDataBundle:Brand')->find($uid);
			if (null == $brand) {
				$this->flashMsgSession('warning', 'Marque introuvable');
			} else {
				$em->remove($brand);
				$em->flush();

				$this->flashMsgSession(
					'success',
					'La Marque '.$brand->getName().' a été supprimé avec succès'
				);
			}
		} catch (\Exception $e) {
			$logger = $this->getLogger();
			$logger->addCritical($e->getLine().' '.$e->getMessage().' '.$e->getTraceAsString());

			$this->flashMsgSession('error', $this->translate('Erreur lors de la tentative de suppression de la Marque'));
		}

		return $this->redirect($urlFrom);
	}
}
