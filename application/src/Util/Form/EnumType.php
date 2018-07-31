<?php

namespace Util\Form;

use Util\Value\Enum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnumType extends AbstractType
{
    /** @var string */
    private $class;

    /**
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        /** @var Enum $class */
        $class = $this->class;

        $resolver->setDefaults([
            'choices' => $class::getAll(),
            'choices_as_values' => true,
            'choice_value' => function ($choice) {
                return strtolower((string) $choice);
            },
            'choice_label' => function ($choice) {
                return (string) $choice;
            },
        ]);
    }
}
