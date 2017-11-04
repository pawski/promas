<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Repository;

use Enginewerk\Promas\PropertyBundle\Entity\Investment as InvestmentEntity;

interface InvestmentRepositoryInterface
{
    /**
     * @param InvestmentEntity $investment
     *
     * @return void
     */
    public function remove(InvestmentEntity $investment): void;

    /**
     * @param InvestmentEntity $investment
     *
     * @return void
     */
    public function persist(InvestmentEntity $investment): void;
}
