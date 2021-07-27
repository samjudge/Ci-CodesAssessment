<?php

namespace App\TitleStatusPairs\Validator;

use App\TitleStatusPairs\Models\Pair;
use App\TitleStatusPairs\Models\ValidationResult;

class Validator // This class and ResponseParser could be made to fit an interface, but doing it now
{               // is IMO too early. Doing so now could influence future design decisions and might end
                // up in square peg/round hole situation, when the abstraction may not be appropriate,
                // and would force the interface to expand in the long run.
    public function validate(Pair $expected, Pair $actual) : ValidationResult
    {
        $isValidTitle = true;
        $isValidStatusCode = true;
        if(!is_null($expected->getTitle()) && $expected->getTitle() !== $actual->getTitle()) {
            $isValidTitle = false;
        }
        if(!is_null($expected->getStatus()) && $expected->getStatus() !== $actual->getStatus()) {
            $isValidStatusCode = false;
        }
        return new ValidationResult($isValidTitle, $isValidStatusCode);
    }
}