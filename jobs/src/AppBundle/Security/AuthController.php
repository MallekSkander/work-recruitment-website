<?php


namespace AppBundle\Security;


use AppBundle\Entity\User;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Monolog\Logger;
use OffreBundle\Entity\Offre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class AuthController extends Controller
{
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $logger = new Logger('logger');
        $logger->info($request->getContent());
        $parameters = json_decode($request->getContent(), true);


        $em = $this->getDoctrine()->getManager();
        if($parameters==null){
            return new Response(
                'Invalid Json',
                Response::HTTP_INTERNAL_SERVER_ERROR,
                array('Content-ty$parameters = json_decode($request->getContent(), true);pe' => 'application/json')
            );
        }
        if (!file_exists('uploads/')) {
            mkdir('uploads/', 0777, true);
        }
        $filename_path = md5(time().uniqid()).".png";
        $decoded=base64_decode($parameters['photo']);
        $fileName = "uploads/".$filename_path;
        file_put_contents($fileName,$decoded);

            $u = $em->getRepository(User::class)->findBy(['username'=>$parameters['username']]);
            $uEmail = $em->getRepository(User::class)->findBy(['email'=>$parameters['email']]);
            $uTel = $em->getRepository(User::class)->findBy(['tel'=>$parameters['tel']]);
            $uCin = $em->getRepository(User::class)->findBy(['cin'=>$parameters['cin']]);
            if($u != null || $uEmail != null || $uTel != null ||  $uCin != null){
                return new Response(
                    'User Already Exists',
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    array('Content-type' => 'application/json')
                );
            }else{
                $user = new User();
                $user->setNom($parameters['firstName']);
                $user->setSexe('Homme');
                $user->setPrenom($parameters['lastName']);
                $user->setAdresse('');
                $dateN = DateTime::createFromFormat('Y-m-d',$parameters['birthdate'] );

                $user->setDateDeNaissance($dateN);
                $user->setEmail($parameters['email']);
                $user->setTel((int)$parameters['tel']);
                $user->setPermisDeConduire(false);
                $user->setCv('cv');
                $user->setCin($parameters['cin']);
                $user->setPhoto($fileName);
                $user->setLikedIn('linkedIn');
                $user->setUsername($parameters['username']);
                $user->setPlainPassword($parameters['password']);
                $user->setEnabled(1);
                $em->persist($user);
                $em->flush();
                $jwtManager = $this->container->get('lexik_jwt_authentication.jwt_manager');

                return new JsonResponse(['token' => $jwtManager->create($user)]);
            }
    }
    public function api()
    {
        $logger  = new Logger('fgd');
        $logger->info('sdf');
        $em = $this->getDoctrine()->getManager();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $users = $em->getRepository(User::class)->findAll();

        $serializer = new Serializer($normalizers, [new ObjectNormalizer()]);
        $formatted = $serializer->normalize($users);
        return new JsonResponse($formatted);

    }
    public function test()
    {
      $user =  $this->getUser();
        return new Response("",Response::HTTP_OK);
    }
    function getCurrentUserAction(Request $request){
        $user =$this->getUser();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);

        $serializer = new Serializer($normalizers, [new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    function getUserAction($id){
        $em = $this->getDoctrine()->getManager();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $reclamations = $em->getRepository(User::class)->find($id);
        $serializer = new Serializer($normalizers, [new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamations);
        return new JsonResponse($formatted);
    }
    function getAllUserAction(){
        $logger  = new Logger('fgd');
        $logger->info('sdf');
        $em = $this->getDoctrine()->getManager();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $users = $em->getRepository(User::class)->findAll();

        $serializer = new Serializer($normalizers, [new ObjectNormalizer()]);
        $formatted = $serializer->normalize($users);
        return new JsonResponse($formatted);
    }

}