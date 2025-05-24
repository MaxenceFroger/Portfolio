<?php

namespace App\Controller;

use App\Entity\P08Collection;
use App\Entity\P08FigurineCaracteristique;
use App\Entity\P08Inventaire;
use App\Form\FigurineCaracteristiqueType;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class P08FigurineCaracteristiqueController extends AbstractController
{
    //#[Route('/p08/figurine/index', name: 'index_p08_figurine')]
    public function index(): Response
    {
        return $this->render('p08_figurine_caracteristique/index.html.twig', [
            'controller_name' => 'P08FigurineController',
        ]);
    }


    #[Route('/figurine/insert', name: 'create_figurine')]
    public function createFigurine(EntityManagerInterface $entityManager): Response
    {
        $figurine = new P08FigurineCaracteristique();
        $allRef = $entityManager->getRepository(P08FigurineCaracteristique::class)
            ->createQueryBuilder('f')
            ->select('f.figurine_reference')
            ->getQuery()
            ->getResult();
        $allRef = array_column($allRef, 'figurine_reference');
        $rand = rand(0, 1000000);
        while (array_search($rand, $allRef)){
            $rand = rand(0, 1000000);
        }
        $figurine->setFigurineReference($rand);
        $figurine->setFigurineNom("Maxime");
        $figurine->setFigurinePersonnage("Moi");
        $figurine->setFigurineTaille(167);
        $figurine->setFigurineDateSortie(\DateTime::createFromFormat('Y-m-d','2004-04-26'));
        $figurine->setFigurinePopid(1);
        $figurine->setFigurineChase(true);
        $collection = $entityManager->getRepository(P08Collection::class)->find(1);
        $figurine->setCollectionId($collection);
        $entityManager->persist($figurine);
        $entityManager->flush();
        $figurine = $entityManager->getRepository(P08FigurineCaracteristique::class)->find($figurine->getFigurineReference());
        return $this->render('p08_figurine_caracteristique/findRef.html.twig', array('figurine' => $figurine));
    }

    #[Route('/figurine', name: 'list_figurine')]
    public function listFigurine(EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $queryBuilder = $entityManager->getRepository(P08FigurineCaracteristique::class)->createQueryBuilder('f');
        $queryBuilder->leftJoin('f.collection_id', 'c');
        $search = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
        }
        if ($search) {
            $queryBuilder->andWhere('LOWER(f.figurine_nom) LIKE LOWER(:search)')
                ->orWhere('LOWER(f.figurine_personnage) LIKE LOWER(:search)')
                ->orWhere('LOWER(c.collection_nom) LIKE LOWER(:search)')
                ->setParameter('search', '%' . $search . '%');
        }

        $queryBuilder->orderBy('f.figurine_nom', 'ASC');
        $query = $queryBuilder->getQuery();
        $figurines = $query->getResult();
        return $this->render('p08_figurine_caracteristique/list.html.twig', ['figurines' => $figurines,
            'form' => $form->createView()]);
    }

    #[Route('/figurine/{ref<\d+>}', name: 'figurine_by_ref')]
    public function findFigurineByRef($ref, EntityManagerInterface $entityManager, RequestStack $request): Response
    {
        $session = $request->getSession();

        if (!filter_var($ref, FILTER_VALIDATE_INT)) {
            return $this->render('p08_figurine_caracteristique/errorRef.html.twig');
        }


        if (!$session->has("id")) {
            $session->set("id", $ref);
        }


        $figurine = $entityManager->getRepository(P08FigurineCaracteristique::class)->find($ref);
        return $this->render('p08_figurine_caracteristique/findRef.html.twig', ['figurine' => $figurine]);
    }

    #[Route('/figurine/update/{ref}', name: 'updateFigurine_by_ref')]
    public function updateById($ref, EntityManagerInterface $entityManager, RequestStack $request): Response
    {
        $session = $request->getSession();

        if (!filter_var($ref, FILTER_VALIDATE_INT)) {
            return $this->render('p08_figurine_caracteristique/errorRef.html.twig');
        }

        if (!$session->has("ref")) {
            $session->set("ref", $ref);
        }


        $figurine = $entityManager->getRepository(P08FigurineCaracteristique::class)->find($ref);
        if (!is_null($figurine)) {
            $figurine->setFigurineTaille(200);
            $entityManager->flush();
        }
        return $this->render('p08_figurine_caracteristique/updateRef.html.twig', ['figurine' => $figurine]);
    }

    #[Route('/figurine/delete/{ref}', name: 'deleteFigurine_by_id')]
    public function deleteById($ref, EntityManagerInterface $entityManager, RequestStack $request): Response
    {
        $figurine = $entityManager->getRepository(P08FigurineCaracteristique::class)->find($ref);

        if (!is_null($figurine)) {
            $figurinesInv = $entityManager->getRepository(P08Inventaire::class)->findBy(array('figurine_reference'=>$figurine->getFigurineReference()));
            foreach ($figurinesInv as $figurineInv){
                $entityManager->remove($figurineInv);
            }
            $entityManager->flush();
            $entityManager->remove($figurine);
            $entityManager->flush();
        }
        return $this->render('p08_figurine_caracteristique/deleteRef.html.twig', ['figurine' => $figurine]);
    }

    #[Route('/figurine/updateForm/{ref}', name: 'update2_by_ref')]
    public function updateAction(Request $request, EntityManagerInterface $entityManager, $ref): Response
    {
        $figurine = $entityManager->getRepository(P08FigurineCaracteristique::class)->find($ref);
        $figurineForm = $this->createForm(FigurineCaracteristiqueType::class, $figurine);

        // Gérer la soumission du formulaire
        $figurineForm->handleRequest($request);

        if ($figurineForm->isSubmitted() && $figurineForm->isValid()) {
            // Si le formulaire est valide, on enregistre les données en base
            $entityManager->flush();
            return $this->redirectToRoute('figurine_by_ref', ['ref' => $figurine->getFigurineReference()]);
        }

        /*// Si le formulaire est invalidé, remettre la valeur actuelle de la base de données dans le formulaire
        if ($figurineForm->isSubmitted() && !$figurineForm->isValid()) {
            // Récupérer la valeur actuelle de la base de données et la remettre dans le formulaire
            $figurineForm->get('figurine_reference')->setData($figurine->getFigurineReference());
        }*/

        // Passer les données à la vue
        $collections = $entityManager->getRepository(P08Collection::class)->findBy([], ['collection_nom' => 'ASC']);

        return $this->render('p08_figurine_caracteristique/form/update.form.figurine.twig', [
            'form' => $figurineForm->createView(),
            'figurine' => $figurine,
            'collections' => $collections,
        ]);
    }

    #[Route('/figurine/createForm', name: 'create_figurine2')]
    public function createAction(Request $request, EntityManagerInterface $entityManager): Response
    {
        $figurine = new P08FigurineCaracteristique();
        $figurineForm = $this->createForm(FigurineCaracteristiqueType::class, $figurine);

        // Gérer la soumission du formulaire
        $figurineForm->handleRequest($request);

        if ($figurineForm->isSubmitted() && $figurineForm->isValid()) {
            $entityManager->persist($figurine);
            $entityManager->flush();
            return $this->redirectToRoute('figurine_by_ref', ['ref' => $figurine->getFigurineReference()]);
        }
        // Passer les données à la vue
        $collections = $entityManager->getRepository(P08Collection::class)->findBy([], ['collection_nom' => 'ASC']);

        return $this->render('p08_figurine_caracteristique/form/insert.form.figurine.twig', [
            'form' => $figurineForm->createView(),
            'figurine' => $figurine,
            'collections' => $collections,
        ]);
    }


    /*
        #[Route('/collection/createForm', name: 'create_collection2')]
        public function creerAction(Request $request, EntityManagerInterface $entityManager): Response
        {
            $collection = new P08Collection();
            $collectionForm = $this->createForm(CollectionType::class, $collection);
            $collectionForm->handleRequest($request);

            if($collectionForm->isSubmitted() && $collectionForm->isValid()){
                $entityManager->persist($collection);
                $entityManager->flush();
                return $this->redirectToRoute('collection_by_id', array('id' => $collection->getCollectionId()));
            }
            return $this->render('p08_collection/form/insert.form.collection.twig', array(
                'form' => $collectionForm->createView(), 'collection' => $collection
            ));
        }
    */
}
