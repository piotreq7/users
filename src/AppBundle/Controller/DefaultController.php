<?php

//// Include the main Propel script
//require_once '/vendor/src/propel/runtime/lib/Propel.php';
//
//// Initialize Propel with the runtime configuration
//Propel::init("/path/to/bookstore/build/conf/bookstore-conf.php");
//
//// Add the generated 'classes' directory to the include path
//set_include_path("/path/to/bookstore/build/classes" . PATH_SEPARATOR . get_include_path());





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
//    /**
//     * @Route("/", name="homepage")
//     */
//    public function indexAction()
//    {
//
//        return $this->render('default/index.html.twig', [
//            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
//        ]);
//    }

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
//        echo $findUser;
//        echo "</pre>";
        $users= \UsersQuery::create()->find();




        $cars=[

            ['make'=>'BMW', 'name'=>'X1'],
            ['make'=>'wv', 'name'=>'passa']


        ];

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
                'cars'=>$cars,
                'users'=>$users,

                'form'=>$form->createView()

            ]);

    }

    /**
     * @Route("/add_user", name="add_user")
     */
    public function addAction()
    {

        return $this->render('default/add_user.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
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
