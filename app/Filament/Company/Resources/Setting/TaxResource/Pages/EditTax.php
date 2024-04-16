<?php

namespace App\Filament\Company\Resources\Setting\TaxResource\Pages;

use App\Enums\TaxType;
use App\Filament\Company\Resources\Setting\TaxResource;
use App\Traits\HandlesResourceRecordUpdate;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;

class EditTax extends EditRecord
{
    use HandlesResourceRecordUpdate;

    protected static string $resource = TaxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['enabled'] = (bool) $data['enabled'];

        return $data;
    }

    /**
     * @throws Halt
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $user = auth()->user();

        if (! $user) {
            throw new Halt('No authenticated user found');
        }

        $evaluatedTypes = [TaxType::Sales, TaxType::Purchase];

        return $this->handleRecordUpdateWithUniqueField($record, $data, $user, 'type', $evaluatedTypes);
    }
}
