<?php

namespace Domain\Student\Events;

use Ddd\Domain\Events\IntegrationEvent;

final class StudentRegistered extends StudentEvent implements IntegrationEvent
{

    public const NAME = 'student_registered';

}
