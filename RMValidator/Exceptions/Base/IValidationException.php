<?php 

namespace RMValidator\Exceptions\Base;


interface IValidationException {

    public function getOrigMsg() :string;
    
}