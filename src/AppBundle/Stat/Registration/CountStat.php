<?php

namespace AppBundle\Stat\Registration;

use AppBundle\Service\RegistrationService;
use Ds\Component\Model\Attribute;
use Ds\Component\Statistic\Model\Datum;
use Ds\Component\Statistic\Stat\Stat;

/**
 * Class CountStat
 */
class CountStat implements Stat
{
    use Attribute\Alias;

    /**
     * @var \AppBundle\Service\RegistrationService
     */
    protected $registrationService;

    /**
     * Constructor
     *
     * @param \AppBundle\Service\RegistrationService $registrationService
     */
    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        $datum = new Datum;
        $datum
            ->setAlias($this->alias)
            ->setValue($this->registrationService->getRepository()->getCount([]));

        return $datum;
    }
}
