<?php

namespace Petlove\ApiBundle\DataProcessor;

use Util\Data\DataProcessingError;
use Util\Data\DataProcessingErrorList;
use Petlove\ApiBundle\Exception\DataInputError;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;

class DataValidator
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     * DataValidator constructor.
     */
    public function __construct()
    {
        $this->validator = new Validator(func_get_args());
    }

    /**
     * @param mixed $data
     */
    public function assert($data)
    {
        try {
            $this->validator->assert($data);
        } catch (NestedValidationException $exception) {
            $list = new DataProcessingErrorList();
            foreach ($exception->getIterator() as $validation) {
                $list->add(new DataProcessingError($validation->getMessage(), [$validation->getName()]));
            }
            throw new DataInputError($list);
        }
    }

    public function addRule($rule)
    {
        $this->validator->addRule($rule);
    }
}
