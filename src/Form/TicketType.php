<?php

namespace App\Form;

use App\Entity\Ticket;
use App\Entity\Category;
use App\Entity\Status;
use App\Entity\Responsible;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', EmailType::class, [
                'label' => 'Adresse e-mail',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'votre@email.com'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 5,
                    'placeholder' => 'Décrivez votre problème ou demande (20-250 caractères)'
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégorie',
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);

        // Ajouter les champs pour l'administration si l'utilisateur est admin
        if ($options['is_admin']) {
            $builder
                ->add('status', EntityType::class, [
                    'class' => Status::class,
                    'choice_label' => 'name',
                    'label' => 'Statut',
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ])
                ->add('responsible', EntityType::class, [
                    'class' => Responsible::class,
                    'choice_label' => 'name',
                    'label' => 'Responsable',
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
            'is_admin' => false,
        ]);
    }
}
