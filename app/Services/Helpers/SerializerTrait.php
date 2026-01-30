<?php

declare(strict_types=1);

namespace App\Services\Helpers;

trait SerializerTrait
{
    public function toArray($source = null): array
    {
        $source   = $source ?? get_object_vars($this);
        $filtered = array_filter($source, function ($value) {
            return !is_null($value);
        });
        return array_map(
            function ($value) {
                if (is_object($value)) {
                    if (!method_exists($value, 'toArray')) {
                        return array($value);
                    }
                    return $value->toArray();
                }
                if (is_array($value)) {
                    return $this->toArray($value);
                }

                return $value;
            },
            $filtered
        );
    }
}
