<?php

namespace App\Form;

use App\Entity\Purchase;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CartConfirmationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullname', TextType::class, $this->getConfiguration("Nom complet","Nom complet pour la livraison") )
            ->add('adress', TextareaType::class, $this->getConfiguration("Adresse","Adresse pour la livraison") )
            ->add('postalCode', TextareaType::class, $this->getConfiguration("Code postal","Code postal pour la livraison") )
            ->add('city', TextType::class, $this->getConfiguration("Ville","Ville pour la livraison") )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Purchase::class
        ]);
    }
}
