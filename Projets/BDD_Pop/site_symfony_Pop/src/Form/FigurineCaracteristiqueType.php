<?php

namespace App\Form;

use App\Entity\P08Collection;
use App\Entity\P08FigurineCaracteristique;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints as Assert;

class FigurineCaracteristiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('figurine_reference', IntegerType::class, [
                'label' => 'Référence de la figurine',
                'empty_data' => '',
            ])
            ->add('figurine_nom', TextType::class, [
                'label'=>'Nom de la figurine',
                'empty_data' => '',
            ])
            ->add('figurine_personnage', TextType::class, [
                'label'=>'Nom du personnage',
                'empty_data' => '',
            ])
            ->add('figurine_taille', IntegerType::class, [
                'label' => 'Taille',
            ])
            ->add('figurine_date_sortie',DateType::class, ['label'=>'Date de sortie', 'widget' => 'single_text'])

            ->add('figurine_popid', IntegerType::class, [
                'label' => 'Pop ID',
            ])
            ->add('figurine_chase')
            ->add('collection_id', EntityType::class, [
                'class' => P08Collection::class,
                'choice_label' => 'collection_nom',
                'label' => 'Collection',
                'attr' => ['class' => 'select2-ajax'],
            ])
            ->add('save', SubmitType::class, ['label'=> 'Sauvegarder', 'attr'=> ['class'=>'mr-2']])
            ->add('annuler', ButtonType::class, ['label'=> 'Annuler', 'attr' => [
                'onclick' => 'window.location.href="/figurine";'
            ]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => P08FigurineCaracteristique::class,
        ]);
    }
}
