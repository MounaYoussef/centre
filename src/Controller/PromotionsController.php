<?php

namespace App\Controller;

use App\Entity\promotioncherche;
use App\Entity\Promotions;
use App\Form\PromotionsType;
use App\Repository\PromotionsRepository;
use App\Repository\ProRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/promotions")
 */
class PromotionsController extends AbstractController
{
    /**
     * @Route("/", name="promotions_index", methods={"GET"})
     */
    public function index(PromotionsRepository $promotionsRepository): Response
    {

        return $this->render('promotions/index.html.twig', [
            'promotions' => $promotionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="promotions_new", methods={"GET","POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer, ProRepository $proRepository): Response
    {
        $promotion = new Promotions();
        $product = $proRepository->findAll();
        $form = $this->createForm(PromotionsType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $p= $request->request->get('promotions[pros]');
            $pr = $proRepository->findBy(['id'=>$p]);
            foreach($pr as $item){
                $prr = $proRepository->find($item->getId());
                $promotion->addPro($prr);
            }

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($promotion);
            $entityManager->flush();

            $name = $promotion->getNom();
            $prix = $promotion->getPrix();

            $message = (new \Swift_Message('Promotions'))
                ->setFrom('tt9930828@gmail.com')
                ->setTo('tt9930828@gmail.com')
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'emails/registration.html.twig',
                        ['name' => $name, 'prix' => $prix
                        ]
                    ),
                    'text/html'
                )


            ;

            $mailer->send($message);

            return $this->redirectToRoute('promotions_index');
        }



        return $this->render('promotions/new.html.twig', [
            'promotion' => $promotion,
            'products' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search", name="promotions_search", methods={"GET","POST"})
     */

    public function search(Request $request, PromotionsRepository $promotionsRepository){
        if($request->isMethod('POST')){
            $min  = $request->request->get('prixMin');
            $max  = $request->request->get('prixMax');
            $result = $promotionsRepository->findProductByPrice((float)$min, (float)$max);


        }

        return $this->render('promotions/search.html.twig',['results' => $result]);


    }

    /**
     * @Route("/{id}", name="promotions_show", methods={"GET"})
     */
    public function show(Promotions $promotion): Response
    {
        return $this->render('promotions/show.html.twig', [
            'promotion' => $promotion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="promotions_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Promotions $promotion): Response
    {
        $form = $this->createForm(PromotionsType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('promotions_index');
        }

        return $this->render('promotions/edit.html.twig', [
            'promotion' => $promotion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="promotions_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Promotions $promotion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promotion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($promotion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('promotions_index');
    }
}
