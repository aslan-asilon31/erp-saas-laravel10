<?php

namespace App\Models\Setting;

use App\Casts\RateCast;
use App\Enums\DiscountComputation;
use App\Enums\DiscountScope;
use App\Enums\DiscountType;
use App\Traits\Blamable;
use App\Traits\CompanyOwned;
use App\Traits\HasDefault;
use App\Traits\SyncsWithCompanyDefaults;
use Database\Factories\Setting\DiscountFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Wallo\FilamentCompanies\FilamentCompanies;

class Discount extends Model
{
    use Blamable;
    use CompanyOwned;
    use HasDefault;
    use HasFactory;
    use SyncsWithCompanyDefaults;

    protected $table = 'discounts';

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'rate',
        'computation',
        'type',
        'scope',
        'start_date',
        'end_date',
        'enabled',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'rate' => RateCast::class,
        'computation' => DiscountComputation::class,
        'type' => DiscountType::class,
        'scope' => DiscountScope::class,
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'enabled' => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(FilamentCompanies::companyModel(), 'company_id');
    }

    public function defaultSalesDiscount(): HasOne
    {
        return $this->hasOne(CompanyDefault::class, 'sales_discount_id');
    }

    public function defaultPurchaseDiscount(): HasOne
    {
        return $this->hasOne(CompanyDefault::class, 'purchase_discount_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(FilamentCompanies::userModel(), 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(FilamentCompanies::userModel(), 'updated_by');
    }

    protected static function newFactory(): Factory
    {
        return DiscountFactory::new();
    }
}
