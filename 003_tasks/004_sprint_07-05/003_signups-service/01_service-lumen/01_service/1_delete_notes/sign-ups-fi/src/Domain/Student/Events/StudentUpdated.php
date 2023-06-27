<?php

namespace Domain\Student\Events;

use Ddd\Domain\Events\IntegrationEvent;

final class StudentUpdated extends StudentEvent implements IntegrationEvent
{

    public const NAME = 'student_updated';

}
