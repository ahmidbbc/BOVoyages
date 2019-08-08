<?php

namespace App\Form;

use App\Entity\Travel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TravelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('destination')
            ->add('details')
            ->add('fromDate', DateType::class)
            ->add('toDate',DateType::class)
            ->add('maxGuests')
            ->add('retailPrice')
            ->add('discountRate')
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'A la vente' => 0,
                    'Réservé' => 1,
                    'En attente paiement' => 2,
                    'Contrôle disponibilité' => 3,
                    'Accepté' => 4,
                    'Refusé' => 5
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Travel::class,
        ]);
    }
}
