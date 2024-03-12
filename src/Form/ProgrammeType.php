<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Programme;
use Doctrine\ORM\QueryBuilder;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProgrammeType extends AbstractType
{

    public function __construct(private ManagerRegistry $doctrine) {}

    public function buildForm(FormBuilderInterface $builder, array $options = null): void
    {
        $session = $options['session'];
        // dd($session);
        $builder
            ->add('duree', NumberType::class)

            ->add('module', EntityType::class, [
                  'class' => Module::class,
                  'query_builder' => function() use ($session): QueryBuilder
                  { 
                      $em = $this->doctrine->getManager();                   
                      
                        $sub = $em->createQueryBuilder();                      
                        $qb = $sub;
                        
                        $qb ->select('s')
                            ->from('App\Entity\Module', 's')
                            ->leftJoin('s.programmes', 'se')
                            ->leftJoin('se.session', 'sb')
                            ->where('sb.id = :id');

                        $sub = $em->createQueryBuilder();
                
                        $sub->select('st')
                            ->from('App\Entity\Module', 'st')
                            ->where($sub->expr()->notIn('st.id', $qb->getDQL()))
                            ->setParameter('id',$session)
                            ->orderBy('st.intitule_module');

                        return $sub;
                  },
                   'choice_value' => 'id',
                   'choice_label' => 'intitule_module',
                    ])
                ->add('valider', SubmitType::class, [
                    'attr' => [
                        // 'class' => 'btn btn-primary mt-3'
                        ]
                    ])
                      
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired([
            'session',
        ]);
    }
}
