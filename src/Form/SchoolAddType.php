<?php

namespace App\Form;

use App\Entity\School;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\City;

class SchoolAddType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Nom", "Nom usuel de l'école"))
            ->add('address', TextType::class, $this->getConfiguration("Adresse", "Adresse de l'école"))
            ->add('city', EntityType::class, array('class' => City::class,
                'choice_label' => 'Name',
                'label' => "Indiquez la ville",
                'placeholder' => "Indiquez la ville"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => School::class,
        ]);
    }
}
