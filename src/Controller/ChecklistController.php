<?php

namespace App\Controller;


use App\Entity\Checkbox;
use App\Entity\CheckboxItem;
use App\Entity\Site;
use App\Entity\UserCheck;
use App\Form\CheckType;
use App\Repository\CheckboxItemRepository;
use App\Repository\CheckboxRepository;
use App\Repository\SiteRepository;


use App\Repository\UserCheckRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ChecklistController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/", name="app_homepage")
     */

    public function index(): Response
    {
        $sites = $this->getUser()->getSites();

        return $this->render('checklist/index.html.twig', [
            'sites' => $sites,
        ]);

    }

    /**
     * @Route("/{id}/check", name="site_check", methods={"GET"})
     */
    public function check(
        Request $request,
        Site $site,
        CheckboxRepository $checkboxRepository,
        CheckboxItemRepository $checkboxItemRepository,
        UserCheckRepository $userCheckRepository
    ): Response {


        /** @var UserCheck $userCheck */
        $userCheck = $userCheckRepository->findOneBy([
            'site' => $site->getId(),
            'checkboxitem' => 20
        ]);

        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery('SELECT c.id, c.name, c.description, IDENTITY(c.parent) as parent_id, uc.isDone FROM App\Entity\CheckboxItem c LEFT JOIN App\Entity\UserCheck uc WITH c.id=uc.checkboxitem and uc.site=:site');
        $query->setParameter(':site', $site->getId());
        $cl = $query->getResult();

        $checklist = $this->buildTreeArray($cl);
        //dump($checklist);

        return $this->render('checklist/check.html.twig', [
            'site' => $site,
            'checklist' => $checklist
        ]);

    }

    /**
     * @Route("/do_check/{id}", name="user_do_check", methods={"POST","GET"})
     */
    public function userDoCheck(
        Site $site,
        Request $request,
        CheckboxItemRepository $checkboxItemRepository,
        UserCheckRepository $userCheckRepository,
        EntityManagerInterface $em
    ) {
        $info_array = $request->request->get('data_to_send');
        dump($info_array[0]['info']);
        return new JsonResponse(array('ss' => $info_array[0]['info'][0]['checkboxitem_id']), 400);
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('status' => 'Error'), 400);
        }
        // Request has request data ?
        if (!isset($request->request)) {
            return new JsonResponse(array('status' => 'Error'), 400);
        }
        // Get data
        $checked = intval($request->request->get('checked'));
        $checkboxitem_id = intval($request->request->get('checkboxitem_id'));
        // Is the data correct ?
        if ($checked != 1 && $checked != 2) {
            return new JsonResponse(array('status' => 'Error'), 400);
        }

        $user = $this->getUser();
        if (!($user->getSites()->contains($site))) {
            return new JsonResponse(array('status' => 'Error'), 400);
        }
        $checkboxitem = $checkboxItemRepository->find($checkboxitem_id);

        /** @var UserCheck $userCheck */
        $userCheck = $userCheckRepository->findOneBy([
            'site' => $site,
            'checkboxitem' => $checkboxitem
        ]);

        if ($userCheck === null) {
            $userCheck = new UserCheck();
            $userCheck->setSite($site);
            $userCheck->setCheckboxitem($checkboxitem);
        }
        $userCheck->setIsDone($checked % 2);

        $em->persist($userCheck);
        $em->flush();

        return new JsonResponse(array('status' => 'Done'), 200);
    }


    public function buildTreeArray(array &$elements, $parentId = 0)
    {

        $branch = array();

        foreach ($elements as &$element) {

            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTreeArray($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['id']] = $element;
                unset($element);
            }
        }

        return $branch;
    }
}

