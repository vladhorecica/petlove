<?php

namespace Petlove\Domain\Catalog;

use Petlove\Domain\Security\Authorization\Authorization;

interface CatalogAuthorization extends Authorization
{
    public function canManageCatalog(): bool;

    public function canAccessCatalog(): bool;
}
