<?php

namespace org\nameapi\client\services;

//require '../../../../../../vendor/autoload.php';

use org\nameapi\ontology\input\context\Context;
use org\nameapi\ontology\input\context\Priority;
use org\nameapi\ontology\input\context\TextCase;


abstract class BaseServiceTest extends \PHPUnit_Framework_TestCase {

    private $apiKey = null; //grab yours from nameapi.org

    /**
     * @return Context
     */
    protected function makeContext() {
        if (!$this->apiKey) {
            die("Put your api key in the \$apiKey variable to run these functional tests!");
        }
        return Context::builder()
            ->priority(Priority::REALTIME())
            ->textCase(TextCase::TITLE_CASE())
            ->build();
    }

    /**
     * @return ServiceFactory
     */
    protected function makeServiceFactory() {
        //currently connecting to the release candidate server because v5.0 is not live yet.
        return new ServiceFactory($this->apiKey, $this->makeContext(), new Host('http', 'rc50-api.nameapi.org', 80), '5.0');
    }

}
