<?php

namespace ProjectBundle\Form;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use ProjectBundle\Entity\Car;
use ProjectBundle\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\Container;

class ReservationType extends AbstractType
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
        $builder
            ->add('client',EntityType::class,array(
                'class'=>Client::class,
                'choice_label'=>'firstName',
                'required'=>true,
               /* 'query_builder'=>function(EntityRepository $er){
                    return $er->createQueryBuilder('c')
                        ->Where('c.statusReservation = :statusReservation')
                        ->setParameter('statusReservation',false);
                }*/
            ))
            ->add('car',EntityType::class,array(
                'class'=>Car::class,
                'choice_label'=>'name',
                'required'=>true,
                'query_builder'=>function(EntityRepository $er){
                    return $er->createQueryBuilder('c')
                         ->Where('c.statusReservation = :statusReservation')
                         ->setParameter('statusReservation',false);
                }
            ))
            ->add('cautionStatus', CheckboxType::class, ['label' => 'Caution'])
            ->add('save', SubmitType::class, ['label' => 'Valider']);

    }

}