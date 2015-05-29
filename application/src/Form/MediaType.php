<?php

namespace VT\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type');
        $builder->add('data', 'textarea', [
            'attr' => [
                'cols' => '125',
                'rows' => '5'
            ]
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VT\Entity\Media',
        ));
    }

    public function getName()
    {
        return 'media';
    }
}