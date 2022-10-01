<?php

namespace ProjectBundle\Form;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use ProjectBundle\Entity\Car;
use ProjectBundle\Entity\Configuration;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ConfigurationType extends AbstractType
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
        $em = $this->entityManager;

        $ids =  $em->getRepository(Configuration::class)->createQueryBuilder('c')
            ->getQuery()->getResult();

        $id = [];
        foreach (array_values($ids) as $config){
            $id [] = $config->getId();
        }
        $arr = array_values($id);

        $builder  ->add('car',EntityType::class,array(
                        'class'=>Car::class,
                        'choice_label'=>'name',
                        'required'=>true,
                ))
                ->add('mileage', CheckboxType::class)
                ->add('maintenanceMileage', TextType::class)
                ->add('periodBool', CheckboxType::class)
                ->add('maintenancePeriod', TextType::class)
                ->add('save', SubmitType::class, ['label' => 'Valider']);
    }

}