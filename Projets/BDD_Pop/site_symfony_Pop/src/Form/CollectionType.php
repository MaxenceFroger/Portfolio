<?php

namespace App\Form;

use App\Entity\P08Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
class CollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('collection_nom', TextType::class, ['label'=>'Nom de la collection',
                 'trim' => true,
                'empty_data' => '',
                ]
            )
            ->add('collection_licence', TextType::class, [
                'label'=>'Nom de la license',
                'empty_data' => '',
            ])
            ->add('collection_categorie', TextType::class, [
                'label'=>'Nom de la catégorie',
                'empty_data' => '',
            ])
            ->add('save', SubmitType::class, ['label'=> 'Sauvegarder', 'attr'=> ['class'=>'mr-2']])
            ->add('annuler', ButtonType::class, ['label'=> 'Annuler', 'attr' => [
                'onclick' => 'window.location.href="/collection";'
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => P08Collection::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'update_collection',
            'attr' => [
                'novalidate' => 'novalidate', // comment me to reactivate the html5 validation!  🚥
            ]
        ]);
    }
}
