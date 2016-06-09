<?php
namespace AB\Bundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\IsTrue;

class MentorRegistrationType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName');
        $builder->add('lastName');
	    $builder->add('facebookId');
        $builder->add('linkedInId', 'text', array(
            'required' => false
        ));
        $builder->add('email', 'email', array(
            'required' => true
        ));
        $builder->add('homeCity');
        $builder->add('about', 'textarea', array(
            'trim' => false
        ));
        $builder->add('schoolName');
        $builder->add('schoolGraduationYear');
        $builder->add('schoolCity');
        $builder->add('courses', 'collection', array(
            'type' => new CourseType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'options'  => array(
                'required'  => true,
            ),
        ));
        $builder->add('terms', 'checkbox', array(
            'mapped' => false,
            "constraints" => new IsTrue(array(
                "message" => "Please accept the Terms & Conditions in order to register.")
            ))
        );
        $builder->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AB\Bundle\Entity\Mentor'
        ));
    }

    public function getName()
    {
        return 'mentor_registration';
    }
}