<?php

namespace Pilot\OgonePaymentBundle\Builder;

use Doctrine\Common\Persistence\ObjectManager;
use Pilot\OgonePaymentBundle\Config\ConfigurationContainer;
use Pilot\OgonePaymentBundle\Batch\TransactionManager;
use Pilot\OgonePaymentBundle\Entity\OgoneAlias as Alias;
use Pilot\OgonePaymentBundle\Entity\OgoneOrder as Order;

class TransactionBuilder2
{
	protected $transactionFormBuilder;

	protected $configurationContainer;

	protected $batchTransactionManager;

	protected $om;

	protected $order;

	public function __construct(TransactionFormBuilder $transactionFormBuilder, ConfigurationContainer $configurationContainer, TransactionManager $batchTransactionManager, ObjectManager $om)
	{
		$this->transactionFormBuilder  = $transactionFormBuilder;
		$this->configurationContainer  = $configurationContainer;
		$this->batchTransactionManager = $batchTransactionManager;
		$this->om = $om;
		$this->order = new Order();
	}

	public function configure()
	{
		return $this->configurationContainer->onEnd($this);
	}

	public function resetOrder()
	{
		$this->order = new Order();

		return $this;
	}

	public function order()
	{
		return $this->order->onEnd($this);
	}

	public function getForm()
	{
		return $this
			->prepareTransaction()
			->transactionFormBuilder
			->build($this->configurationContainer)
			->getForm()
		;
	}

	public function prepareTransaction()
	{
		foreach ($this->order->toOgone() as $key => $value) {
			$this->configurationContainer->{'set'.$key}($value);
		}

		return $this;
	}

	public function useAlias(Alias $alias)
	{
		foreach ($alias->toOgone() as $key => $value) {
			$this->configurationContainer->{'set'.$key}($value);
		}

		return $this;
	}

	public function getBatchTransactionManagerCsvRow()
	{
		return $this->batchTransactionManager
			->getSaleCsvRow(
				$this->order->getAmount(),
				null,
				null,
				null,
				$this->order->getClient()->getFullname(),
				null,
				$this->order->getId(),
				$this->configurationContainer->getAlias()
			)
		;
	}

	public function save()
	{
		$this->om->persist($this->order);
		$this->om->flush();

		return $this;
	}
}
