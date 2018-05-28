<?php

namespace AppBundle\Tenant\Initializer;

use Ds\Component\Config\Service\ConfigService;
use Ds\Component\Tenant\Initializer\Initializer;

/**
 * Class ConfigInitializer
 */
class ConfigInitializer implements Initializer
{
    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    protected $configService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Config\Service\ConfigService $configService
     */
    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(array $data)
    {
        $items = [
            [
                'key' => 'app.spa.admin',
                'value' => $data['config']['app.spa.admin']['value']
            ],
            [
                'key' => 'app.spa.portal',
                'value' => $data['config']['app.spa.portal']['value']
            ],
            [
                'key' => 'app.registration.individual.owner',
                'value' => 'BusinessUnit'
            ],
            [
                'key' => 'app.registration.individual.owner_uuid',
                'value' => $data['business_unit']['administration']['uuid']
            ],
            [
                'key' => 'app.registration.individual.roles',
                'value' => 'ROLE_INDIVIDUAL'
            ],
            [
                'key' => 'app.registration.individual.enabled',
                'value' => '1'
            ],
            [
                'key' => 'app.registration.organization.owner',
                'value' => 'BusinessUnit'
            ],
            [
                'key' => 'app.registration.organization.owner_uuid',
                'value' => $data['business_unit']['administration']['uuid']
            ],
            [
                'key' => 'app.registration.organization.roles',
                'value' => 'ROLE_ORGANIZATION'
            ],
            [
                'key' => 'app.registration.organization.enabled',
                'value' => '1'
            ],
            [
                'key' => 'app.resetting.email.subject',
                'value' => 'app.resetting.email.subject'
            ],
            [
                'key' => 'app.resetting.email.body.plain',
                'value' => 'app.resetting.email.body.plain'
            ],
            [
                'key' => 'app.resetting.email.body.html',
                'value' => 'app.resetting.email.body.html'
            ]
        ];

        $manager = $this->configService->getManager();

        foreach ($items as $item) {
            $config = $this->configService->createInstance();
            $config
                ->setOwner('BusinessUnit')
                ->setOwnerUuid($data['business_unit']['administration']['uuid'])
                ->setKey($item['key'])
                ->setValue($item['value'])
                ->setTenant($data['tenant']['uuid']);
            $manager->persist($config);
            $manager->flush();
        }
    }
}
