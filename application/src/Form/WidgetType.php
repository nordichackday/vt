<?php

namespace VT\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WidgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $widget = $event->getData();
            $form = $event->getForm();

            switch($widget->getType()) {
                case 'map':
                    $form->add('x1');
                    $form->add('y1');
                    $form->add('x2');
                    $form->add('y2');
                    break;
                case 'image':
                    $form->add('path');
                    $form->add('altText');
                    break;
            }
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VT\Entity\Widget',
        ));
    }

    public function getName()
    {
        return 'widget';
    }
}