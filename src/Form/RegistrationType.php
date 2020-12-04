<?php

namespace App\Form;

use App\Entity\Customer;
use App\Form\ApplicationType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, $this->getConfiguration(false,"Pseudo"))
            ->add('email', EmailType::class, $this->getConfiguration(false,"Votre email"))
            ->add('password', PasswordType::class, $this->getConfiguration(false,"Mot de passe"))
            ->add('passwordConfirm', PasswordType::class, $this->getConfiguration(false,"Confirmer votre mot de passe"))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
