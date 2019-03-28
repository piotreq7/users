<?php


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

\Propel::init('/home/psipinski/Pobrane/users/src/propel/build/conf/users-conf.php');


class DefaultController extends Controller
{

    /**
     * @Route("/users", name="show_users")
     */
    public function showAction(Request $request)
    {
//        $user=new \Users();
//        $user->setLastName('ted');
//        $user->setFirsName('ted');
//        $user->setLogin('tedi');
//        $user->setPassword('tedi');
//        $user->save();

//        $findUser = \UsersQuery::create()->findOneByFirsName('ted');
//        $findUser->setFirsName('Kamien');
//        $findUser->delete();

//
//        echo "<pre>";
//        echo $findUser = \UsersQuery::create()->find();
//        echo "</pre>";
        $users= \UsersQuery::create()->find();




        $form = $this->createFormBuilder()
            ->add('search',TextType::class,[
                'constraints'=>
                    [
                new NotBlank(),
                new Length(['min'=>2])
                    ]


            ])
            ->getform();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
//            die("form submited");

        }

        return $this->render('default/users.html.twig',
            [
                'users'=>$users,

                'form'=>$form->createView()

            ]);

    }

    /**
     * @Route("/add_user", name="add_user")
     */
    public function addAction(Request $request)
    {
        $error="";
        $form = $this->createFormBuilder()
            ->add('login',TextType::class,['constraints'=>[new NotBlank(),new Length(['min'=>2])]])
            ->add('imie',TextType::class,['constraints'=>[new NotBlank(),new Length(['min'=>2])]])
            ->add('nazwisko',TextType::class,['constraints'=>[new NotBlank(),new Length(['min'=>2])]])
            ->add('haslo',TextType::class,['constraints'=>[new NotBlank(),new Length(['min'=>2])]])
            ->add('repeat',TextType::class,['constraints'=>[new NotBlank(),new Length(['min'=>2])]])

            ->getform();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user=$form->getData();

            if(!$exist=\UsersQuery::create()->findOneByLogin($user['login']))
            {

            if($user['haslo']==$user['repeat'])
            {

                $temp=new \Users();
                $temp->setLogin($user['login']);
                $temp->setFirsName($user['imie']);
                $temp->setLastName($user['nazwisko']);
                $temp->setPassword($user['haslo']);

                if(!$temp->save())
                {
                    die("Problem z zapisem do bazy");
                }
                return $this->redirectToRoute('show_users');
            }else {
                $error="Różne hasła";
            }
            }else
                {
                    $error="login zajęty";
                }


        }


        return $this->render('default/add_user.html.twig', [
            'form'=>$form->createView(),
            'error'=>$error
        ]);
    }

    /**
     * @Route("/edit_user", name="edit_user")
     */
    public function editAction()
    {

        return $this->render('default/add_user.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

}
