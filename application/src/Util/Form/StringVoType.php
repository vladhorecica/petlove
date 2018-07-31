<?php

namespace Util\Form;

use Util\Value\StringValueObject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;

class StringVoType extends AbstractType
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
        return 'text';
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        ($options);
        $builder->addModelTransformer(new CallbackTransformer(
            function (StringValueObject $value = null) {
                if ($value) {
                    return $value->getValue();
                }

                return;
            },
            function ($value) {
                if ($value === null || $value === '') {
                    return;
                }
                $class = $this->class;

                return new $class($value);
            }
        ));
    }
}
