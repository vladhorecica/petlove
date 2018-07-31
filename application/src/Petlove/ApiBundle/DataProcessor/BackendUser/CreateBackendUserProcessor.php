<?php

namespace Petlove\ApiBundle\DataProcessor\BackendUser;

use Petlove\ApiBundle\DataProcessor\DataValidator;
use Petlove\Domain\BackendUser\Command\CreateBackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserEmail;
use Petlove\Domain\BackendUser\Value\BackendUserType;
use Petlove\Domain\BackendUser\Value\BackendUserUsername;
use Respect\Validation\Validator;
use Util\Data\DataHelper;
use Util\Data\DataProcessor;
use Util\Data\Processor\ScalarVoProcessor;

class CreateBackendUserProcessor implements DataProcessor
{
    /**
     * @param mixed $in
     *
     * @return CreateBackendUser
     */
    public function __invoke($in)
    {
        $validator = new DataValidator(
            Validator::key('type'),
            Validator::key('email'),
            Validator::key('password'),
            Validator::key('username')
        );

        $validator->assert($in);
        $data = new DataHelper($in);

        return new CreateBackendUser(
            $data->access('email')->process(new ScalarVoProcessor(BackendUserEmail::class))->get(),
            $data->access('username')->process(new ScalarVoProcessor(BackendUserUsername::class))->get(),
            $data->access('password')->getString(),
            $data->access('type')->process(new ScalarVoProcessor(BackendUserType::class))->get()
        );
    }
}
