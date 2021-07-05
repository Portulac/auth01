<?php

namespace App\Form;

use App\Entity\Checkbox;
use App\Entity\CheckboxItem;

use App\Repository\CheckboxItemRepository;
use App\Repository\CheckboxRepository;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Security\Core\Security;

class CheckType extends AbstractType
{
    /**
     * @var CheckboxRepository
     */
    private $checkboxRepo;
    /**
     * @var CheckboxItemRepository
     */
    private $checkboxItemRepo;

    private $security;

    public function __construct(Security $security, CheckboxRepository $checkboxRepository, CheckboxItemRepository $checkboxItemRepository )
    {
        $this->checkboxRepository = $checkboxRepository;
        $this->checkboxItemRepository = $checkboxItemRepository;
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $site = $options['data'] ?? null;
        $user = $this->security->getUser();
        dump($user);
        dd($site);
        $builder
            ->add('myCheck', EntityType::class, array(
                'class' => CheckboxItem::class,
                'query_builder' => $this->checkboxItemRepository->getAllQueryBuilder(),
                'group_by' => function (CheckboxItem $checkboxItem) {
                    return $checkboxItem->getCheckbox()->getId();
                },
                'choice_label' => function (CheckboxItem $checkboxItem) {
                    return $checkboxItem->getDescription();
                },
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CheckboxItem::class,
        ]);
    }
}
