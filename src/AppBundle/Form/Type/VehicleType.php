<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('range', 'choice', array(
                'choices' => array(
                    Vehicle::BASIC => 'XWing',
                    Vehicle::ELITE => 'TieFighter'
                )
            ))
            ->add('color', 'text', array(
                'required' => false,
            ))
            ->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Vehicle',
        ));
    }

    public function getName()
    {
        return 'app_vehicle_type';
    }
}