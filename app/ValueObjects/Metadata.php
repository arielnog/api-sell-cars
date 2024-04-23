<?php

namespace App\ValueObjects;

use App\Exceptions\InvalidArgumentException;
use App\Helpers\ErrorsListHelpers;
use App\Traits\Iterator;
use function PHPUnit\Framework\isEmpty;

final class Metadata
{
    use Iterator;

    private array $orderByData = [];
    private array $whereConditionData = [];

    public function __construct(
        private readonly int $limit,
        private readonly int $page
    )
    {
    }

    public function setOrderByData(array $orderByData): void
    {
        $this->orderByData = $orderByData;
    }

    public function setWhereConditionData(array $whereConditionData): void
    {
        $this->whereConditionData = $whereConditionData;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function orderByDataIsEmpty(): bool
    {
        return empty($this->orderByData);
    }

    public function whereConditionDataIsEmpty(): bool
    {
        return empty($this->whereConditionData);
    }

    public function getContentByWhereCondition(string $key)
    {
        return $this->whereConditionData[$key];
    }

    public function getContentByOrderBy(string $key)
    {
        return $this->orderByData[$key];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            limit: self::getData($data, 'limit') ?? 10,
            page: self::getData($data, 'page', 'per_page') ?? 1
        );
    }

    public static function prepareWithOrderAndWhereCondition(array $data): self
    {
        $metadata = self::fromArray($data);

        $metadata->setWhereConditionData(
            self::getData($data, 'where', 'where_condition') ?? []
        );

        $metadata->setOrderByData(
            self::getData($data, 'order_by', 'orderBy') ?? []
        );

        return $metadata;
    }

}
