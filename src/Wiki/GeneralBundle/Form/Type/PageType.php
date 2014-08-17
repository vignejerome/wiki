<?php

namespace Wiki\GeneralBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('category', 'entity', array(
                'class' => 'Wiki\GeneralBundle\Entity\Category',
                'property' => 'name'))
          ->add('title', 'text')
          ->add('body', 'textarea' , array('attr' => array('cols' => '5', 'rows' => '10')))
          ->add('date', 'hidden', array('data' => date('m.d.y')))
          ->add('save', 'submit')
        ;
    }

    public function getName()
    {
        return 'page';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wiki\GeneralBundle\Entity\Page',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // une clé unique pour aider à la génération du jeton secret
            'intention'       => 'page_item',
        ));
    }
}
