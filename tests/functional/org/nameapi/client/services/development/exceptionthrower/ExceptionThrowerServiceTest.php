<?php

namespace org\nameapi\client\services\system\ping;

require_once(__DIR__.'/../../BaseServiceTest.php');

use org\nameapi\client\fault\ServiceException;
use org\nameapi\client\services\BaseServiceTest;

class ExceptionThrowerServiceTest extends BaseServiceTest {


    public function testInternalServerError() {
        $exceptionThrower = $this->makeServiceFactory()->developmentServices()->exceptionThrower();
        try {
            $result = $exceptionThrower->throwException('InternalServerError', 100);
            $this->fail("Expected an exception!");
        } catch (ServiceException $e) {
            $faultInfo = $e->getFaultInfo();
            $this->assertEquals('InternalServerError', $faultInfo->getFaultCause());
            $this->assertTrue($faultInfo->getBlame()->isServer());
            $this->assertEquals(null, $faultInfo->getRetrySameLocation());
        }
    }

    public function testInvalidInput() {
        $exceptionThrower = $this->makeServiceFactory()->developmentServices()->exceptionThrower();
        try {
            $result = $exceptionThrower->throwException('InvalidInput', 100);
            $this->fail("Expected an exception!");
        } catch (ServiceException $e) {
            $faultInfo = $e->getFaultInfo();
            $this->assertEquals('BadRequest', $faultInfo->getFaultCause());
            $this->assertTrue($faultInfo->getBlame()->isClient());
            $this->assertTrue($faultInfo->getRetrySameLocation()->getRetryType()->isNo());
        }
    }


    /**
     * This doesn't throw because the exception chance is set to zero.
     */
    public function testNoException() {
        $exceptionThrower = $this->makeServiceFactory()->developmentServices()->exceptionThrower();
        $result = $exceptionThrower->throwException('InternalServerError', 0);
        $this->assertEquals('OK', $result);
    }

}
