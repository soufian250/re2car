<?php

namespace ProjectBundle\Form;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PostType extends AbstractType
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
        $builder ->add('title', TextType::class)
            ->add('body', TextareaType::class)
            ->add('slug', TextType::class)
            ->add('published', CheckboxType::class,[
                'attr'=>[
                    'style'=>'margin-top:180px'
                ],
            ])
            ->add('imageName', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'attr'=>[
                    'class'=>'form-control mb-2'
                ]
            ])
            ->add('save', SubmitType::class, ['label' => 'Valider']);
    }

}