<?php

namespace Samenjoy\AdminBundle\Form\Brand;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author sasedev <seif.salah@gmail.com>
 */
class EditTForm extends AbstractType
{

    /**
     * Form builder
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('label' => 'Brand.title.label'));

        $builder->add('description', 'textarea', array('label' => 'Brand.description.label'));

        $builder->add('metaKeywords', 'text', array('label' => 'Brand.metaKeywords.label', 'required' => false));

        $builder->add('metaDescription', 'text', array('label' => 'Brand.metaDescription.label', 'required' => false));

        $builder->add('htmlTitle', 'text', array('label' => 'Brand.htmlTitle.label'));

    }

    /**
     * (non-PHPdoc) @see \Symfony\Component\Form\FormTypeInterface::getName()
     *
     * @return string
     */
    public function getName()
    {

        return 'BrandEditForm';

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
            'data_class' => 'Samenjoy\DataBundle\Entity\Brand'
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