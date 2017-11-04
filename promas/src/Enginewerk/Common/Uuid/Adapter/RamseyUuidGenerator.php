<?php
namespace Enginewerk\Common\Uuid\Adapter;

use Ramsey\Uuid\Uuid;

class RamseyUuidGenerator implements UuidVersion4AdapterInterface
{
    public function generateV4(): string
    {
        return Uuid::uuid4();
    }
}
