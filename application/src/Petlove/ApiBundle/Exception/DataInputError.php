<?php

namespace Petlove\ApiBundle\Exception;

use Util\Data\DataProcessingErrorList;

class DataInputError extends \RuntimeException
{
    /** @var DataProcessingErrorList */
    private $violations;

    /**
     * @param DataProcessingErrorList $violations
     */
    public function __construct(DataProcessingErrorList $violations)
    {
        parent::__construct((string) $violations);
        $this->violations = $violations;
    }

    /**
     * @return DataProcessingErrorList
     */
    public function getErrors()
    {
        return $this->violations;
    }
}
