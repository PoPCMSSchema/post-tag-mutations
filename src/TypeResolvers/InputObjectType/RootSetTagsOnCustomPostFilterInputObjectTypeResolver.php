<?php

declare(strict_types=1);

namespace PoPCMSSchema\PostTagMutations\TypeResolvers\InputObjectType;

class RootSetTagsOnCustomPostFilterInputObjectTypeResolver extends AbstractSetTagsOnPostFilterInputObjectTypeResolver
{
    public function getTypeName(): string
    {
        return 'RootSetTagsOnCustomPostFilterInput';
    }

    protected function addCustomPostInputField(): bool
    {
        return true;
    }
}
