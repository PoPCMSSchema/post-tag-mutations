<?php

declare(strict_types=1);

namespace PoPCMSSchema\PostTagMutations\FieldResolvers\ObjectType;

use PoPCMSSchema\PostTags\TypeResolvers\ObjectType\PostTagObjectTypeResolver;
use PoPCMSSchema\PostTagMutations\TypeResolvers\ObjectType\PostTagUpdateMutationPayloadObjectTypeResolver;
use PoPCMSSchema\PostTagMutations\TypeResolvers\ObjectType\RootCreatePostTagTermMutationPayloadObjectTypeResolver;
use PoPCMSSchema\PostTagMutations\TypeResolvers\ObjectType\RootUpdatePostTagTermMutationPayloadObjectTypeResolver;
use PoPSchema\SchemaCommons\FieldResolvers\ObjectType\AbstractObjectMutationPayloadObjectTypeFieldResolver;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;

class PostTagMutationPayloadObjectTypeFieldResolver extends AbstractObjectMutationPayloadObjectTypeFieldResolver
{
    private ?PostTagObjectTypeResolver $postTagObjectTypeResolver = null;

    final public function setPostObjectTypeResolver(PostTagObjectTypeResolver $postTagObjectTypeResolver): void
    {
        $this->postTagObjectTypeResolver = $postTagObjectTypeResolver;
    }
    final protected function getPostObjectTypeResolver(): PostTagObjectTypeResolver
    {
        if ($this->postTagObjectTypeResolver === null) {
            /** @var PostTagObjectTypeResolver */
            $postTagObjectTypeResolver = $this->instanceManager->getInstance(PostTagObjectTypeResolver::class);
            $this->postTagObjectTypeResolver = $postTagObjectTypeResolver;
        }
        return $this->postTagObjectTypeResolver;
    }

    /**
     * @return array<class-string<ObjectTypeResolverInterface>>
     */
    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            PostTagUpdateMutationPayloadObjectTypeResolver::class,
            RootCreatePostTagTermMutationPayloadObjectTypeResolver::class,
            RootUpdatePostTagTermMutationPayloadObjectTypeResolver::class,
        ];
    }

    protected function getObjectFieldName(): string
    {
        return 'tag';
    }

    public function getFieldTypeResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ConcreteTypeResolverInterface
    {
        return match ($fieldName) {
            $this->getObjectFieldName() => $this->getPostObjectTypeResolver(),
            default => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
        };
    }
}
