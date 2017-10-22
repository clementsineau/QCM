<?php

namespace QcmBundle\Controller;


use QcmBundle\Entity\Resultat;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnswerController extends Controller
{

    /**
     * @Route("/",name="qcmAnswer_index")
     */
    public function indexAction()
    {
        $qcmRepository = $this->getDoctrine()->getManager()->getRepository('QcmBundle:Qcm');
        $listqcm = $qcmRepository->findBy(array(), array('titre' => 'ASC'));
        return $this->render('QcmBundle:Answer:index.html.twig',array('listqcm'=>$listqcm));
    }

    /**
     * @Route("/renseigner/{id}",name="qcmAnswerrenseigner_index")
     */
    public function renseignerAction(Request $request,$id)
    {
        $qcmRepository = $this->getDoctrine()->getManager()->getRepository('QcmBundle:Question')->findBy(['qcm'=>$id]);
        $titre = $this->getDoctrine()->getManager()->getRepository('QcmBundle:Qcm')->find($id);
        $qcm = $qcmRepository;

        foreach ($qcm as $question){
            $props = $question->getPropositions();
            shuffle($props);
            $question->setPropositions($props);
        }

        if ($request->isMethod('POST')){
            $nbReponsesOK = 0;
            $proposition = $request->get('proposition');
            foreach ($qcm as $value){
                if ($value->getReponse() == $proposition[$value->getId()]){
                    $nbReponsesOK = $nbReponsesOK+1;
                }
            }
            $resultat =  new Resultat();
            $resultat->setUser($request->request->get('user'));
            $resultat->setNbQuestions(count($qcm));
            $resultat->setNbReponsesOK($nbReponsesOK);
            $resultat->setQcm($titre);
            $em = $this->getDoctrine()->getManager();
            $em->persist($resultat);
            $em->flush();
            $this->addFlash('success', 'Merci d\'avoir renseigné ce qcm !');
            return $this->redirectToRoute('qcmResults_index');

        }
        return $this->render('QcmBundle:Answer:renseigner.html.twig',array('qcm'=>$qcm,'titre'=>$titre));
    }
}
