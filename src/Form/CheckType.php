<?php

namespace App\Form;


use App\Entity\CheckboxItem;

use App\Entity\Site;
use App\Repository\CheckboxItemRepository;



use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class CheckType extends AbstractType
{
    /**
     * @var CheckboxItemRepository
     */
    private $checkboxItemRepository;

    public function __construct(CheckboxItemRepository $checkboxItemRepository)
    {
        $this->checkboxItemRepository = $checkboxItemRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Site $site */
        $site = $options['site'] ?? null;

        //$user_checks = $site->getUserChecks();
        $pref_choices = $this->checkboxItemRepository->getCheckboxItemUserCheck($site);

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
                'choice_attr' => function (CheckboxItem $checkboxItem) use ($pref_choices) {
                    return array(
                        'attrname' => 'checked',
                        'attrvalue' => in_array($checkboxItem, $pref_choices) ? 'true' : 'false'
                    );
                },
                //'preferred_choices' =>
                //    function(CheckboxItem $checkboxItem) use ($pref_choices) {
                //       return (in_array($checkboxItem, $pref_choices));
                //   }

            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CheckboxItem::class,
            'site' => Site::class
        ]);
        parent::configureOptions($resolver);

    }
}
