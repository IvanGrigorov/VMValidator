<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Numbers\RangeAttribute;
use RMValidator\Callables\CallableConfig;
use RMValidator\Validators\MasterValidator;

class ValidationCallbacksTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testMasterValidator_successCallbackShouldExecuteCallbackOnSuccessfullValidation()
    {
        $controll = 0;
        $callableConfig = new CallableConfig(function() use (&$controll) {
            $controll++;
        }, null, null);
        MasterValidator::validate(new SuccessfullValidityTest(), null, $callableConfig);
        $this->assertEquals(1, $controll);
    }

    public function testMasterValidator_successCallbackShouldNotExecuteCallbackOnUnuccessfullValidation()
    {
        $controll = 0;
        $callableConfig = new CallableConfig(function() use (&$controll) {
            $controll++;
        }, null, null);
        try {
            MasterValidator::validate(new UnsuccessfullValidityTest(), null, $callableConfig);
        }
        catch(Exception $e) {
            $this->assertEquals(0, $controll);
        }
        
    }

    public function testMasterValidator_failuireCallbackShouldNotExecuteCallbackOnSuccessfullValidation()
    {
        $controll = 0;
        $callableConfig = new CallableConfig(null, function() use (&$controll) {
            $controll++;
        }, null);
        MasterValidator::validate(new SuccessfullValidityTest(), null, $callableConfig);
        $this->assertEquals(0, $controll);
    }

    public function testMasterValidator_failuireCallbackShouldExecuteCallbackOnUnuccessfullValidation()
    {
        $controll = 0;
        $callableConfig = new CallableConfig(null, function() use (&$controll) {
            $controll++;
        }, null);
        try {
            MasterValidator::validate(new UnsuccessfullValidityTest(), null, $callableConfig);
        }
        catch(Exception $e) {
            $this->assertEquals(1, $controll);
        }
        
    }

    public function testMasterValidator_forcedCallbackShouldExecuteCallbackOnSuccessfullValidationButForce()
    {
        $controll = 0;
        $callableConfig = new CallableConfig(null, null, function() use (&$controll) {
            $controll++;
        });
        try {
            MasterValidator::validate(new UnsuccessfullValidityTest(), null, $callableConfig);
        }
        catch(Exception $e) {
            $this->assertEquals(1, $controll);
        }
        
    }

    public function testMasterValidator_forcedCallbackShouldExecuteCallbackOnUnuccessfullValidationButForce()
    {
        $controll = 0;
        $callableConfig = new CallableConfig(null, null, function() use (&$controll) {
            $controll++;
        });
        try {
            MasterValidator::validate(new UnsuccessfullValidityTest(), null, $callableConfig);
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