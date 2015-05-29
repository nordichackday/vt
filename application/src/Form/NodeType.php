<?php

namespace VT\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('label');
        $builder->add('mediaId', 'choice', [
            'label' => 'Widget',
            'choices'  => array('1' => 'map', '2' => 'image'),
            'required' => false,
        ]);
        $builder->add('media', 'collection', ['type' => new MediaType()]);
        $builder->add('body', 'textarea', [
            'attr' => [
                'cols' => '80',
                'rows' => '5'
            ]
        ]);

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