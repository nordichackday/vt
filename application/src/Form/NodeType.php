<?php

namespace VT\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('mediaId');
        $builder->add('intro');
        $builder->add('body');
        $builder->add('timestamp');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VT\Entity\Node',
        ));
    }

    public function getName()
    {
        return 'node';
    }
}