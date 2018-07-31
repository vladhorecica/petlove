<?php

namespace Petlove\ApiBundle\DataProcessor\BackendUser;

use Petlove\ApiBundle\DataProcessor\DataValidator;
use Petlove\Domain\BackendUser\Command\UpdateBackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserEmail;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\BackendUser\Value\BackendUserType;
use Petlove\Domain\BackendUser\Value\BackendUserUsername;
use Respect\Validation\Validator;
use Util\Data\DataHelper;
use Util\Data\DataProcessor;
use Util\Data\Processor\ScalarVoProcessor;

class UpdateBackendUserProcessor implements DataProcessor
{
    /**
     * @var BackendUserId
     */
    private $id;

    /**
     * UpdateBackendUserProcessor constructor.
     *
     * @param BackendUserId $id
     */
    public function __construct(BackendUserId $id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $in
     *
     * @return UpdateBackendUser
     */
    public function __invoke($in)
    {
        $validator = new DataValidator(
            Validator::key('type'),
            Validator::key('email'),
            Validator::key('username')
        );

        $validator->assert($in);
        $data = new DataHelper($in);

        return new UpdateBackendUser(
            $this->id,
            $data->access('email')->process(new ScalarVoProcessor(BackendUserEmail::class))->get(),
            $data->access('username')->process(new ScalarVoProcessor(BackendUserUsername::class))->get(),
            $data->maybe()->access('password')->getString(),
            $data->access('type')->process(new ScalarVoProcessor(BackendUserType::class))->get()
        );
    }
}
