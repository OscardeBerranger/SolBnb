<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Equipment;
use App\Entity\Property;
use App\Repository\CategoryRepository;
use App\Repository\EquipmentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('area')
            ->add('rooms')
            ->add('toilets')
            ->add('bedrooms')
            ->add('beds')
            ->add('bathrooms')
            ->add('category', EntityType::class, [
                'class'=>Category::class,
                'choice_label'=>'name',
                'query_builder'=>function(CategoryRepository $categoryRepository){
                return $categoryRepository->createQueryBuilder('cat')
                    ->orderBy('cat.name', 'ASC');
                },
            ])
            ->add('equipments', EntityType::class, [
                'class'=>Equipment::class,
                'query_builder' => function (EquipmentRepository $equipmentRepository) {
                    return $equipmentRepository->createQueryBuilder('equipment')
                        ->orderBy('equipment.name', 'ASC');
                },
                'choice_label' => 'name',
                'expanded'=>true,
                'multiple'=>true,
                'label'=>'Equipement'
            ])
            ->add('property', CollectionType::class, [
                'entry_type'=>PropertyType::class,
                'allow_add'=>true,
                'allow_delete'=>true,
                'required'=>true,
                'by_reference'=>false,
                'disabled'=>false,
                'prototype'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
