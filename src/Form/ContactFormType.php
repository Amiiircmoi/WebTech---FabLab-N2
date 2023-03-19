<?php

namespace App\Form;

use App\Entity\ContactForm;
use App\Entity\EventType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', TextareaType::class, [
                'label' => 'Message',
            ])
            ->add('eventDate', DateType::class, [
                'label' => 'Date de l\'événement',
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'Date de l\'événement',
                ],
            ])
            ->add('contactName', TextType::class, [
                'attr' => [
                    'placeholder' => 'Prénom NOM',
                ],
            ])
            ->add('contactMail', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Email',
                ],
            ])
            ->add('contactPhone', TelType::class, [
                'attr' => [
                    'placeholder' => 'Téléphone (optionnel)',
                ],
                ])
            ->add('eventType', EntityType::class, [
                'class' => EventType::class,
                'choice_label' => 'name',
                'label' => 'Type d\'événement',
                'attr' => [
                    'placeholder' => 'Type d\'événement',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactForm::class,
        ]);
    }
}
