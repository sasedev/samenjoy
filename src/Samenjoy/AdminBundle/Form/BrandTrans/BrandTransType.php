<?php

namespace Samenjoy\AdminBundle\Form\BrandTrans;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author sasedev <seif.salah@gmail.com>
 */
class BrandTransType extends AbstractType
{

    /**
     * Form builder
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lang', 'genemu_plain', array('label' => 'BrandTrans.lang.label'));

        $builder->add('title', 'text', array('label' => 'BrandTrans.title.label'));

        $builder->add('description', 'textarea', array('label' => 'BrandTrans.description.label'));

        $builder->add('image', 'file', array('label' => 'BrandTrans.image.label', 'required' => false, 'mapped' => false));

        $builder->add('logo', 'file', array('label' => 'BrandTrans.logo.label', 'required' => false, 'mapped' => false));

        $builder->add('banner', 'file', array('label' => 'BrandTrans.banner.label', 'required' => false, 'mapped' => false));

        $builder->add('frontBanner', 'file', array('label' => 'BrandTrans.frontBanner.label', 'required' => false, 'mapped' => false));

        $builder->add('metaKeywords', 'text', array('label' => 'BrandTrans.metaKeywords.label', 'required' => false));

        $builder->add('metaDescription', 'text', array('label' => 'BrandTrans.metaDescription.label', 'required' => false));

        $builder->add('htmlTitle', 'text', array('label' => 'BrandTrans.htmlTitle.label'));

    }

    /**
     * (non-PHPdoc) @see \Symfony\Component\Form\FormTypeInterface::getName()
     *
     * @return string
     */
    public function getName()
    {

        return 'BrandAddForm';

    }

    /**
     * get the default options
     *
     * @return multitype:string multitype:string
     */
    public function getDefaultOptions()
    {

        return array(
            'validation_groups' => array('Default'),
            'data_class' => 'Samenjoy\DataBundle\Entity\BrandTrans',
            'csrf_protection' => false
        );

    }

    /**
     * (non-PHPdoc) @see
     * \Symfony\Component\Form\AbstractType::setDefaultOptions()
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver->setDefaults($this->getDefaultOptions());

    }
}
