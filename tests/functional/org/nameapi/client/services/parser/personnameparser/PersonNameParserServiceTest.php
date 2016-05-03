<?php

namespace org\nameapi\client\services\parser\personnameparser;

require_once(__DIR__.'/../../BaseServiceTest.php');

use org\nameapi\client\services\BaseServiceTest;
use org\nameapi\ontology\input\entities\person\NaturalInputPerson;
use org\nameapi\ontology\input\entities\person\name\InputPersonName;

class PersonNameParserServiceTest extends BaseServiceTest {

    public function testParse() {
        $personNameParser = $this->makeServiceFactory()->parserServices()->personNameParser();
        $inputPerson = NaturalInputPerson::builder()
            ->name(InputPersonName::westernBuilder()
                ->fullname( "John Doe" )
                ->build())
            ->build();
        $parseResult = $personNameParser->parse($inputPerson);

        //the assertions:
        $bestMatch = $parseResult->getBestMatch();
        $this->assertEquals('NATURAL', (string)$bestMatch->getParsedPerson()->getPersonType());
        $this->assertEquals('PRIMARY', (string)$bestMatch->getParsedPerson()->getPersonRole());
        $this->assertEquals('John', $bestMatch->getParsedPerson()->getAddressingGivenName());
        $this->assertEquals('Doe', $bestMatch->getParsedPerson()->getAddressingSurname());
        $this->assertEquals('John', $bestMatch->getParsedPerson()->getOutputPersonName()->getFirst('GIVENNAME')->getString());
        $this->assertEquals('Doe', $bestMatch->getParsedPerson()->getOutputPersonName()->getFirst('SURNAME')->getString());
    }

    public function testParseSingleGivenName() {
        $personNameParser = $this->makeServiceFactory()->parserServices()->personNameParser();
        $inputPerson = NaturalInputPerson::builder()
            ->name(InputPersonName::westernBuilder()
                ->fullname( "John" )
                ->build())
            ->build();
        $parseResult = $personNameParser->parse($inputPerson);

        //the assertions:
        $bestMatch = $parseResult->getBestMatch();
        $this->assertEquals('NATURAL', (string)$bestMatch->getParsedPerson()->getPersonType());
        $this->assertEquals('PRIMARY', (string)$bestMatch->getParsedPerson()->getPersonRole());
        $this->assertEquals('John', $bestMatch->getParsedPerson()->getAddressingGivenName());
        $this->assertEquals('John', $bestMatch->getParsedPerson()->getOutputPersonName()->getFirst('GIVENNAME')->getString());
    }

}
