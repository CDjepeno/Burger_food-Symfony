<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration("Nom","nom du produit",['data_class' => null]))
            ->add('price', NumberType::class, $this->getConfiguration("Prix","prix de vente",['data_class' => null]))
            ->add('description', TextareaType::class, $this->getConfiguration("Description","description du produit",['data_class' => null]))
            ->add('image', FileType::class, $this->getConfiguration("Image","image du produit",['data_class' => null]))
            ->add('category', EntityType::class,[
                "choice_label" => "name", 
                "class"        => Category::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
