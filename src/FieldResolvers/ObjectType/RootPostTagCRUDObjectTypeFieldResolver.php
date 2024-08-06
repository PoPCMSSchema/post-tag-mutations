<?php

declare(strict_types=1);

namespace PoPCMSSchema\PostTagMutations\FieldResolvers\ObjectType;

use PoPCMSSchema\TagMutations\Module;
use PoPCMSSchema\TagMutations\ModuleConfiguration;
use PoPCMSSchema\TagMutations\TypeResolvers\InputObjectType\RootCreateTagTermInputObjectTypeResolver;
use PoPCMSSchema\TagMutations\TypeResolvers\InputObjectType\RootDeleteTagTermInputObjectTypeResolver;
use PoPCMSSchema\TagMutations\TypeResolvers\InputObjectType\RootUpdateTagTermInputObjectTypeResolver;
use PoPCMSSchema\PostTags\TypeResolvers\ObjectType\PostTagObjectTypeResolver;
use PoPCMSSchema\PostTagMutations\MutationResolvers\CreatePostTagTermBulkOperationMutationResolver;
use PoPCMSSchema\PostTagMutations\MutationResolvers\CreatePostTagTermMutationResolver;
use PoPCMSSchema\PostTagMutations\MutationResolvers\DeletePostTagTermBulkOperationMutationResolver;
use PoPCMSSchema\PostTagMutations\MutationResolvers\DeletePostTagTermMutationResolver;
use PoPCMSSchema\PostTagMutations\MutationResolvers\PayloadableCreatePostTagTermBulkOperationMutationResolver;
use PoPCMSSchema\PostTagMutations\MutationResolvers\PayloadableCreatePostTagTermMutationResolver;
use PoPCMSSchema\PostTagMutations\MutationResolvers\PayloadableDeletePostTagTermBulkOperationMutationResolver;
use PoPCMSSchema\PostTagMutations\MutationResolvers\PayloadableDeletePostTagTermMutationResolver;
use PoPCMSSchema\PostTagMutations\MutationResolvers\PayloadableUpdatePostTagTermBulkOperationMutationResolver;
use PoPCMSSchema\PostTagMutations\MutationResolvers\PayloadableUpdatePostTagTermMutationResolver;
use PoPCMSSchema\PostTagMutations\MutationResolvers\UpdatePostTagTermBulkOperationMutationResolver;
use PoPCMSSchema\PostTagMutations\MutationResolvers\UpdatePostTagTermMutationResolver;
use PoPCMSSchema\PostTagMutations\TypeResolvers\ObjectType\RootCreatePostTagTermMutationPayloadObjectTypeResolver;
use PoPCMSSchema\PostTagMutations\TypeResolvers\ObjectType\RootDeletePostTagTermMutationPayloadObjectTypeResolver;
use PoPCMSSchema\PostTagMutations\TypeResolvers\ObjectType\RootUpdatePostTagTermMutationPayloadObjectTypeResolver;
use PoPCMSSchema\SchemaCommons\FieldResolvers\ObjectType\BulkOperationDecoratorObjectTypeFieldResolverTrait;
use PoPCMSSchema\SchemaCommons\FieldResolvers\ObjectType\MutationPayloadObjectsObjectTypeFieldResolverTrait;
use PoPCMSSchema\UserState\Checkpoints\UserLoggedInCheckpoint;
use PoP\ComponentModel\Checkpoints\CheckpointInterface;
use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedbackStore;
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoP\ComponentModel\QueryResolution\FieldDataAccessorInterface;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\InputTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ScalarType\BooleanScalarTypeResolver;
use PoP\Engine\Module as EngineModule;
use PoP\Engine\ModuleConfiguration as EngineModuleConfiguration;
use PoP\Engine\TypeResolvers\ObjectType\RootObjectTypeResolver;
use PoP\Root\App;

class RootPostTagCRUDObjectTypeFieldResolver extends AbstractObjectTypeFieldResolver
{
    use MutationPayloadObjectsObjectTypeFieldResolverTrait;
    use BulkOperationDecoratorObjectTypeFieldResolverTrait;

    private ?PostTagObjectTypeResolver $postTagObjectTypeResolver = null;
    private ?RootDeletePostTagTermMutationPayloadObjectTypeResolver $rootDeletePostTagTermMutationPayloadObjectTypeResolver = null;
    private ?RootUpdatePostTagTermMutationPayloadObjectTypeResolver $rootUpdatePostTagTermMutationPayloadObjectTypeResolver = null;
    private ?RootCreatePostTagTermMutationPayloadObjectTypeResolver $rootCreatePostTagTermMutationPayloadObjectTypeResolver = null;
    private ?CreatePostTagTermMutationResolver $createPostTagTermMutationResolver = null;
    private ?CreatePostTagTermBulkOperationMutationResolver $createPostTagTermBulkOperationMutationResolver = null;
    private ?DeletePostTagTermMutationResolver $deletePostTagTermMutationResolver = null;
    private ?DeletePostTagTermBulkOperationMutationResolver $deletePostTagTermBulkOperationMutationResolver = null;
    private ?UpdatePostTagTermMutationResolver $updatePostTagTermMutationResolver = null;
    private ?UpdatePostTagTermBulkOperationMutationResolver $updatePostTagTermBulkOperationMutationResolver = null;
    private ?PayloadableDeletePostTagTermMutationResolver $payloadableDeletePostTagTermMutationResolver = null;
    private ?PayloadableDeletePostTagTermBulkOperationMutationResolver $payloadableDeletePostTagTermBulkOperationMutationResolver = null;
    private ?PayloadableUpdatePostTagTermMutationResolver $payloadableUpdatePostTagTermMutationResolver = null;
    private ?PayloadableUpdatePostTagTermBulkOperationMutationResolver $payloadableUpdatePostTagTermBulkOperationMutationResolver = null;
    private ?PayloadableCreatePostTagTermMutationResolver $payloadableCreatePostTagTermMutationResolver = null;
    private ?PayloadableCreatePostTagTermBulkOperationMutationResolver $payloadableCreatePostTagTermBulkOperationMutationResolver = null;
    private ?RootDeleteTagTermInputObjectTypeResolver $rootDeleteTagTermInputObjectTypeResolver = null;
    private ?RootUpdateTagTermInputObjectTypeResolver $rootUpdateTagTermInputObjectTypeResolver = null;
    private ?RootCreateTagTermInputObjectTypeResolver $rootCreateTagTermInputObjectTypeResolver = null;
    private ?UserLoggedInCheckpoint $userLoggedInCheckpoint = null;
    private ?BooleanScalarTypeResolver $booleanScalarTypeResolver = null;

    final public function setPostTagObjectTypeResolver(PostTagObjectTypeResolver $postTagObjectTypeResolver): void
    {
        $this->postTagObjectTypeResolver = $postTagObjectTypeResolver;
    }
    final protected function getPostTagObjectTypeResolver(): PostTagObjectTypeResolver
    {
        if ($this->postTagObjectTypeResolver === null) {
            /** @var PostTagObjectTypeResolver */
            $postTagObjectTypeResolver = $this->instanceManager->getInstance(PostTagObjectTypeResolver::class);
            $this->postTagObjectTypeResolver = $postTagObjectTypeResolver;
        }
        return $this->postTagObjectTypeResolver;
    }
    final public function setRootDeletePostTagTermMutationPayloadObjectTypeResolver(RootDeletePostTagTermMutationPayloadObjectTypeResolver $rootDeletePostTagTermMutationPayloadObjectTypeResolver): void
    {
        $this->rootDeletePostTagTermMutationPayloadObjectTypeResolver = $rootDeletePostTagTermMutationPayloadObjectTypeResolver;
    }
    final protected function getRootDeletePostTagTermMutationPayloadObjectTypeResolver(): RootDeletePostTagTermMutationPayloadObjectTypeResolver
    {
        if ($this->rootDeletePostTagTermMutationPayloadObjectTypeResolver === null) {
            /** @var RootDeletePostTagTermMutationPayloadObjectTypeResolver */
            $rootDeletePostTagTermMutationPayloadObjectTypeResolver = $this->instanceManager->getInstance(RootDeletePostTagTermMutationPayloadObjectTypeResolver::class);
            $this->rootDeletePostTagTermMutationPayloadObjectTypeResolver = $rootDeletePostTagTermMutationPayloadObjectTypeResolver;
        }
        return $this->rootDeletePostTagTermMutationPayloadObjectTypeResolver;
    }
    final public function setRootUpdatePostTagTermMutationPayloadObjectTypeResolver(RootUpdatePostTagTermMutationPayloadObjectTypeResolver $rootUpdatePostTagTermMutationPayloadObjectTypeResolver): void
    {
        $this->rootUpdatePostTagTermMutationPayloadObjectTypeResolver = $rootUpdatePostTagTermMutationPayloadObjectTypeResolver;
    }
    final protected function getRootUpdatePostTagTermMutationPayloadObjectTypeResolver(): RootUpdatePostTagTermMutationPayloadObjectTypeResolver
    {
        if ($this->rootUpdatePostTagTermMutationPayloadObjectTypeResolver === null) {
            /** @var RootUpdatePostTagTermMutationPayloadObjectTypeResolver */
            $rootUpdatePostTagTermMutationPayloadObjectTypeResolver = $this->instanceManager->getInstance(RootUpdatePostTagTermMutationPayloadObjectTypeResolver::class);
            $this->rootUpdatePostTagTermMutationPayloadObjectTypeResolver = $rootUpdatePostTagTermMutationPayloadObjectTypeResolver;
        }
        return $this->rootUpdatePostTagTermMutationPayloadObjectTypeResolver;
    }
    final public function setRootCreatePostTagTermMutationPayloadObjectTypeResolver(RootCreatePostTagTermMutationPayloadObjectTypeResolver $rootCreatePostTagTermMutationPayloadObjectTypeResolver): void
    {
        $this->rootCreatePostTagTermMutationPayloadObjectTypeResolver = $rootCreatePostTagTermMutationPayloadObjectTypeResolver;
    }
    final protected function getRootCreatePostTagTermMutationPayloadObjectTypeResolver(): RootCreatePostTagTermMutationPayloadObjectTypeResolver
    {
        if ($this->rootCreatePostTagTermMutationPayloadObjectTypeResolver === null) {
            /** @var RootCreatePostTagTermMutationPayloadObjectTypeResolver */
            $rootCreatePostTagTermMutationPayloadObjectTypeResolver = $this->instanceManager->getInstance(RootCreatePostTagTermMutationPayloadObjectTypeResolver::class);
            $this->rootCreatePostTagTermMutationPayloadObjectTypeResolver = $rootCreatePostTagTermMutationPayloadObjectTypeResolver;
        }
        return $this->rootCreatePostTagTermMutationPayloadObjectTypeResolver;
    }
    final public function setCreatePostTagTermMutationResolver(CreatePostTagTermMutationResolver $createPostTagTermMutationResolver): void
    {
        $this->createPostTagTermMutationResolver = $createPostTagTermMutationResolver;
    }
    final protected function getCreatePostTagTermMutationResolver(): CreatePostTagTermMutationResolver
    {
        if ($this->createPostTagTermMutationResolver === null) {
            /** @var CreatePostTagTermMutationResolver */
            $createPostTagTermMutationResolver = $this->instanceManager->getInstance(CreatePostTagTermMutationResolver::class);
            $this->createPostTagTermMutationResolver = $createPostTagTermMutationResolver;
        }
        return $this->createPostTagTermMutationResolver;
    }
    final public function setCreatePostTagTermBulkOperationMutationResolver(CreatePostTagTermBulkOperationMutationResolver $createPostTagTermBulkOperationMutationResolver): void
    {
        $this->createPostTagTermBulkOperationMutationResolver = $createPostTagTermBulkOperationMutationResolver;
    }
    final protected function getCreatePostTagTermBulkOperationMutationResolver(): CreatePostTagTermBulkOperationMutationResolver
    {
        if ($this->createPostTagTermBulkOperationMutationResolver === null) {
            /** @var CreatePostTagTermBulkOperationMutationResolver */
            $createPostTagTermBulkOperationMutationResolver = $this->instanceManager->getInstance(CreatePostTagTermBulkOperationMutationResolver::class);
            $this->createPostTagTermBulkOperationMutationResolver = $createPostTagTermBulkOperationMutationResolver;
        }
        return $this->createPostTagTermBulkOperationMutationResolver;
    }
    final public function setDeletePostTagTermMutationResolver(DeletePostTagTermMutationResolver $deletePostTagTermMutationResolver): void
    {
        $this->deletePostTagTermMutationResolver = $deletePostTagTermMutationResolver;
    }
    final protected function getDeletePostTagTermMutationResolver(): DeletePostTagTermMutationResolver
    {
        if ($this->deletePostTagTermMutationResolver === null) {
            /** @var DeletePostTagTermMutationResolver */
            $deletePostTagTermMutationResolver = $this->instanceManager->getInstance(DeletePostTagTermMutationResolver::class);
            $this->deletePostTagTermMutationResolver = $deletePostTagTermMutationResolver;
        }
        return $this->deletePostTagTermMutationResolver;
    }
    final public function setDeletePostTagTermBulkOperationMutationResolver(DeletePostTagTermBulkOperationMutationResolver $deletePostTagTermBulkOperationMutationResolver): void
    {
        $this->deletePostTagTermBulkOperationMutationResolver = $deletePostTagTermBulkOperationMutationResolver;
    }
    final protected function getDeletePostTagTermBulkOperationMutationResolver(): DeletePostTagTermBulkOperationMutationResolver
    {
        if ($this->deletePostTagTermBulkOperationMutationResolver === null) {
            /** @var DeletePostTagTermBulkOperationMutationResolver */
            $deletePostTagTermBulkOperationMutationResolver = $this->instanceManager->getInstance(DeletePostTagTermBulkOperationMutationResolver::class);
            $this->deletePostTagTermBulkOperationMutationResolver = $deletePostTagTermBulkOperationMutationResolver;
        }
        return $this->deletePostTagTermBulkOperationMutationResolver;
    }
    final public function setUpdatePostTagTermMutationResolver(UpdatePostTagTermMutationResolver $updatePostTagTermMutationResolver): void
    {
        $this->updatePostTagTermMutationResolver = $updatePostTagTermMutationResolver;
    }
    final protected function getUpdatePostTagTermMutationResolver(): UpdatePostTagTermMutationResolver
    {
        if ($this->updatePostTagTermMutationResolver === null) {
            /** @var UpdatePostTagTermMutationResolver */
            $updatePostTagTermMutationResolver = $this->instanceManager->getInstance(UpdatePostTagTermMutationResolver::class);
            $this->updatePostTagTermMutationResolver = $updatePostTagTermMutationResolver;
        }
        return $this->updatePostTagTermMutationResolver;
    }
    final public function setUpdatePostTagTermBulkOperationMutationResolver(UpdatePostTagTermBulkOperationMutationResolver $updatePostTagTermBulkOperationMutationResolver): void
    {
        $this->updatePostTagTermBulkOperationMutationResolver = $updatePostTagTermBulkOperationMutationResolver;
    }
    final protected function getUpdatePostTagTermBulkOperationMutationResolver(): UpdatePostTagTermBulkOperationMutationResolver
    {
        if ($this->updatePostTagTermBulkOperationMutationResolver === null) {
            /** @var UpdatePostTagTermBulkOperationMutationResolver */
            $updatePostTagTermBulkOperationMutationResolver = $this->instanceManager->getInstance(UpdatePostTagTermBulkOperationMutationResolver::class);
            $this->updatePostTagTermBulkOperationMutationResolver = $updatePostTagTermBulkOperationMutationResolver;
        }
        return $this->updatePostTagTermBulkOperationMutationResolver;
    }
    final public function setPayloadableDeletePostTagTermMutationResolver(PayloadableDeletePostTagTermMutationResolver $payloadableDeletePostTagTermMutationResolver): void
    {
        $this->payloadableDeletePostTagTermMutationResolver = $payloadableDeletePostTagTermMutationResolver;
    }
    final protected function getPayloadableDeletePostTagTermMutationResolver(): PayloadableDeletePostTagTermMutationResolver
    {
        if ($this->payloadableDeletePostTagTermMutationResolver === null) {
            /** @var PayloadableDeletePostTagTermMutationResolver */
            $payloadableDeletePostTagTermMutationResolver = $this->instanceManager->getInstance(PayloadableDeletePostTagTermMutationResolver::class);
            $this->payloadableDeletePostTagTermMutationResolver = $payloadableDeletePostTagTermMutationResolver;
        }
        return $this->payloadableDeletePostTagTermMutationResolver;
    }
    final public function setPayloadableDeletePostTagTermBulkOperationMutationResolver(PayloadableDeletePostTagTermBulkOperationMutationResolver $payloadableDeletePostTagTermBulkOperationMutationResolver): void
    {
        $this->payloadableDeletePostTagTermBulkOperationMutationResolver = $payloadableDeletePostTagTermBulkOperationMutationResolver;
    }
    final protected function getPayloadableDeletePostTagTermBulkOperationMutationResolver(): PayloadableDeletePostTagTermBulkOperationMutationResolver
    {
        if ($this->payloadableDeletePostTagTermBulkOperationMutationResolver === null) {
            /** @var PayloadableDeletePostTagTermBulkOperationMutationResolver */
            $payloadableDeletePostTagTermBulkOperationMutationResolver = $this->instanceManager->getInstance(PayloadableDeletePostTagTermBulkOperationMutationResolver::class);
            $this->payloadableDeletePostTagTermBulkOperationMutationResolver = $payloadableDeletePostTagTermBulkOperationMutationResolver;
        }
        return $this->payloadableDeletePostTagTermBulkOperationMutationResolver;
    }
    final public function setPayloadableUpdatePostTagTermMutationResolver(PayloadableUpdatePostTagTermMutationResolver $payloadableUpdatePostTagTermMutationResolver): void
    {
        $this->payloadableUpdatePostTagTermMutationResolver = $payloadableUpdatePostTagTermMutationResolver;
    }
    final protected function getPayloadableUpdatePostTagTermMutationResolver(): PayloadableUpdatePostTagTermMutationResolver
    {
        if ($this->payloadableUpdatePostTagTermMutationResolver === null) {
            /** @var PayloadableUpdatePostTagTermMutationResolver */
            $payloadableUpdatePostTagTermMutationResolver = $this->instanceManager->getInstance(PayloadableUpdatePostTagTermMutationResolver::class);
            $this->payloadableUpdatePostTagTermMutationResolver = $payloadableUpdatePostTagTermMutationResolver;
        }
        return $this->payloadableUpdatePostTagTermMutationResolver;
    }
    final public function setPayloadableUpdatePostTagTermBulkOperationMutationResolver(PayloadableUpdatePostTagTermBulkOperationMutationResolver $payloadableUpdatePostTagTermBulkOperationMutationResolver): void
    {
        $this->payloadableUpdatePostTagTermBulkOperationMutationResolver = $payloadableUpdatePostTagTermBulkOperationMutationResolver;
    }
    final protected function getPayloadableUpdatePostTagTermBulkOperationMutationResolver(): PayloadableUpdatePostTagTermBulkOperationMutationResolver
    {
        if ($this->payloadableUpdatePostTagTermBulkOperationMutationResolver === null) {
            /** @var PayloadableUpdatePostTagTermBulkOperationMutationResolver */
            $payloadableUpdatePostTagTermBulkOperationMutationResolver = $this->instanceManager->getInstance(PayloadableUpdatePostTagTermBulkOperationMutationResolver::class);
            $this->payloadableUpdatePostTagTermBulkOperationMutationResolver = $payloadableUpdatePostTagTermBulkOperationMutationResolver;
        }
        return $this->payloadableUpdatePostTagTermBulkOperationMutationResolver;
    }
    final public function setPayloadableCreatePostTagTermMutationResolver(PayloadableCreatePostTagTermMutationResolver $payloadableCreatePostTagTermMutationResolver): void
    {
        $this->payloadableCreatePostTagTermMutationResolver = $payloadableCreatePostTagTermMutationResolver;
    }
    final protected function getPayloadableCreatePostTagTermMutationResolver(): PayloadableCreatePostTagTermMutationResolver
    {
        if ($this->payloadableCreatePostTagTermMutationResolver === null) {
            /** @var PayloadableCreatePostTagTermMutationResolver */
            $payloadableCreatePostTagTermMutationResolver = $this->instanceManager->getInstance(PayloadableCreatePostTagTermMutationResolver::class);
            $this->payloadableCreatePostTagTermMutationResolver = $payloadableCreatePostTagTermMutationResolver;
        }
        return $this->payloadableCreatePostTagTermMutationResolver;
    }
    final public function setPayloadableCreatePostTagTermBulkOperationMutationResolver(PayloadableCreatePostTagTermBulkOperationMutationResolver $payloadableCreatePostTagTermBulkOperationMutationResolver): void
    {
        $this->payloadableCreatePostTagTermBulkOperationMutationResolver = $payloadableCreatePostTagTermBulkOperationMutationResolver;
    }
    final protected function getPayloadableCreatePostTagTermBulkOperationMutationResolver(): PayloadableCreatePostTagTermBulkOperationMutationResolver
    {
        if ($this->payloadableCreatePostTagTermBulkOperationMutationResolver === null) {
            /** @var PayloadableCreatePostTagTermBulkOperationMutationResolver */
            $payloadableCreatePostTagTermBulkOperationMutationResolver = $this->instanceManager->getInstance(PayloadableCreatePostTagTermBulkOperationMutationResolver::class);
            $this->payloadableCreatePostTagTermBulkOperationMutationResolver = $payloadableCreatePostTagTermBulkOperationMutationResolver;
        }
        return $this->payloadableCreatePostTagTermBulkOperationMutationResolver;
    }
    final public function setRootDeleteTagTermInputObjectTypeResolver(RootDeleteTagTermInputObjectTypeResolver $rootDeleteTagTermInputObjectTypeResolver): void
    {
        $this->rootDeleteTagTermInputObjectTypeResolver = $rootDeleteTagTermInputObjectTypeResolver;
    }
    final protected function getRootDeleteTagTermInputObjectTypeResolver(): RootDeleteTagTermInputObjectTypeResolver
    {
        if ($this->rootDeleteTagTermInputObjectTypeResolver === null) {
            /** @var RootDeleteTagTermInputObjectTypeResolver */
            $rootDeleteTagTermInputObjectTypeResolver = $this->instanceManager->getInstance(RootDeleteTagTermInputObjectTypeResolver::class);
            $this->rootDeleteTagTermInputObjectTypeResolver = $rootDeleteTagTermInputObjectTypeResolver;
        }
        return $this->rootDeleteTagTermInputObjectTypeResolver;
    }
    final public function setRootUpdateTagTermInputObjectTypeResolver(RootUpdateTagTermInputObjectTypeResolver $rootUpdateTagTermInputObjectTypeResolver): void
    {
        $this->rootUpdateTagTermInputObjectTypeResolver = $rootUpdateTagTermInputObjectTypeResolver;
    }
    final protected function getRootUpdateTagTermInputObjectTypeResolver(): RootUpdateTagTermInputObjectTypeResolver
    {
        if ($this->rootUpdateTagTermInputObjectTypeResolver === null) {
            /** @var RootUpdateTagTermInputObjectTypeResolver */
            $rootUpdateTagTermInputObjectTypeResolver = $this->instanceManager->getInstance(RootUpdateTagTermInputObjectTypeResolver::class);
            $this->rootUpdateTagTermInputObjectTypeResolver = $rootUpdateTagTermInputObjectTypeResolver;
        }
        return $this->rootUpdateTagTermInputObjectTypeResolver;
    }
    final public function setRootCreateTagTermInputObjectTypeResolver(RootCreateTagTermInputObjectTypeResolver $rootCreateTagTermInputObjectTypeResolver): void
    {
        $this->rootCreateTagTermInputObjectTypeResolver = $rootCreateTagTermInputObjectTypeResolver;
    }
    final protected function getRootCreateTagTermInputObjectTypeResolver(): RootCreateTagTermInputObjectTypeResolver
    {
        if ($this->rootCreateTagTermInputObjectTypeResolver === null) {
            /** @var RootCreateTagTermInputObjectTypeResolver */
            $rootCreateTagTermInputObjectTypeResolver = $this->instanceManager->getInstance(RootCreateTagTermInputObjectTypeResolver::class);
            $this->rootCreateTagTermInputObjectTypeResolver = $rootCreateTagTermInputObjectTypeResolver;
        }
        return $this->rootCreateTagTermInputObjectTypeResolver;
    }
    final public function setUserLoggedInCheckpoint(UserLoggedInCheckpoint $userLoggedInCheckpoint): void
    {
        $this->userLoggedInCheckpoint = $userLoggedInCheckpoint;
    }
    final protected function getUserLoggedInCheckpoint(): UserLoggedInCheckpoint
    {
        if ($this->userLoggedInCheckpoint === null) {
            /** @var UserLoggedInCheckpoint */
            $userLoggedInCheckpoint = $this->instanceManager->getInstance(UserLoggedInCheckpoint::class);
            $this->userLoggedInCheckpoint = $userLoggedInCheckpoint;
        }
        return $this->userLoggedInCheckpoint;
    }
    final public function setBooleanScalarTypeResolver(BooleanScalarTypeResolver $booleanScalarTypeResolver): void
    {
        $this->booleanScalarTypeResolver = $booleanScalarTypeResolver;
    }
    final protected function getBooleanScalarTypeResolver(): BooleanScalarTypeResolver
    {
        if ($this->booleanScalarTypeResolver === null) {
            /** @var BooleanScalarTypeResolver */
            $booleanScalarTypeResolver = $this->instanceManager->getInstance(BooleanScalarTypeResolver::class);
            $this->booleanScalarTypeResolver = $booleanScalarTypeResolver;
        }
        return $this->booleanScalarTypeResolver;
    }

    /**
     * @return array<class-string<ObjectTypeResolverInterface>>
     */
    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            RootObjectTypeResolver::class,
        ];
    }

    /**
     * @return string[]
     */
    public function getFieldNamesToResolve(): array
    {
        /** @var EngineModuleConfiguration */
        $engineModuleConfiguration = App::getModule(EngineModule::class)->getConfiguration();
        $disableRedundantRootTypeMutationFields = $engineModuleConfiguration->disableRedundantRootTypeMutationFields();
        /** @var ModuleConfiguration */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        $addFieldsToQueryPayloadableTagMutations = $moduleConfiguration->addFieldsToQueryPayloadableTagMutations();
        return array_merge(
            [
                'createPostTag',
                'createPostTags',
            ],
            !$disableRedundantRootTypeMutationFields ? [
                'updatePostTag',
                'updatePostTags',
                'deletePostTag',
                'deletePostTags',
            ] : [],
            $addFieldsToQueryPayloadableTagMutations ? [
                'createPostTagMutationPayloadObjects',
            ] : [],
            $addFieldsToQueryPayloadableTagMutations && !$disableRedundantRootTypeMutationFields ? [
                'updatePostTagMutationPayloadObjects',
                'deletePostTagMutationPayloadObjects',
            ] : [],
        );
    }

    public function getFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        return match ($fieldName) {
            'createPostTag' => $this->__('Create a post tag', 'tag-mutations'),
            'createPostTags' => $this->__('Create post tags', 'tag-mutations'),
            'updatePostTag' => $this->__('Update a post tag', 'tag-mutations'),
            'updatePostTags' => $this->__('Update post tags', 'tag-mutations'),
            'deletePostTag' => $this->__('Delete a post tag', 'tag-mutations'),
            'deletePostTags' => $this->__('Delete post tags', 'tag-mutations'),
            'createPostTagMutationPayloadObjects' => $this->__('Retrieve the payload objects from a recently-executed `createPostTag` mutation', 'tag-mutations'),
            'updatePostTagMutationPayloadObjects' => $this->__('Retrieve the payload objects from a recently-executed `updatePostTag` mutation', 'tag-mutations'),
            'deletePostTagMutationPayloadObjects' => $this->__('Retrieve the payload objects from a recently-executed `deletePostTag` mutation', 'tag-mutations'),
            default => parent::getFieldDescription($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): int
    {
        /** @var ModuleConfiguration */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        $usePayloadableTagMutations = $moduleConfiguration->usePayloadableTagMutations();
        if (!$usePayloadableTagMutations) {
            return match ($fieldName) {
                'createPostTag',
                'updatePostTag',
                'deletePostTag'
                    => SchemaTypeModifiers::NONE,
                'createPostTags',
                'updatePostTags',
                'deletePostTags'
                    => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY,
                default
                    => parent::getFieldTypeModifiers($objectTypeResolver, $fieldName),
            };
        }

        if (
            in_array($fieldName, [
            'createPostTagMutationPayloadObjects',
            'updatePostTagMutationPayloadObjects',
            'deletePostTagMutationPayloadObjects',
            ])
        ) {
            return $this->getMutationPayloadObjectsFieldTypeModifiers();
        }

        return match ($fieldName) {
            'createPostTag',
            'updatePostTag',
            'deletePostTag'
                => SchemaTypeModifiers::NON_NULLABLE,
            'createPostTags',
            'updatePostTags',
            'deletePostTags'
                => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY | SchemaTypeModifiers::IS_NON_NULLABLE_ITEMS_IN_ARRAY,
            default
                => parent::getFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    /**
     * @return array<string,InputTypeResolverInterface>
     */
    public function getFieldArgNameTypeResolvers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): array
    {
        return match ($fieldName) {
            'createPostTag' => [
                'input' => $this->getRootCreateTagTermInputObjectTypeResolver(),
            ],
            'createPostTags'
                => $this->getBulkOperationFieldArgNameTypeResolvers($this->getRootCreateTagTermInputObjectTypeResolver()),
            'updatePostTag' => [
                'input' => $this->getRootUpdateTagTermInputObjectTypeResolver(),
            ],
            'updatePostTags'
                => $this->getBulkOperationFieldArgNameTypeResolvers($this->getRootUpdateTagTermInputObjectTypeResolver()),
            'deletePostTag' => [
                'input' => $this->getRootDeleteTagTermInputObjectTypeResolver(),
            ],
            'deletePostTags'
                => $this->getBulkOperationFieldArgNameTypeResolvers($this->getRootDeleteTagTermInputObjectTypeResolver()),
            'createPostTagMutationPayloadObjects',
            'updatePostTagMutationPayloadObjects',
            'deletePostTagMutationPayloadObjects'
                => $this->getMutationPayloadObjectsFieldArgNameTypeResolvers(),
            default
                => parent::getFieldArgNameTypeResolvers($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldArgTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName, string $fieldArgName): int
    {
        if (
            in_array($fieldName, [
            'createPostTagMutationPayloadObjects',
            'updatePostTagMutationPayloadObjects',
            'deletePostTagMutationPayloadObjects',
            ])
        ) {
            return $this->getMutationPayloadObjectsFieldArgTypeModifiers($fieldArgName)
                ?? parent::getFieldArgTypeModifiers($objectTypeResolver, $fieldName, $fieldArgName);
        }

        if (
            in_array($fieldName, [
            'createPostTags',
            'updatePostTags',
            'deletePostTags',
            ])
        ) {
            return $this->getBulkOperationFieldArgTypeModifiers($fieldArgName)
                ?? parent::getFieldArgTypeModifiers($objectTypeResolver, $fieldName, $fieldArgName);
        }

        return match ([$fieldName => $fieldArgName]) {
            ['createPostTag' => 'input'],
            ['updatePostTag' => 'input'],
            ['deletePostTag' => 'input']
                => SchemaTypeModifiers::MANDATORY,
            default => parent::getFieldArgTypeModifiers($objectTypeResolver, $fieldName, $fieldArgName),
        };
    }

    public function getFieldArgDefaultValue(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName, string $fieldArgName): mixed
    {
        if (
            in_array($fieldName, [
            'createPostTags',
            'updatePostTags',
            'deletePostTags',
            ])
        ) {
            return $this->getBulkOperationFieldArgDefaultValue($fieldArgName)
                ?? parent::getFieldArgDefaultValue($objectTypeResolver, $fieldName, $fieldArgName);
        }

        return parent::getFieldArgDefaultValue($objectTypeResolver, $fieldName, $fieldArgName);
    }

    public function getFieldMutationResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?MutationResolverInterface
    {
        /** @var ModuleConfiguration */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        $usePayloadableTagMutations = $moduleConfiguration->usePayloadableTagMutations();
        return match ($fieldName) {
            'createPostTag' => $usePayloadableTagMutations
                ? $this->getPayloadableCreatePostTagTermMutationResolver()
                : $this->getCreatePostTagTermMutationResolver(),
            'createPostTags' => $usePayloadableTagMutations
                ? $this->getPayloadableCreatePostTagTermBulkOperationMutationResolver()
                : $this->getCreatePostTagTermBulkOperationMutationResolver(),
            'updatePostTag' => $usePayloadableTagMutations
                ? $this->getPayloadableUpdatePostTagTermMutationResolver()
                : $this->getUpdatePostTagTermMutationResolver(),
            'updatePostTags' => $usePayloadableTagMutations
                ? $this->getPayloadableUpdatePostTagTermBulkOperationMutationResolver()
                : $this->getUpdatePostTagTermBulkOperationMutationResolver(),
            'deletePostTag' => $usePayloadableTagMutations
                ? $this->getPayloadableDeletePostTagTermMutationResolver()
                : $this->getDeletePostTagTermMutationResolver(),
            'deletePostTags' => $usePayloadableTagMutations
                ? $this->getPayloadableDeletePostTagTermBulkOperationMutationResolver()
                : $this->getDeletePostTagTermBulkOperationMutationResolver(),
            default => parent::getFieldMutationResolver($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldTypeResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ConcreteTypeResolverInterface
    {
        /** @var ModuleConfiguration */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        $usePayloadableTagMutations = $moduleConfiguration->usePayloadableTagMutations();
        if ($usePayloadableTagMutations) {
            return match ($fieldName) {
                'createPostTag',
                'createPostTags',
                'createPostTagMutationPayloadObjects'
                    => $this->getRootCreatePostTagTermMutationPayloadObjectTypeResolver(),
                'updatePostTag',
                'updatePostTags',
                'updatePostTagMutationPayloadObjects'
                    => $this->getRootUpdatePostTagTermMutationPayloadObjectTypeResolver(),
                'deletePostTag',
                'deletePostTags',
                'deletePostTagMutationPayloadObjects'
                    => $this->getRootDeletePostTagTermMutationPayloadObjectTypeResolver(),
                default => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
            };
        }
        return match ($fieldName) {
            'createPostTag',
            'createPostTags',
            'updatePostTag',
            'updatePostTags'
                => $this->getPostTagObjectTypeResolver(),
            'deletePostTag',
            'deletePostTags'
                => $this->getBooleanScalarTypeResolver(),
            default
                => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
        };
    }

    /**
     * @return CheckpointInterface[]
     */
    public function getValidationCheckpoints(
        ObjectTypeResolverInterface $objectTypeResolver,
        FieldDataAccessorInterface $fieldDataAccessor,
        object $object,
    ): array {
        $validationCheckpoints = parent::getValidationCheckpoints(
            $objectTypeResolver,
            $fieldDataAccessor,
            $object,
        );

        /**
         * For Payloadable: The "User Logged-in" checkpoint validation is not added,
         * instead this validation is executed inside the mutation, so the error
         * shows up in the Payload
         *
         * @var ModuleConfiguration
         */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        $usePayloadableTagMutations = $moduleConfiguration->usePayloadableTagMutations();
        if ($usePayloadableTagMutations) {
            return $validationCheckpoints;
        }

        switch ($fieldDataAccessor->getFieldName()) {
            case 'createPostTag':
            case 'createPostTags':
            case 'updatePostTag':
            case 'updatePostTags':
            case 'deletePostTag':
            case 'deletePostTags':
                $validationCheckpoints[] = $this->getUserLoggedInCheckpoint();
                break;
        }
        return $validationCheckpoints;
    }

    public function resolveValue(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $object,
        FieldDataAccessorInterface $fieldDataAccessor,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): mixed {
        $fieldName = $fieldDataAccessor->getFieldName();
        switch ($fieldName) {
            case 'createPostTagMutationPayloadObjects':
            case 'updatePostTagMutationPayloadObjects':
            case 'deletePostTagMutationPayloadObjects':
                return $this->resolveMutationPayloadObjectsValue(
                    $objectTypeResolver,
                    $fieldDataAccessor,
                );
        }

        return parent::resolveValue($objectTypeResolver, $object, $fieldDataAccessor, $objectTypeFieldResolutionFeedbackStore);
    }
}
