<?php

namespace App\Controller;

use App\Controller\Admin\ModelsRelationsCrudController;
use App\Entity\ModelsParent;
use App\Entity\ModelsRelations;
use App\Repository\ModelsParentRepository;
use App\Repository\ModelsRelationsRepository;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModelsRelationsController extends AbstractController
{
    #[Route('/models/relations', name: 'app_models_relations')]
    public function content(): Response
    {
        return $this->render('model_relations/index.html.twig', [
            'controller_name' => 'ModelRelationsController',
        ]);
    }

    #[Route('/models/relations/link/{modelId}', name: 'app_models_link_models')]
    public function linkModels(int $modelId): Response
    {
        return $this->render('models_relations/link-models.html.twig', [
            'modelId' => $modelId,
        ]);
    }

    /**
     */
    #[Route('/models/relations/link/{parentId}/{childId}', name: 'app_models_delete_link')]
    public function unlinkModels(ManagerRegistry $registry, AdminUrlGenerator $generator, int $parentId, int $childId): Response
    {
        if ($parentId > 0 && $childId > 0) {
            $repo = new ModelsParentRepository($registry);
            $relation = $repo->findOneBy([
                'modelId' => $childId,
                'parentModelId' => $parentId,
            ]);

            if (!empty($relation)) {
                $repo->remove($relation, true);
            }
        }

        $url = $generator->setController(ModelsRelationsCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        return $this->redirect($url);
    }
}
