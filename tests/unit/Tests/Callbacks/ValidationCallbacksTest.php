<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Numbers\RangeAttribute;
use RMValidator\Validators\MasterValidator;

class ValidationCallbacksTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testMasterValidator_shouldExecuteCallbackOnSuccessfullValidation()
    {
        $controll = 0;
        MasterValidator::validate(new SuccessfullValidityTest(), null, function() use (&$controll) {
            $controll++;
        });
        $this->assertEquals(1, $controll);
    }

    public function testMasterValidator_shouldNotExecuteCallbackOnUnuccessfullValidation()
    {
        $controll = 0;
        try {
            MasterValidator::validate(new UnsuccessfullValidityTest(), null, function() use (&$controll) {
                $controll++;
            });
        }
        catch(Exception $e) {
            $this->assertEquals(0, $controll);
        }
        
    }

    public function testMasterValidator_shouldExecuteCallbackOnUnuccessfullValidationButForce()
    {
        $controll = 0;
        try {
            MasterValidator::validate(new UnsuccessfullValidityTest(), null, function() use (&$controll) {
                $controll++;
            }, true);
        }
        catch(Exception $e) {
            $this->assertEquals(1, $controll);
        }
        
    }
}

class SuccessfullValidityTest {

    #[RangeAttribute(from:10, to:50)]
    public static function successfulMethod() {
        return 40;
    }
}

class UnsuccessfullValidityTest {

    #[RangeAttribute(from:10, to:50)]
    public static function unSuccessfulMethod() {
        return 60;
    }
}