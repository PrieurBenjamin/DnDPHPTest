<?php

namespace App\Controller;

use App\Entity\Cliweb;
use App\Form\CliwebType;
use App\Repository\CliwebRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cliweb")
 */
class CliwebController extends AbstractController
{
    /**
     * @Route("/", name="cliweb_index", methods={"GET"})
     */
    public function index(CliwebRepository $cliwebRepository): Response
    {
        return $this->render('cliweb/index.html.twig', [
            'cliwebs' => $cliwebRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cliweb_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cliweb = new Cliweb();
        $form = $this->createForm(CliwebType::class, $cliweb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cliweb);
            $entityManager->flush();

            return $this->redirectToRoute('cliweb_index');
        }

        return $this->render('cliweb/new.html.twig', [
            'cliweb' => $cliweb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/json", name="cliweb_show", methods={"GET"})
     */
    public function show()
    {
        $dbhost ="localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname ="testdnd";

        //connect to database
        $conn = @mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Couldn't connet to database.");

        //get the data from table ‘books’
        $query = "select * from cliweb";

        //execute the query
        $result = mysqli_query($conn, $query);

        if(!$result)
        {
            return $this->redirectToRoute('cliweb_index');
        }
        else
        {
            //creates an empty array to hold data
            $data = array();
            $counter = 0;
            echo '{<br>"cliweb": [<br>';
            while($row = mysqli_fetch_assoc($result))
            {
                if($counter >= 1)
                {
                    echo ',<br>';
                }
                else
                {
                    echo '<br>';
                }
                $data[]=$row;
                echo '{<br>';
                echo '"id : " "'.$data[$counter]["id"].'",<br>';
                echo '"sku : " "'.$data[$counter]["sku"].'",<br>';
                echo '"status : " "'.$data[$counter]["status"].'",<br>';
                echo '"price : " "'.$data[$counter]["price"].'",<br>';
                echo '"description : " "'.$data[$counter]["description"].'",<br>';
                echo '"created_at : " "'.$data[$counter]["created_at"].'",<br>';
                echo '"slug : " "'.$data[$counter]["slug"];
                echo '"<br>';
                echo '}';
                $counter ++;
            }
            echo '<br>]<br>}';
        }
    }

    /**
     * @Route("/{id}/edit", name="cliweb_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cliweb $cliweb): Response
    {
        $form = $this->createForm(CliwebType::class, $cliweb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cliweb_index');
        }

        return $this->render('cliweb/edit.html.twig', [
            'cliweb' => $cliweb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cliweb_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cliweb $cliweb): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cliweb->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cliweb);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cliweb_index');
    }

    /**
     * @Route("/getjson", name="cliweb_getjson", methods={"GET","POST"})
     */
    public function getJson()
    {

    }
}
