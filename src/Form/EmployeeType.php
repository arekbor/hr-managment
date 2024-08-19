<?php

namespace App\Form;

use Alsatian\FormBundle\Form\ExtensibleEntityType;
use App\Entity\Employee;
use App\Entity\Position;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', EmailType::class)
            ->add('positions', ExtensibleEntityType::class, [
                'class' => Position::class,
                'route' => 'app_position_getpositions',
                'multiple' => 'true',
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
            'positions' => []
        ]);
    }
}
