<?php

namespace App\Form;

use App\Entity\Responsible;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsibleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du responsable',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom du responsable'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail du responsable',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'responsable@agence.com'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Responsible::class,
        ]);
    }
}
