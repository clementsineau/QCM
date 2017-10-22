<?php

namespace QcmBundle\Controller;


use QcmBundle\Entity\Qcm;
use QcmBundle\Entity\Question;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateController extends Controller
{

    /**
     * @Route("/",name="qcmCreate_index")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        if($request->isMethod('GET'))
        {
            return $this->render('QcmBundle:Create:index.html.twig');
        }
        else if($request->isMethod('POST'))
        {
            $titre = $request->request->get('titre');
            $nbQuestions = $request->request->get('nbQuestions');
            $questions = array();

            for($i=1; $i<=$nbQuestions; $i++)
            {
                $question = $request->request->get('question_'.$i);
                $reponse = $request->request->get('reponse_'.$i);
                $prop1 = $request->request->get('prop1_'.$i);
                $prop2 = $request->request->get('prop2_'.$i);
                $prop3 = $request->request->get('prop3_'.$i);

                $questions[] = array(
                    'question' => $question,
                    'reponse' => $reponse,
                    'propositions' => array($prop1,$prop2,$prop3,$reponse)
                );
            }

            $em = $this->getDoctrine()->getManager();

            $qcm = new Qcm();
            $qcm->setTitre($titre);

            for($i=1; $i<=$nbQuestions; $i++)
            {
                $question = new Question();
                $question->setQuestion($questions[$i-1]['question']);
                $question->setReponse($questions[$i-1]['reponse']);
                $question->setPropositions($questions[$i-1]['propositions']);
                $question->setQcm($qcm);
                $qcm->getQuestions()->add($question);
            }

            try{
                $em->persist($qcm);
                $em->flush();
                $success = true;
            }
            catch(Exception $e){
                $success = false;
                $message = $e->getMessage();
            }

            if($success)
            {
                return $this->render('QcmBundle:Create:createResults.html.twig', array(
                    'success' => true
                ));
            }
            else
            {
                return $this->render('QcmBundle:Create:createResults.html.twig', array(
                    'message' => $message,
                    'success' => false
                ));
            }
        }
    }

}
