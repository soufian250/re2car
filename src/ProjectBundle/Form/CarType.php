<?php

namespace ProjectBundle\Form;

use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\ORM\EntityManagerInterface;
use ProjectBundle\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Validator\Constraints\File;

class CarType extends AbstractType
{

    private $entityManager;
    private $container;

    public function __construct(EntityManagerInterface $entityManager,Container $container)
    {
        $this->entityManager = $entityManager;
        $this->container=$container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('matriclue', TextType::class,[
            'data'=>'JHUHSUHS'.rand(5,100)
        ])
            ->add('name', TextType::class,[
                 'data' => 'Audi',
            ])
            ->add('seat', TextType::class,[
                 'data' => 4,
            ])
            ->add('door', TextType::class,[
                 'data' => 4,
            ])
            ->add('transmission', TextType::class,[
                 'data' => 'Automatique',
            ])
            ->add('fuel', TextType::class,[
                 'data' => 'Petrol',
            ])
            ->add('air_conditioner', CheckboxType::class,[
                'required'=>false
            ])
            ->add('passenger', TextType::class,[
                 'data' => 4,
            ])
            ->add('type',EntityType::class,array(
                'class'=>Type::class,
                'choice_label'=>'name',
                'required'=>false,

            ))
            ->add('imageName', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'attr'=>[
                    'class'=>'form-control mb-2'
                ],
                'constraints' => [
                    new File([
                        'maxSize' => "5M",
                        'mimeTypes' => [
                            "image/jpeg",
                            "image/jpg",
                            "image/png",
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('insurance_date',DateType::class,array(
                'widget' => 'single_text',
                'choice_translation_domain'=>true,
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ]
            ))->add('rentAmount', MoneyType::class,[
                'currency'=>'MAD'
            ])
            ->add('caution', MoneyType::class,[
                'currency'=>'MAD'
            ])
            ->add('save', SubmitType::class, ['label' => 'Valider']);
    }

}