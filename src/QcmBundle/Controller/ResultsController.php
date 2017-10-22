<?php

namespace QcmBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ResultsController extends Controller
{

    /**
     * @Route("/",name="qcmResults_index")
     */
    public function indexAction()
    {
        $qcmRepository = $this->getDoctrine()->getManager()->getRepository('QcmBundle:Qcm');
        /*$allQcm = $qcmRepository->findAll();*/
        $allQcm = $qcmRepository->findBy(array(), array('titre' => 'ASC'));

        return $this->render('QcmBundle:Results:index.html.twig', array('allQcm' => $allQcm));
    }



    /**
     * @Route("/viewResult/{qcmId}", name="viewResult")
     */
    public function viewResultAction($qcmId)
    {
        $manager = $this->getDoctrine()->getManager();
        $qcm = $advert = $manager->getRepository('QcmBundle:Qcm')->find($qcmId);

        if (null === $qcm) {
            throw new NotFoundHttpException("Ce QCM n'existe pas.");
        }

        $results = $this->getDoctrine()->getManager()->getRepository('QcmBundle:Resultat')->findBy(array('qcm' => $qcm), array('nbReponsesOK' => 'DESC'));

        $stats = $this->getStats($results);


        return $this->render('QcmBundle:Results:viewResult.html.twig', array('qcm' => $qcm,'allResults' => $results, 'stats' => $stats));
    }


    public function getStats($results){

        if (null != $results) {
            $meilleurResultat = 0;
            $userMeilleurResultat="";
            $moyenneResultats = 0;
            $nombreUsers = 0;
            $sommeResultat = 0;
            $nbQuestions = $results[0]->getNbQuestions();

            foreach ($results as $resultat){

                if($resultat->getNbReponsesOK() > $meilleurResultat){
                    $meilleurResultat = $resultat->getNbReponsesOK();
                    $userMeilleurResultat= $resultat->getUser();
                }

                $sommeResultat += $resultat->getNbReponsesOK();
                $nombreUsers++;
            }

            /*moyenne des résultats et meilleur resultat (en %)*/
            $moyenneResultats = (($sommeResultat / $nombreUsers)*100) / $nbQuestions;
            $meilleurResultat = ($meilleurResultat*100)/$nbQuestions;

            $stats = array(
                'meilleurResultat' => $meilleurResultat,
                'userMeilleurResultat' => $userMeilleurResultat,
                'moyenneResultats' => $moyenneResultats,
                'nombreUsers' => $nombreUsers,
                'nbQuestions' => $nbQuestions
            );
        }
        else{
            $stats = false;
        }

        return $stats;
    }

}
