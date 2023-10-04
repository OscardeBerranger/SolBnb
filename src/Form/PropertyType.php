<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Property;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
