<?php

namespace App\Form;

use App\Entity\School;
use App\Entity\Teacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TeacherAddSchoolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('schools', EntityType::class, [
                    'class' => School::class,
                    'choice_label' => 'title',
                    'multiple' => 'true',
                    'expanded' => 'true',
                    'data_class' => null
            ])
            ->add('schools', EntityType::class, [
                    'class' => School::class,
                    'choice_label' => 'title',
                    'multiple' => 'true',
                    'expanded' => 'true',
                    'data_class' => null,
                    'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
