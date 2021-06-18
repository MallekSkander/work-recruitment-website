<?php

namespace OffreBundle\Controller;


use AppBundle\Entity\User;
use Monolog\Logger;
use OffreBundle\Entity\Offre;
use OffreBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Offre/Default/index.html.twig');
    }
    public function addOffreAction(Request $request)
    {
        $user =$this->getUser();
        $parametre = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $offre = new Offre();
        $offre->setUser($user);
        $offre->setTitre($parametre['titre']);
        $offre->setDescription($parametre['description']);
        $offre->setSalaire($parametre['salaire']);
        $offre->setStatus($parametre['status']);
        $offre->setDateModification(new \DateTime('now'));
        $offre->setDatePublication(new \DateTime('now'));
        $offre->setNbAnneeExperience((int)$parametre['nbAnneeExperience']);
        $offre->setContratType($parametre['contratType']);
        $offre->setAdresse($parametre['adresse']);
        $em->persist($offre);
        foreach ($parametre['tags'] as $tag){
           $t = new Tag();
           $t->setValue($tag['value']);
           $t->setOffre($offre);
           $em->persist($t);
        }
        $em->flush();
        $response = new Response(
            'OK',
            Response::HTTP_OK,
            ['content-type' => 'json']
        );
        return new JsonResponse($response);
    }
    public function removeOffreAction($id)
    {

        $offre = $this->getDoctrine()->getManager()->getRepository(Offre::class)->find($id);
        if($offre == null ){
            return  new Response(Response::HTTP_NOT_FOUND);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($offre);
        $em->flush();
        $response = new Response(
            'OK',
            Response::HTTP_OK,
            ['content-type' => 'json']
        );
        return new JsonResponse($response);
    }
    public function updateOffreAction(Request $request)
    {   $em = $this->getDoctrine()->getManager();
        $parametre = json_decode($request->getContent(), true);
        $offre = $this->getDoctrine()->getManager()->getRepository(Offre::class)->find($parametre['id']);
        if($offre == null ){
            return  new Response(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        foreach ($offre->getTags() as $t){
            $em->remove($t);
        }
        $offre->setTitre($parametre['titre']);
        $offre->setDescription($parametre['description']);
        $offre->setSalaire($parametre['salaire']);
        $offre->setStatus($parametre['status']);
        $offre->setDateModification(new \DateTime('now'));
        $offre->setNbAnneeExperience((int)$parametre['nbAnneeExperience']);
        $offre->setContratType($parametre['contratType']);
        $offre->setAdresse($parametre['adresse']);
        $em->persist($offre);

        foreach ($parametre['tags'] as $tag){
            $t = new Tag();
            $t->setValue($tag['value']);
            $t->setOffre($offre);
            $em->persist($t);
        }
        $em->flush();
        $response = new Response(
            'OK',
            Response::HTTP_OK,
            ['content-type' => 'json']
        );
        return new JsonResponse($response);
    }

    function getAllOffreAction(Request $request){

            $em = $this->getDoctrine()->getManager();
            $normalizer = new ObjectNormalizer();
            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getId();
            });
            $normalizers = array($normalizer);
            $reclamations = $em->getRepository(Offre::class)->findBy([],['datePublication' => 'DESC']);
            $serializer = new Serializer($normalizers, [new ObjectNormalizer()]);
            $formatted = $serializer->normalize($reclamations);
            return new JsonResponse($formatted);
    }
    function getOffreByIdAction($id){
        $em = $this->getDoctrine()->getManager();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $reclamations = $em->getRepository(Offre::class)->find($id);
        $serializer = new Serializer($normalizers, [new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamations);
        return new JsonResponse($formatted);
    }


}
