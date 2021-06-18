<?php

namespace RendezVousBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use OffreBundle\Entity\Offre;
use RendezVousBundle\Entity\Appointment;
use RendezVousBundle\Entity\Category;
use RendezVousBundle\Entity\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RendezVousController extends Controller
{
    public function addrdvAction(Request $request)
    {
        $parametre = json_decode($request->getContent(), true);
        $condidat = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:User')
            ->find($parametre['person_id']);
        $RH = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:User')
            ->find($parametre['admin_id']);
        $category = $this->getDoctrine()->getManager()
            ->getRepository('RendezVousBundle:Category')
            ->find($parametre['category_id']);

        $startdate = \DateTime::createFromFormat('Y-m-d H:i', $parametre['hours']) ;

        $enddate = \DateTime::createFromFormat('Y-m-d H:i', $parametre['endDate']);
        $em = $this->getDoctrine()->getManager();
        $feedback = new Appointment();
        $feedback->setTitre($parametre['titre']);
        $feedback->setHours($startdate);
        $feedback->setEndDate($enddate);
        $feedback->setStatus(1);
        $feedback->setPerson($condidat);
        $feedback->setAdmin($RH);
        $feedback->setCategory($category);

        $em->persist($feedback);

        $em->flush();


          $message = (new \Swift_Message('Hello Email'))
                ->setFrom('JobsEspritProject@gmail.com')
                ->setTo('JobsEspritProject@gmail.com')
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        '@RendezVous/Default/registration.html.twig',

                        ['name' =>$condidat,'date'=>$startdate ]

                    ),
                    'text/html'
                )

                // you can remove the following code if you don't define a text version for your emails

            ;

            $this->get('mailer')->send($message);


            $response = new Response(
                'offre.id',
                Response::HTTP_OK,
                ['content-type' => 'json']
            );

            return new JsonResponse($response);
        }



        public function remrdvAction(Request $request)
    {
        $parametre = json_decode($request->getContent(), true);
        $reclamation = $this->getDoctrine()->getManager()
            ->getRepository(Appointment::class)
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

    public function updaterdvAction(Request $request)
    {

        $parametre = json_decode($request->getContent(), true);
        $condidat = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:User')
            ->find($parametre['person_id']);
        $RH = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:User')
            ->find($parametre['admin_id']);
        $category = $this->getDoctrine()->getManager()
            ->getRepository('RendezVousBundle:Category')
            ->find($parametre['category_id']);

        $startdate = \DateTime::createFromFormat('Y-m-d H:i', $parametre['hours']);
        $enddate = \DateTime::createFromFormat('Y-m-d H:i', $parametre['endDate']);


        $reclamation = $this->getDoctrine()->getManager()
            ->getRepository('RendezVousBundle:Appointment')
            ->find($parametre['id']);

        $em = $this->getDoctrine()->getManager();
        $reclamation->setTitre($parametre['titre']);
        $reclamation->setHours($startdate);
        $reclamation->setEndDate($enddate);
        $reclamation->setStatus(1);
        $reclamation->setPerson($condidat);
        $reclamation->setAdmin($RH);
        $reclamation->setCategory($category);
        $em->persist($reclamation);
        $em->flush();

        $response = new Response(
            'OK',
            Response::HTTP_OK,
            ['content-type' => 'json']
        );

        return new JsonResponse($response);
    }


    public function addcategoryAction(Request $request)
    {
        $parametre = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $feedback = new Category();


        $feedback->setName($parametre['name']);

        $em->persist($feedback);
        $em->flush();

        $response = new Response(
            'OK',
            Response::HTTP_OK,
            ['content-type' => 'json']
        );

        return new JsonResponse($response);
    }


    public function remcategoryAction(Request $request)
    {
        $parametre = json_decode($request->getContent(), true);
        $reclamation = $this->getDoctrine()->getManager()
            ->getRepository(Category::class)
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


    public function updatecategoryAction(Request $request)
    {

        $parametre = json_decode($request->getContent(), true);
        $reclamation = $this->getDoctrine()->getManager()
            ->getRepository('RendezVousBundle:Category')
            ->find($parametre['id']);

        $em = $this->getDoctrine()->getManager();
        $reclamation->setName($parametre['name']);
        $em->persist($reclamation);
        $em->flush();

        $response = new Response(
            'OK',
            Response::HTTP_OK,
            ['content-type' => 'json']
        );

        return new JsonResponse($response);
    }


    function getallRdvAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array(new DateTimeNormalizer(), $normalizer);

        $reclamations = $em->getRepository(Appointment::class)->findAll();
        $serializer = new Serializer($normalizers, [new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamations);

        return new JsonResponse($formatted);
    }

    function getRdvByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $reclamations = $em->getRepository(Appointment::class)->find($id);
        $serializer = new Serializer($normalizers, [new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamations);
        return new JsonResponse($formatted);
    }

    function getallCategoryAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $reclamations = $em->getRepository(Category::class)->findAll();
        $serializer = new Serializer($normalizers, [new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamations);
        return new JsonResponse($formatted);
    }

    function getCategoryByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $reclamations = $em->getRepository(Category::class)->find($id);
        $serializer = new Serializer($normalizers, [new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamations);
        return new JsonResponse($formatted);
    }


    public function addSessionAction(Request $request)
    {
        $parametre = json_decode($request->getContent(), true);
        $user = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:User')
            ->find($parametre['user_id']);

        $offre = $this->getDoctrine()->getManager()
            ->getRepository('OffreBundle:Offre')
            ->find($parametre['offre_id']);

        $em = $this->getDoctrine()->getManager();
        $feedback = new Session();
        $feedback->setOffre($offre);
        $feedback->setUser($user);
        $feedback->setDate(new \DateTime());
        $feedback->setScore($parametre['score']);

        $em->persist($feedback);
        $em->flush();

        $response = new Response(
            'OK',
            Response::HTTP_OK,
            ['content-type' => 'json']
        );

        return new JsonResponse($response);
    }


    function getallSessionAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $reclamations = $em->getRepository(Session::class)->findAll();
        $serializer = $this->container->get("jms_serializer");
        $formatted = $serializer->serialize($reclamations, "json");
        return new Response($formatted);
    }

}







