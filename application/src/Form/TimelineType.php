<?php

namespace VT\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TimelineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('intro', 'textarea', [
            'attr' => [
                'cols' => '125',
                'rows' => '5'
            ]
        ]);
        $builder->add('nodes', 'collection', [
            'label' => 'Nodes',
            'type' => new NodeType()
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VT\Entity\Timeline',
        ));
    }

    public function getName()
    {
        return 'timeline';
    }
}