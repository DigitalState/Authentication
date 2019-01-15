<?php

namespace App\Serializer\Normalizer;

use App\Entity\Registration;
use Ds\Component\Config\Service\ConfigService;
use Ds\Component\Acl\Serializer\Normalizer\Property\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class RegistrationNormalizer
 */
final class RegistrationNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    /**
     * @var \Ds\Component\Acl\Serializer\Normalizer\Property\AbstractNormalizer
     */
    private $decorated;

    /**
     * @var \Symfony\Component\Serializer\SerializerInterface
     */
    private $serializer;

    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    private $configService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Acl\Serializer\Normalizer\Property\AbstractNormalizer $decorated
     * @param \Ds\Component\Config\Service\ConfigService $configService
     */
    public function __construct(AbstractNormalizer $decorated, ConfigService $configService)
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
                $key = 'app.registration.'.strtolower($data['identity']);
                $data['owner'] = $this->configService->get($key.'.owner.type');
                $data['ownerUuid'] = $this->configService->get($key.'.owner.uuid');
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
