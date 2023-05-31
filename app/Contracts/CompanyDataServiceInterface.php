<?php

namespace App\Contracts;

use App\Exceptions\FetchCompanyDataException;

/**
 * Interface CompanyDataServiceInterface
 *
 * This interface defines the contract for a Company data service,
 * which fetch Company
 *
 */

interface CompanyDataServiceInterface
{
    /**
     * Get company data.
     *
     * @return array
     * @throws FetchCompanyDataException if there is an error fetching the company data.
     */
    public function getCompanyData();
}
