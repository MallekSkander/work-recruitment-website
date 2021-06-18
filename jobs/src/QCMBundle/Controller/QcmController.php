<?php

namespace QCMBundle\Controller;

use Monolog\Logger;
use OffreBundle\Entity\Offre;
use QCMBundle\Entity\QCM;
use QCMBundle\Entity\Question;
use QCMBundle\Entity\Reponse;
use RendezVousBundle\Entity\Appointment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\VarDumper\VarDumper;

class QcmController extends Controller
{
    public function addQCMAction(Request $request)
    {   $parametre = json_decode($request->getContent(), true);
        $offre = $this->getDoctrine()->getManager()
            ->getRepository('OffreBundle:Offre')
            ->find($parametre['offre_id']);


        $em = $this->getDoctrine()->getManager();
        $feedback = new QCM();
        $feedback->setOffre($offre);
        $feedback->setTitre($parametre['titre']);

        $em->persist($feedback);
        $em->flush();

        $response = new Response(
            'OK',
            Response::HTTP_OK,
            ['content-type' => 'json']
        );

        return new JsonResponse($response);
    }

    public function remQCMAction(Request $request)
    {   $parametre = json_decode($request->getContent(), true);
        $reclamation = $this->getDoctrine()->getManager()
            ->getRepository(QCM::class)
            ->find($parametre['id']);


        $em = $this->getDoctrine()->getManager();

        $em->remove($reclamation);
        $em->flush();

        $response = new Response(
            'OK',
            Response::HTTP_OK,
            ['content-type' => 'json']
        );

        return new JsonResponse($response);
    }

    public function updateQCMAction(Request $request)
    {

        $parametre = json_decode($request->getContent(), true);

        $user = $this->getDoctrine()->getManager()
            ->getRepository('OffreBundle:Offre')
            ->find($parametre['offre_id']);
        $reclamation = $this->getDoctrine()->getManager()
            ->getRepository('OffreBundle:QCM')
            ->find($parametre['id']);
        $em = $this->getDoctrine()->getManager();
        $reclamation->setOffre($user);
        $reclamation->setTitre($parametre['titre']);
        $em->persist($reclamation);
        $em->flush();

        $response = new Response(
            'OK',
            Response::HTTP_OK,
            ['content-type' => 'json']
        );

        return new JsonResponse($response);
    }


    public function getallQCMhaithemAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reclamations = $em->getRepository('QCMBundle:QCM')->findAll();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array(new DateTimeNormalizer(),$normalizer);

        $serializer = new Serializer($normalizers, [new JsonEncoder()]);
        $formatted = $serializer->normalize($reclamations);

        return new JsonResponse($formatted);
    }

    function getallQCMAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $reclamations = $em->getRepository(QCM::class)->findAll();
        $serializer = new Serializer($normalizers, [new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamations);
        return new JsonResponse($formatted);
    }
    function getQCMByIdAction($id){
        $em = $this->getDoctrine()->getManager();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $reclamations = $em->getRepository(QCM::class)->find($id);
        $serializer = new Serializer($normalizers, [new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamations);
        return new JsonResponse($formatted);
    }

    function getallquestionAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $reclamations = $em->getRepository(Question::class)->findAll();
        $serializer = $this->container->get("jms_serializer");
        $formatted = $serializer->serialize($reclamations,"json");
        return new Response($formatted);
    }

    function getallquestionByOffreAction($id){

        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository(Offre::class)->find($id);
        $qcms = $em->getRepository(QCM::class)->findBy(array("offre"=>$offre));
        $question = array();
        foreach ($qcms as $qcm){
            $question = array_merge($question,$qcm->getQuestions()->toArray());
        }
        $serializer = $this->container->get("jms_serializer");
        $formatted = $serializer->serialize($question,"json");
        return new Response($formatted);
    }




    public function addquestionAndAnswerAction(Request $request)
    {   $parametre = json_decode($request->getContent(), true);

        $offre = $this->getDoctrine()->getManager()
            ->getRepository('OffreBundle:Offre')
            ->find($parametre['offre_id']);

        $qcm = $this->getDoctrine()->getManager()
            ->getRepository('QCMBundle:QCM')
            ->findOneBy(["offre"=>$offre]);
        $em = $this->getDoctrine()->getManager();
        $feedback = new Question();
        $feedback->setQcm($qcm);
        $feedback->setTitre($parametre['questions']["titre"]);

        $em->persist($feedback);
        $em->flush();

        foreach ($parametre['questions']['responses'] as $i)
        {
            $rep = new Reponse();
            $rep->setQuestion($feedback);
            $rep->setReponse($i["titre"]);
            $rep->setCorrecte($i["correct"]);

            $em->persist($rep);
            $em->flush();

        }

        $response = new Response(
            'OK',
            Response::HTTP_OK,
            ['content-type' => 'json']
        );

        return new JsonResponse($response);
    }


    public function updatequestionAndAnswerAction(Request $request)
    {   $parametre = json_decode($request->getContent(), true);
        $logger = new Logger('dsf');
        $QCM = $this->getDoctrine()->getManager()
            ->getRepository(QCM::class)
            ->findOneBy(['offre'=>$parametre['offre_id']]);

        $em = $this->getDoctrine()->getManager();

        foreach ($QCM->getQuestions() as $q){

        }
        $q->setTitre($parametre['questions']['titre']);
        $em->persist($q);
        $em->flush();


        foreach ($q->getReponses() as $r){
            $em->remove($r);
        }

        foreach ( $parametre['questions']['reponses'] as $r){
            $rep = new Reponse();
            $rep->setCorrecte($r['correcte']);
            $rep->setQuestion($q);
            $rep->setReponse($r['reponse']);
            $em->persist($rep);
            $em->flush();
        }


        $response = new Response(
            'OK',
            Response::HTTP_OK,
            ['content-type' => 'json']
        );

        return new JsonResponse($response);
    }

    public function remQuestionAction(Request $request)
    {   $parametre = json_decode($request->getContent(), true);
        $reclamation = $this->getDoctrine()->getManager()
            ->getRepository(Question::class)
            ->find($parametre['id']);


        $em = $this->getDoctrine()->getManager();

        $em->remove($reclamation);
        $em->flush();

        $response = new Response(
            'OK',
            Response::HTTP_OK,
            ['content-type' => 'json']
        );

        return new JsonResponse($response);
    }

}
