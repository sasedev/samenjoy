<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new JMS\AopBundle\JMSAopBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new BCC\ExtraToolsBundle\BCCExtraToolsBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Liuggio\ExcelBundle\LiuggioExcelBundle(),
            new Gregwar\FormBundle\GregwarFormBundle(),
            new Genemu\Bundle\FormBundle\GenemuFormBundle(),
            new Lunetics\LocaleBundle\LuneticsLocaleBundle(),
            new Pilot\OgonePaymentBundle\PilotOgonePaymentBundle(),

            new SASEdev\Commons\SharedBundle\SASEdevCommonsSharedBundle(),
            new SASEdev\Commons\TwigBundle\SASEdevCommonsTwigBundle(),
            new SASEdev\Commons\BootstrapBundle\SASEdevCommonsBootstrapBundle(),
            new SASEdev\Commons\PostgresqlBundle\SASEdevCommonsPostgresqlBundle(),

            new Samenjoy\AdminBundle\SamenjoyAdminBundle(),
            new Samenjoy\DataBundle\SamenjoyDataBundle(),
            new Samenjoy\FrontBundle\SamenjoyFrontBundle(),
            new Samenjoy\ResBundle\SamenjoyResBundle(),
            new Samenjoy\SecurityBundle\SamenjoySecurityBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
