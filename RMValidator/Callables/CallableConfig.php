<?php 

namespace RMValidator\Callables;

final class CallableConfig {

    /**
     *
     * @param ?callable $succsessCallable
     * @param ?callable $failiureCallable
     * @param ?callable $forcedCallable
     */
    public function __construct(private $succsessCallable, private $failiureCallable, private $forcedCallable)
    {
        
    }

    public function getSuccsessCallable() : ?callable {
        return $this->succsessCallable;
    }

    public function getFailiureCallable() : ?callable {
        return $this->failiureCallable;
    }

    public function getForcedCallable() : ?callable {
        return $this->forcedCallable;
    }
}