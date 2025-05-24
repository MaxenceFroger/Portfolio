<?php

namespace App\Controller;

use App\Entity\P08Inventaire;
use App\Entity\P08FigurineCaracteristique;
use App\Entity\P08Collection;
use App\Form\InventaireType;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class P08InventaireController extends AbstractController
{
    //#[Route('/p08/inventaire/index', name: 'index_p08_inventaire')]
    public function index(): Response
    {
        return $this->render('p08_inventaire/index.html.twig', [
            'controller_name' => 'P08inventaireController',
        ]);
    }


    #[Route('/inventaire/insert', name: 'create_inventaire')]
    public function createinventaire(EntityManagerInterface $entityManager): Response
    {
        $inventaire = new P08inventaire();
        $figurine = $entityManager->getRepository(P08FigurineCaracteristique::class)->find(889698683807);
        $inventaire->setFigurineReference($figurine);
        $inventaire->setFigurinePrix(100);
        $inventaire->setFigurineEstPossedee(true);
        $inventaire->setFigurineEchangeable(false);
        $inventaire->setFigurineDateAcquisition(\DateTime::createFromFormat('Y-m-d','2025-03-20'));
        $entityManager->persist($inventaire);
        $entityManager->flush();
        $inventaire = $entityManager->getRepository(P08Inventaire::class)->find($inventaire->getFigurineId());
        return $this->render('p08_inventaire/findId.html.twig', array('inventaire' => $inventaire));
    }

    #[Route('/inventaire', name: 'list_inventaire')]
    public function listInventaire(EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $queryBuilder = $entityManager->getRepository(P08Inventaire::class)->createQueryBuilder('i');
        $queryBuilder->leftJoin('i.figurine_reference', 'f');
        $search = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
        }
        if ($search) {
            $queryBuilder->andWhere('LOWER(f.figurine_nom) LIKE LOWER(:search)')
                ->setParameter('search', '%' . $search . '%');
        }

        $queryBuilder->orderBy('f.figurine_nom', 'ASC');
        $query = $queryBuilder->getQuery();
        $inventaire = $query->getResult();
        return $this->render('p08_inventaire/list.html.twig', ['inventaires' => $inventaire,
            'form' => $form->createView()]);
    }

    #[Route('/inventaire/{id<\d+>}', name: 'inventaire_by_id')]
    public function findInventaireByID($id, EntityManagerInterface $entityManager, RequestStack $request): Response
    {
        $session = $request->getSession();

        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return $this->render('p08_inventaire/error_id.html.twig');
        }


        if (!$session->has("id")) {
            $session->set("id", $id);
        }


        $inventaire = $entityManager->getRepository(P08Inventaire::class)->find($id);
        return $this->render('p08_inventaire/findId.html.twig', ['inventaire' => $inventaire]);
    }

    #[Route('/inventaire/update/{id}', name: 'updateInventaire_by_id')]
    public function updateById($id, EntityManagerInterface $entityManager, RequestStack $request): Response
    {
        $session = $request->getSession();

        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return $this->render('p08_inventaire/error_id.html.twig');
        }

        if (!$session->has("id")) {
            $session->set("id", $id);
        }


        $inventaire = $entityManager->getRepository(P08Inventaire::class)->find($id);
        if (!is_null($inventaire)) {
            $inventaire->setFigurinePrix(1000);
            $entityManager->flush();
        }
        return $this->render('p08_inventaire/updateId.html.twig', ['inventaire' => $inventaire]);
    }

    #[Route('/inventaire/delete/{id}', name: 'deleteInventaire_by_id')]
    public function deleteById($id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $inventaire = $entityManager->getRepository(P08Inventaire::class)->find($id);

        if (!$inventaire) {
            return $this->render('p08_inventaire/error_id.html.twig');
        }
        $entityManager->remove($inventaire);
        $entityManager->flush();

        return $this->render('p08_inventaire/deleteId.html.twig', ['inventaire' => $inventaire]);
    }

    #[Route('/inventaire/updateForm/{id}', name: 'update_inventaire2')]
    public function updateAction(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $inventaire = $entityManager->getRepository(P08Inventaire::class)->find($id);
        $inventaireForm = $this->createForm(InventaireType::class, $inventaire);

        // Gérer la soumission du formulaire
        $inventaireForm->handleRequest($request);

        if ($inventaireForm->isSubmitted() && $inventaireForm->isValid()) {
            // Si le formulaire est valide, on enregistre les données en base
            $entityManager->flush();
            return $this->redirectToRoute('inventaire_by_id', ['id' => $inventaire->getFigurineId()]);
        }

        // Passer les données à la vue
        $figurines = $entityManager->getRepository(P08FigurineCaracteristique::class)->findBy([], ['figurine_nom' => 'ASC']);

        return $this->render('p08_inventaire/form/update.form.inventaire.twig', [
            'form' => $inventaireForm->createView(),
            'inventaire' => $inventaire,
            'figurines' => $figurines,
        ]);
    }

    #[Route('/inventaire/createForm', name: 'create_inventaire2')]
    public function createAction(Request $request, EntityManagerInterface $entityManager): Response
    {
        $inventaire = new P08Inventaire();
        $inventaireForm = $this->createForm(InventaireType::class, $inventaire);

        // Gérer la soumission du formulaire
        $inventaireForm->handleRequest($request);

        if ($inventaireForm->isSubmitted() && $inventaireForm->isValid()) {
            $entityManager->persist($inventaire);
            $entityManager->flush();
            return $this->redirectToRoute('inventaire_by_id', ['id' => $inventaire->getFigurineId()]);
        }
        // Passer les données à la vue
        $figurines = $entityManager->getRepository(P08FigurineCaracteristique::class)->findBy([], ['figurine_nom' => 'ASC']);

        return $this->render('p08_inventaire/form/insert.form.inventaire.twig', [
            'form' => $inventaireForm->createView(),
            'inventaire' => $inventaire,
            'figurines' => $figurines,
        ]);
    }
}
