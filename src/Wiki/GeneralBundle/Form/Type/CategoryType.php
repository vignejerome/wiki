<?php

namespace Wiki\GeneralBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('category', 'entity', array('class' => 'Wiki\GeneralBundle\Entity\Category',
                                            'property' => 'name'));
    }

    public function getName()
    {
        return 'category';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wiki\GeneralBundle\Entity\Category',
        ));
    }
}
