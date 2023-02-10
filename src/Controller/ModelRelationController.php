<?php

namespace App\Controller;

use App\Controller\Admin\ModelsCrudController;
use App\Controller\Admin\ModelRelationCrudController;
use App\Entity\ModelsParent;
use App\Repository\ModelsParentRepository;
use App\Repository\ModelsRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModelRelationController extends AbstractController
{
    #[Route('/models/relations', name: 'app_models_relations')]
    public function content(): Response
    {
        return $this->render('model_relations/index.html.twig', [
            'controller_name' => 'ModelRelationsController',
        ]);
    }

    #[Route('/models/relations/link/{modelId}/{modelName}/{manufacturerId}', name: 'app_models_link_models')]
    public function linkModels(ModelsRepository $repo, AdminUrlGenerator $generator, int $modelId, string $modelName, int $manufacturerId, string $manufacturer): Response
    {
        $url = $generator->unsetAll()->setController(ModelsCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        return $this->render('models_relations/link-models.html.twig', [
            'modelId' => $modelId,
            'modelName' => $modelName,
            'manufacturer' => $manufacturer,
            'entities' => $repo->findParentCandidates($manufacturerId, $modelId),
            'redirectUrl' => urlencode($url),
        ]);
    }

    #[Route('/models/relations/unlink/{parentId}/{childId}', name: 'app_models_delete_link')]
    public function unlinkModels(ModelsParentRepository $repo, AdminUrlGenerator $generator, int $parentId, int $childId): Response
    {
        if ($parentId > 0 && $childId > 0) {
            $relation = $repo->findOneBy([
                'modelId' => $childId,
                'parentModelId' => $parentId,
            ]);

            if (!empty($relation)) {
                $repo->remove($relation, true);
            }
        }

        $url = $generator->setController(ModelRelationCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        return $this->redirect($url);
    }

    #[Route('/models/relations/link/{parentId}/{childId}', name: 'app_models_set_relation')]
    public function setRelation(ModelsParentRepository $repo, int $parentId, int $childId): Response
    {
        //validate selected model does not have already a parent
        $hasParent = $repo->findOneBy(['modelId' => $childId]);
        if (!empty($hasParent)) {
            $body = [
                'status' => 'error',
                'msg' => 'Model already has a parent, model Id: ' . $hasParent->getParentModelId(),
            ];
            $status = 500;
        } else {
            $isParent = $repo->findOneBy(['parentModelId' => $childId]);
            if (!empty($isParent)) {
                $body = [
                    'status' => 'error',
                    'msg' => 'Model can not be linked as it\'s a parent of other models.',
                ];
                $status = 500;
            } else {
                $modelRelation = new ModelsParent($childId, $parentId);
                try {
                    $repo->save($modelRelation, true);
                    $body = ['status' => 'ok'];
                    $status = 200;
                } catch (\Exception $e) {
                    $body = ['status' => 'error', 'msg' => $e->getMessage()];
                    $status = 418;
                }
            }
        }

        $response = new Response(json_encode($body), $status);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
