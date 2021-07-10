<?php 

namespace RMValidator\Exceptions\Base;


interface IValidationException {

    public function getOrigMsg() :string;

    public function getMessage() :string; 
}