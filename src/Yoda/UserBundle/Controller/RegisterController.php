<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 6/30/14
 * Time: 9:13 AM
 */

namespace Yoda\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Yoda\UserBundle\Entity\User;
use Yoda\UserBundle\Form\RegisterFormType;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @Template
     */
    public function registerAction(Request $request)
    {

        $defaultUser = new User();


        $form = $this->createForm(new RegisterFormType(), $defaultUser);
        if ($request->isMethod('POST'))
        {
            $form->bind($request);

            if($form->isValid())
            {
                $user = $form->getData();

                $user->setPassword($this->encodePassword($user, $user->getPlainPassword()));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);

                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('Success!', "Welcome to my Website!!!")
                ;

                $this->authenticateUser($user);

                $url = $this->generateUrl('event');

                return $this->redirect($url);
            }
        }
        return array('form' => $form->createView());
    }

    private function encodePassword($user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

    private function authenticateUser(UserInterface $user)
    {
        $providerKey = 'secured_area'; // your firewall name
        $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());

        $this->container->get('security.context')->setToken($token);
    }

} 