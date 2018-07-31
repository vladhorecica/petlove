<?php

namespace Petlove\ApiBundle\Controller;

use Util\Data\DataHelper;
use Util\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class ApiController extends Controller
{
    const SEARCH_DEFAULT_OFFSET = 0;
    const SEARCH_DEFAULT_SIZE = 25;

    /**
     * @return DataHelper
     */
    protected function getQueryData()
    {
        $request = $this->get('request_stack')->getCurrentRequest();

        return new DataHelper($request->query->all());
    }

    /**
     * @return DataHelper
     */
    protected function getRequestData()
    {
        $request = $this->get('request_stack')->getCurrentRequest();

        if (!preg_match('#^application/json(;.*)?$#', $request->headers->get('Content-Type'))) {
            return new DataHelper($request->request->all());
        }

        return new DataHelper(Json::decode($request->getContent()));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\FileBag
     */
    protected function getRequestFiles()
    {
        $request = $this->get('request_stack')->getCurrentRequest();

        return $request->files;
    }

    /**
     * @return mixed
     */
    protected function getAuthorization()
    {
        $request = $this->get('request_stack')->getCurrentRequest();

        return $request->attributes->get('petlove.authorization');
    }
}
