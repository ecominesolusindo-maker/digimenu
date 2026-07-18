<?php

namespace App\Filament\Owner\Resources\Payments\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order.order_number')->label('Order Number'),
                TextInput::make('amount')->numeric(),
                TextInput::make('payment_method'),
                TextInput::make('status'),
                DateTimePicker::make('created_at')->label('Payment Time'),
            ])->disabled();
    }
}
