<?php

namespace ProjectBundle\Form;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ClientType extends AbstractType
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
        $builder->add('firstName', TextType::class,[
            'data'=>'Test'.rand(0,100)
        ])
            ->add('lastName', TextType::class,[
                'data'=>'Test'.rand(0,100)
            ])
            ->add('email', TextType::class,[
                'data'=>'Test'.rand(0,100).'@gmail.com'
            ])
            ->add('cin', TextType::class,[
                'data'=>'EE22'.rand(0,100)
            ])
            ->add('phoneNumber', TextType::class,[
                'data'=>'076655'.rand(0,200).rand(0,100)
            ])
            ->add('save', SubmitType::class, ['label' => 'Valider']);
    }

}
