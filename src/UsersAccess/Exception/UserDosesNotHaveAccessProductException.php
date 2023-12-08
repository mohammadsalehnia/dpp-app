<?php

namespace Src\UsersAccess\Exception;

class UserDosesNotHaveAccessProductException extends \Exception
{
    public static function caseOfThereIsNoSubscription(): self
    {
        return new UserDosesNotHaveAccessProductException('You have not subscription');
    }
}
