<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class ResaChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDeb', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => array(
                    'min' => (new \DateTime())->format('Y-m-d H:i'),
                    'max' => (new \DateTime('+1 year'))->format('Y-m-d H:i'),
                )
            ])
            ->add('dateFin', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => array(
                    'min' => (new \DateTime())->format('Y-m-d H:i'),
                    'max' => (new \DateTime('+1 year'))->format('Y-m-d H:i'),
                )
            ])
            ->add('telephone', TelType::class, [
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
