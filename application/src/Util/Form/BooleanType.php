<?php

namespace Util\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BooleanType extends AbstractType
{
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
        $resolver->setDefaults([
            'choices' => [true, false],
            'choices_as_values' => true,
            'choice_value' => function ($choice) {
                return $choice ? 'y' : 'n';
            },
            'choice_label' => function ($choice) {
                return $choice ? 'yes' : 'no';
            },
        ]);
    }
}
