<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/api/login", name="login")
     * @param Request $request
     * @return Response
     */
    public function loginAction(Request $request)
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $_username = $request->get('username');
        $_password = $request->get('password');
        $factory = $this->get('security.encoder_factory');

        $user_manager = $this->get('fos_user.user_manager');
        $user = $user_manager->findUserByUsername($_username);
        // Or by yourself
        $user = $this->getDoctrine()->getManager()->getRepository("AppBundle:User")
            ->findOneBy(array('username' => $_username));

        if(!$user){
            return new Response(
                'Username doesnt exists',
                Response::HTTP_UNAUTHORIZED,
                array('Content-type' => 'application/json')
            );
        }


        $encoder = $factory->getEncoder($user);
        $salt = $user->getSalt();

        if(!$encoder->isPasswordValid($user->getPassword(), $_password, $salt)) {
            return new Response(
                'Username or Password not valid.',
                Response::HTTP_UNAUTHORIZED,
                array('Content-type' => 'application/json')
            );
        }

        $serializer = new Serializer($normalizers, [new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user->getToken());
        return new JsonResponse($formatted);

    }



}
