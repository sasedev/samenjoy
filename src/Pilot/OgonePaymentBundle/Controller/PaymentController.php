<?php

namespace Pilot\OgonePaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Pilot\OgonePaymentBundle\Entity\OgoneAlias as Alias;

class PaymentController extends Controller
{
	public function indexAction()
	{
		$client = $this->getRepository('SamenjoyDataBundle:User')->findOneBy(array(
			'email' => 'seif.salah@gmail.com',
		));

		if (!$client) {
			throw new NotFoundHttpException();
		}

		$transaction = $this->get('ogone.transaction_builder')
			->order()
				->setUser($client)
				->setAmount(99*100)
			->end()
			->configure()
				->setBgColor('#ffffff')
				->setAcceptUrl($this->generateUrl('ogone_payment_feedback', array(), true))
				->setDeclineUrl($this->generateUrl('ogone_payment_feedback', array(), true))
				->setExceptionUrl($this->generateUrl('ogone_payment_feedback', array(), true))
				->setCancelUrl($this->generateUrl('ogone_payment_feedback', array(), true))
				->setBackUrl($this->generateUrl('ogone_payment_feedback', array(), true))
			->end()
		;

		$transaction->save();

		if ($this->container->getParameter('ogone.use_aliases')) {
			$alias = $this->getRepository('SamenjoyDataBundle:Alias')->findOneBy(array(
				'client' => $client,
				'operation' => Alias::OPERATION_BYPSP,
				'name' => 'ABONNEMENT',
			));

			if (!$alias) {
				$alias = new Alias();
				$alias
					->setUser($client)
					->setOperation(Alias::OPERATION_BYPSP)
					->setStatus(Alias::STATUS_ACTIVE)
					->setName('ABONNEMENT')
				;

				$this->getManager()->persist($alias);
				$this->getManager()->flush();
			}

			$transaction->useAlias($alias);
		}

		$form = $transaction->getForm();

		return $this->render(
			'PilotOgonePaymentBundle:Payment:index.html.twig',
			array(
				'form' => $form->createView(),
			)
		);
	}

	public function feedbackAction()
	{
		if (!$this->get('ogone.feedbacker')->isValidCall()) {
			throw $this->createNotFoundException();
		}

		if ($this->get('ogone.feedbacker')->hasOrder()) {
			$this->get('ogone.feedbacker')->updateOrder();
		}

		if ($this->get('ogone.feedbacker')->hasAlias()) {
			$this->get('ogone.feedbacker')->updateAlias();
		}

		return $this->render(
			'PilotOgonePaymentBundle:Payment:feedback.html.twig'
		);
	}

	public function renderTemplateAction($twigPath)
	{
		$context = array();

		if ($this->get('request')->get('context')) {
			$context = json_decode(base64_decode($this->get('request')->get('context')), true);
		}

		return $this->render(
			$twigPath,
			$context
		);
	}

	protected function getRepository($name)
	{
		return $this->getManager()->getRepository($name);
	}

	protected function getManager()
	{
		return $this->getDoctrine()->getManager();
	}
}
