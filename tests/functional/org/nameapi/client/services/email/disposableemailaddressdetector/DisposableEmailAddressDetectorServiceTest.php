<?php

namespace org\nameapi\client\services\email\disposableemailaddressdetector;

require_once(__DIR__.'/../../BaseServiceTest.php');

use org\nameapi\client\services\BaseServiceTest;

class DisposableEmailAddressDetectorServiceTest extends BaseServiceTest {

    public function testIsDisposable_yes() {
        $deaDetector = $this->makeServiceFactory()->emailServices()->disposableEmailAddressDetector();
        $result = $deaDetector->isDisposable("abcdefgh@10minutemail.com");
        $this->assertTrue($result->getDisposable()->isDisposable());
    }

    public function testIsDisposable_no() {
        $deaDetector = $this->makeServiceFactory()->emailServices()->disposableEmailAddressDetector();
        $result = $deaDetector->isDisposable("larry@google.com");
        $this->assertFalse($result->getDisposable()->isDisposable());
    }

}
