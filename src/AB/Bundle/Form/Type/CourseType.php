<?php
namespace AB\Bundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('university', 'text');
        $builder->add('college');
        $builder->add('startYear');
        $builder->add('graduationYear');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AB\Bundle\Entity\Course'
        ));
    }

    public function getName()
    {
        return 'course';
    }
}