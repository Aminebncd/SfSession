<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }


    // afficher les stagiaires non inscrits dans une session
    public function findNonInscrits($session_id)
    {
        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();
        
        $qb = $sub;
        
        // selectionner tous les stagiaires d'une session dont l'id est passé en parametre
        $qb->select('s')
           ->from('App\Entity\User', 's')
           ->leftJoin('s.sessions', 'se')
           ->where('se.id = :id');

        $sub = $em->createQueryBuilder();
        // selectionner tous les stagiaires qui ne sont PAS (NOT IN) dans le resultat précédent
        // on obtient donc les stagiaires non inscrits pour une session définie
        $sub->select('st')
            ->from('App\Entity\User', 'st')
            ->where($sub->expr()->notIn('st.id', $qb->getDQL()))
            // requete paramétrée
            ->setParameter('id', $session_id)
            // trier la liste des stagiaires sur le nom de famille
            ->orderBy('st.nom');

        // renvoyer le resultat
        $query = $sub->getQuery();
        return $query->getResult();
    }


    // afficher les stagiaires non inscrits dans une session
    public function findNonProgrammes($session_id)
    {
        $SessionRepository = $this->getEntityManager();
        $sub = $em->createQueryBuilder();
        
        $qb = $sub;
        
        // selectionner tous les stagiaires d'une session dont l'id est passé en parametre
        $qb->select('s')
           ->from('App\Entity\Module', 's')
           ->leftJoin('s.programmes', 'se')
           ->leftJoin('se.session', 'sb')
           ->where('sb.id = :id');

        $sub = $em->createQueryBuilder();
        // selectionner tous les stagiaires qui ne sont PAS (NOT IN) dans le resultat précédent
        // on obtient donc les stagiaires non inscrits pour une session définie
        $sub->select('st')
            ->from('App\Entity\Module', 'st')
            ->where($sub->expr()->notIn('st.id', $qb->getDQL()))
            // requete paramétrée
            ->setParameter('id', $session_id)
            // trier la liste des stagiaires sur le nom de famille
            ->orderBy('st.intitule_module');

        // renvoyer le resultat
        $query = $sub->getQuery();
        return $query->getResult();
    }
    
//    /**
//     * @return Session[] Returns an array of Session objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Session
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
