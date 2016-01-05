<?php

namespace Samenjoy\AdminBundle\Form\Role;

use Samenjoy\DataBundle\Repository\RoleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author sasedev <seif.salah@gmail.com>
 */
class PicklistParentsTForm extends AbstractType
{

    /**
     * Form builder
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add(
            'parents',
            'entity',
            array(
                'label' => 'Parents',
                'class' => 'SamenjoyDataBundle:Role',
                'query_builder' => function (RoleRepository $rr) {
                    return $rr->createQueryBuilder('r')->orderBy('r.name', 'ASC');
                },
                'property' => 'name',
                'multiple' => true,
                'by_reference' => true,
                'required' => false
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

        return 'RolePicklistParentsForm';

    }

    /**
     * get the default options
     *
     * @return multitype:string multitype:string
     */
    public function getDefaultOptions()
    {

        return array('validation_groups' => array('Default'));

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
