<?php

namespace App\Casts;

use App\Utilities\Currency\CurrencyAccessor;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use UnexpectedValueException;

class MoneyCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        $currency_code = $model->getAttribute('currency_code');

        return $value ? money($value, $currency_code)->formatSimple() : '';
    }

    /**
     * @throws UnexpectedValueException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        if (is_int($value)) {
            return $value;
        }

        $currency_code = $model->getAttribute('currency_code') ?? CurrencyAccessor::getDefaultCurrency();

        if (! $currency_code) {
            throw new UnexpectedValueException('Currency code is not set');
        }

        return money($value, $currency_code, true)->getAmount();
    }
}
