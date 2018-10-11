<?php

namespace Petlove\Domain\Catalog;

use Petlove\Domain\Security\Authorization\Authorization;

/**
 * Interface CatalogAuthorization
 * @package Petlove\Domain\Catalog
 */
interface CatalogAuthorization extends Authorization
{
    public function canManageCatalog(): bool;

    public function canAccessCatalog(): bool;
}
