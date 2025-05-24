<?php

namespace App\Form;

use App\Entity\P08FigurineCaracteristique;
use App\Entity\P08Inventaire;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class InventaireType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('figurine_prix', MoneyType::class, [
                'label' => 'Prix',
                'scale' => 2,
                'empty_data' => null,
                'required' => false,
            ])
            ->add('figurine_est_possedee',CheckboxType::class, [
                'label' => 'La figurine est elle possédée?',
                'required' => false,
                ])
            ->add('figurine_echangeable', CheckboxType::class,
            ['label' => 'La figurine est elle echangeable?',
                'required' => false,
                'constraints' => [
                    new Callback([$this, 'validateCheckbox'])
                ],
            ])
            ->add('figurine_date_acquisition', DateType::class, [
                'label'=>'Date d\' aquisition',
                'widget' => 'single_text',
                'required' => false,
                'constraints' => [
                    new Callback([$this, 'validateDateAcquisition'])
                ],
            ])
            ->add('figurine_reference', EntityType::class, [
                'class' => P08FigurineCaracteristique::class,
                'choice_label' => 'figurine_nom',
                'label' => 'Référence de la figurine',
            ])
            ->add('save', SubmitType::class, ['label'=> 'Sauvegarder', 'attr'=> ['class'=>'mr-2']])
            ->add('annuler', ButtonType::class, ['label'=> 'Annuler', 'attr' => [
                'onclick' => 'window.location.href="/inventaire";'
            ]]);
    }

    // Cette méthode va être appelée pour valider le champ figurine_date_acquisition
    public function validateDateAcquisition($data, ExecutionContextInterface $context): void
    {
        $form = $context->getRoot(); // Récupérer le formulaire parent
        $figurineEstPossedee = $form->get('figurine_est_possedee')->getData(); // Récupérer la valeur du champ "figurine_est_possedee"

        // Si la figurine est possédée, vérifier que la date d'acquisition n'est pas nulle
        if ($figurineEstPossedee && $data === null) {
            $context->buildViolation('La date d\'acquisition est obligatoire pour une figurine possédée.')
                ->atPath('figurine_date_acquisition')
                ->addViolation();
        }

        // Si la figurine n'est pas possédée, vérifier que la date d'acquisition soit nulle
        if (!$figurineEstPossedee && $data !== null) {
            $context->buildViolation('La date d\'acquisition doit être vide si la figurine n\'est pas possédée.')
                ->atPath('figurine_date_acquisition')
                ->addViolation();
        }
    }

    public function validateCheckbox($data, ExecutionContextInterface $context): void
    {
        $form = $context->getRoot(); // Récupérer le formulaire parent
        $figurineEstPossedee = $form->get('figurine_est_possedee')->getData(); // Récupérer la valeur du champ "figurine_est_possedee"

        // Si la figurine n'est pas possédée, vérifier que la date d'acquisition soit nulle
        if (!$figurineEstPossedee && $data) {
            $context->buildViolation('La figurine ne peut être echangeable si la figurine n\'est pas possédée.')
                ->atPath('figurine_echangeable')
                ->addViolation();
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => P08Inventaire::class,
        ]);
    }
}
