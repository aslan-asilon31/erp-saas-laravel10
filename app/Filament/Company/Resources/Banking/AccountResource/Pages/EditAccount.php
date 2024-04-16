<?php

namespace App\Filament\Company\Resources\Banking\AccountResource\Pages;

use App\Filament\Company\Resources\Banking\AccountResource;
use App\Models\Banking\Account;
use App\Traits\HandlesResourceRecordUpdate;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EditAccount extends EditRecord
{
    use HandlesResourceRecordUpdate;

    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): ?string
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
    protected function handleRecordUpdate(Account | Model $record, array $data): Model | Account
    {
        $user = Auth::user();

        if (! $user) {
            throw new Halt('No authenticated user found.');
        }

        return $this->handleRecordUpdateWithUniqueField($record, $data, $user);
    }
}
