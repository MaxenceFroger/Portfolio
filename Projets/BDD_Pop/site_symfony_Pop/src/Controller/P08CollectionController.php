<?php

namespace App\Controller;

use App\Entity\P08Collection;
use App\Entity\P08FigurineCaracteristique;
use App\Entity\P08Inventaire;
use App\Form\SearchType;
use App\Form\CollectionType;
use App\Repository\P08CollectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function PHPUnit\Framework\throwException;

final class P08CollectionController extends AbstractController
{
    //#[Route('/p08/collection/index', name: 'index_p08_collection')]
    public function index(): Response
    {
        return $this->render('p08_collection/index.html.twig', [
            'controller_name' => 'P08CollectionController',
        ]);
    }


    #[Route('/collection/insert', name: 'create_collection')]
    public function createCollection(EntityManagerInterface $entityManager): Response
    {
        $collection = new P08Collection();
        $collection->setCollectionNom("Twitter");
        $collection->setCollectionCategorie("X");
        $collection->setCollectionLicence("Musk");
        $entityManager->persist($collection);
        $entityManager->flush();
        return $this->render('p08_collection/findId.html.twig', array('collection' => $collection));
    }

    #[Route('/collection', name: 'list_collection')]
    public function listCollection(EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $queryBuilder = $entityManager->getRepository(P08Collection::class)->createQueryBuilder('c');
        $search = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
        }
        if ($search) {
            $queryBuilder->andWhere('LOWER(c.collection_nom) LIKE LOWER(:search)')
                ->orWhere('LOWER(c.collection_categorie) LIKE LOWER(:search)')
                ->orWhere('LOWER(c.collection_licence) LIKE LOWER(:search)')
                ->setParameter('search', '%' . $search . '%');
        }

        $queryBuilder->orderBy('c.collection_id', 'ASC');
        $query = $queryBuilder->getQuery();
        $collections = $query->getResult();
        return $this->render('p08_collection/list.html.twig', ['collections' => $collections,
            'form' => $form->createView()]);
    }

    #[Route('/collection/{id<\d+>}', name: 'collection_by_id')]
    public function findCollectionByID($id, EntityManagerInterface $entityManager, RequestStack $request): Response
    {
        $session = $request->getSession();

        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return $this->render('p08_collection/error_id.html.twig');
        }


        if (!$session->has("id")) {
                $session->set("id", $id);
        }


        $collection = $entityManager->getRepository(P08Collection::class)->find($id);
        return $this->render('p08_collection/findId.html.twig', ['collection' => $collection]);
    }

    #[Route('/collection/update/{id}', name: 'updateCollection_by_id')]
    public function updateById($id, EntityManagerInterface $entityManager, RequestStack $request): Response
    {
        $session = $request->getSession();

        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return $this->render('p08_collection/error_id.html.twig');
        }

        if (!$session->has("id")) {
                $session->set("id", $id);
        }


        $collection = $entityManager->getRepository(P08Collection::class)->find($id);
        if (!is_null($collection)) {
            $collection->setCollectionCategorie("Test");
            $entityManager->flush();
        }
        return $this->render('p08_collection/updateId.html.twig', ['collection' => $collection]);
    }

    #[Route('/collection/delete/{id}', name: 'deleteCollection_by_id')]
    public function deleteById($id, EntityManagerInterface $entityManager, RequestStack $request): Response
    {
        $collection = $entityManager->getRepository(P08Collection::class)->find($id);
        if (!is_null($collection)) {
            $figurines = $entityManager->getRepository(P08FigurineCaracteristique::class)->findBy(array('collection_id' => $collection->getCollectionId()));
            foreach ($figurines as $figurine){
                $figurinesInv = $entityManager->getRepository(P08Inventaire::class)->findBy(array('figurine_reference'=>$figurine->getFigurineReference()));
                foreach ($figurinesInv as $figurineInv){
                    $entityManager->remove($figurineInv);
                }
                $entityManager->flush();
                $entityManager->remove($figurine);
            }
            $entityManager->flush();
            $entityManager->remove($collection);
            $entityManager->flush();
        }
        return $this->render('p08_collection/deleteId.html.twig', ['collection' => $collection]);
    }

    #[Route('/collection/updateForm/{id}', name: 'update2_by_id')]
    public function updateAction(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $collection = $entityManager->getRepository(P08Collection::class)->find($id);
        $collectionForm = $this->createForm(CollectionType::class, $collection);
        $collectionForm->handleRequest($request);
        if($collectionForm->isSubmitted() && $collectionForm->isValid()){
            $entityManager->flush();
            return $this->redirectToRoute('collection_by_id', array('id' => $collection->getCollectionId()));
        }
        return $this->render('p08_collection/form/update.form.collection.twig', array(
            'form' => $collectionForm->createView(), 'collection' => $collection
        ));
    }

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
        $figurine = $entityManager->getRepository(P08FigurineCaracteristique::class)->findBy(array(), array('figurine_nom' => 'ASC'));
        return $this->render('p08_collection/form/insert.form.collection.twig', array(
            'form' => $collectionForm->createView(), 'collection' => $collection
        ));
    }
}
