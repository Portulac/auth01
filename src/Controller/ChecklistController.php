<?php

namespace App\Controller;



use App\Entity\CheckboxItem;
use App\Entity\Site;
use App\Entity\UserCheck;
use App\Form\CheckType;
use App\Repository\CheckboxItemRepository;
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
        CheckboxItemRepository $checkboxItemRepository,
        UserCheckRepository $userCheckRepository
    ): Response {

        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery('SELECT c.id, c.name, c.description, IDENTITY(c.parent) as parent_id, uc.isDone FROM App\Entity\CheckboxItem c LEFT JOIN App\Entity\UserCheck uc WITH c.id=uc.checkboxitem and uc.site=:site');
        $query->setParameter(':site', $site->getId());
        $cl = $query->getResult();


        $checklist = $this->buildTreeArray($cl);

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

        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('status' => 'Error'), 400);
        }
        // Request has request data ?
        if (!isset($request->request)) {
            return new JsonResponse(array('status' => 'Error'), 400);
        }


        $user = $this->getUser();
        if (!($user->getSites()->contains($site))) {
            return new JsonResponse(array('status' => 'Error'), 400);
        }

        /////////////stub
        $myData = json_decode($request->request->get('myData'), true);

        foreach ($myData['info'] as $check) {

            $checked = ($check['checked']===true);
            $checkboxitem_id = intval($check['checkboxitem_id']);

            $checkboxitem = $checkboxItemRepository->find($checkboxitem_id);


            /** @var UserCheck $userCheck */
            $userCheck = $userCheckRepository->findOneBy([
                'site' => $site,
                'checkboxitem' => $checkboxitem
            ]);
            //return new JsonResponse(array('status' => 'Done','checked'=>$checked,'checkbox-id'=>$checkboxitem->getId(),'user_check'=>$userCheck->getId()), 200);

            if ($userCheck === null) {
                $userCheck = new UserCheck();
                $userCheck->setSite($site);
                $userCheck->setCheckboxitem($checkboxitem);
            }
            $userCheck->setIsDone($checked);

            $em->persist($userCheck);
            $em->flush();
        }
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

