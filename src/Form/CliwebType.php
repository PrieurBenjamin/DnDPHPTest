<?php

namespace App\Form;

use App\Entity\Cliweb;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CliwebType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Sku')
            ->add('Status')
            ->add('Price')
            ->add('Description')
            ->add('Created_at')
            ->add('Slug')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cliweb::class,
        ]);
    }
}
