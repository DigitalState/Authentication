<?php

namespace AppBundle\Serializer\Normalizer;

use AppBundle\Entity\Registration;
use Ds\Component\Config\Service\ConfigService;
use Ds\Component\Security\Serializer\Normalizer\Acl\PropertyNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class RegistrationNormalizer
 */
class RegistrationNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    /**
     * @var \Ds\Component\Security\Serializer\Normalizer\Acl\PropertyNormalizer
     */
    protected $decorated;

    /**
     * @var \Symfony\Component\Serializer\SerializerInterface
     */
    protected $serializer;

    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    protected $configService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Security\Serializer\Normalizer\Acl\PropertyNormalizer $decorated
     * @param \Ds\Component\Config\Service\ConfigService $configService
     */
    public function __construct(PropertyNormalizer $decorated, ConfigService $configService)
    {
        $this->decorated = $decorated;
        $this->configService = $configService;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (Registration::class === $class) {
            if (!array_key_exists('owner', $data) || null === $data['owner']) {
                $data['owner'] = $this->configService->get('app.registration.owner');
                $data['ownerUuid'] = $this->configService->get('app.registration.owner_uuid');
            }
        }

        return $this->decorated->denormalize($data, $class, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = $this->decorated->normalize($object, $format, $context);

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $this->decorated->supportsDenormalization($data, $type, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;

        if ($this->decorated instanceof SerializerAwareInterface) {
            $this->decorated->setSerializer($serializer);
        }
    }
}
