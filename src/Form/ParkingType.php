<?php

namespace App\Form;

use App\Entity\Parking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ParkingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre',
                'required' => true
            ])
            ->add('direccion', TextType::class, [
                'label' => 'Direccion',
                'required' => true
            ])
            ->add('latitud', NumberType::class, [
                'scale' => 3,
                'attr' => [
                    'step' => '0.001',
                    'min' => 0,
                ],
            ])
            ->add('longitud', NumberType::class, [
                'scale' => 3,
                'attr' => [
                    'step' => '0.001',
                    'min' => 0,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parking::class,
        ]);
    }
}
