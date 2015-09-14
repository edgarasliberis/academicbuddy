<?php
namespace AB\Bundle\Form\Type;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class PupilProfileType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName');
        $builder->add('lastName');
        //$builder->add('email', 'email', array());
        $builder->add('homeCity');

        $builder->add('schoolName');
        $builder->add('schoolGraduationYear');
        $builder->add('schoolCity');
        $builder->add('schoolGrade', 'number');

        $builder->add('courseCategory');
        $builder->add('universityRegion', 'choice', array (
            'choices' => array('England' => 'Anglija',
                'London' => 'Londonas',
                'Scotland' => 'Škotija',
                'Other' => 'kitas/bet kuris'
            )
        ));
        /*$builder->add('universityRegion', 'choice', array (
            'choices' => array('University of Cambridge' => 'Kembridžo universitetas',
                'University of Oxford' => 'Oksfordo universitetas',
                '(no choice)' => 'Dar neapsisprendžiau'
            )
        ));*/
        $builder->add('courseName');

        $builder->add('motivation', 'textarea', array(
            'trim' => false,
            'required' => true
        ));
        $builder->add('about', 'textarea', array(
            'trim' => false,
            'required' => true
        ));
        //$builder->add('save', 'submit');
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AB\Bundle\Entity\Pupil'
        ));
    }
    public function getName()
    {
        return 'user_details_edit';
    }
}