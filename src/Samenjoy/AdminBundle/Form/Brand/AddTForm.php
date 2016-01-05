<?php

namespace Samenjoy\AdminBundle\Form\Brand;

use Samenjoy\AdminBundle\Form\BrandTrans\BrandTransType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author sasedev <seif.salah@gmail.com>
 */
class AddTForm extends AbstractType
{

    /**
     * Form builder
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('label' => 'Brand.name.label'));

        $builder->add('title', 'text', array('label' => 'Brand.title.label'));

        $builder->add('description', 'textarea', array('label' => 'Brand.description.label'));

        $builder->add('image', 'file', array('label' => 'Brand.image.label', 'required' => false));

        $builder->add('logo', 'file', array('label' => 'Brand.logo.label', 'required' => false));

        $builder->add('banner', 'file', array('label' => 'Brand.banner.label', 'required' => false));

        $builder->add('frontBanner', 'file', array('label' => 'Brand.frontBanner.label', 'required' => false));

        $builder->add('metaKeywords', 'text', array('label' => 'Brand.metaKeywords.label', 'required' => false));

        $builder->add('metaDescription', 'text', array('label' => 'Brand.metaDescription.label', 'required' => false));

        $builder->add('htmlTitle', 'text', array('label' => 'Brand.htmlTitle.label'));


        $builder->add(
            'translations',
            'collection',
            array(
                'label'                 => 'Brand.translations.label',
                'type'                  => new BrandTransType(),
                'allow_add'             => false,
                'allow_delete'          => false,
                'by_reference'          => true
            )
        );

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
            'validation_groups' => array('Default', 'create'),
            'data_class' => 'Samenjoy\DataBundle\Entity\Brand',
            'cascade_validation' => true
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