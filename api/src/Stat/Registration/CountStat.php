<?php

namespace App\Stat\Registration;

use App\Service\RegistrationService;
use Ds\Component\Model\Attribute;
use Ds\Component\Statistic\Model\Datum;
use Ds\Component\Statistic\Stat\Stat;

/**
 * Class CountStat
 */
final class CountStat implements Stat
{
    use Attribute\Alias;

    /**
     * @var \App\Service\RegistrationService
     */
    private $registrationService;

    /**
     * Constructor
     *
     * @param \App\Service\RegistrationService $registrationService
     */
    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    /**
     * {@inheritdoc}
     */
    public function get(): Datum
    {
        $datum = new Datum;
        $datum
            ->setAlias($this->alias)
            ->setValue($this->registrationService->getRepository()->getCount([]));

        return $datum;
    }
}
