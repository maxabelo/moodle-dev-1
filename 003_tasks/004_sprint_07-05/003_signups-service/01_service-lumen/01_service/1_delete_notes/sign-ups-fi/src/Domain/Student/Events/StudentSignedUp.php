<?php

namespace Domain\Student\Events;

use Ddd\Domain\Events\IntegrationEvent;

class StudentSignedUp extends StudentEvent implements IntegrationEvent
{

    public const NAME = 'student_signedup';


}
