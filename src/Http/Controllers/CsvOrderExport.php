<?php

namespace Vanilo\Admin\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CsvOrderExport
{
    public static function generate(Builder $orderQuery): string
    {
        DB::enableQueryLog();

        $filePath = base_path('/storage/app/orders_' . now()->timestamp . '.csv');
        $output = fopen($filePath, 'wb');

        fputcsv($output, self::getHeaders(), ';');

        $orderQuery->with(['shippingMethod', 'paymentMethod', 'channel', 'billpayer.address', 'shippingAddress'])
            ->chunk(1000, function (Collection $orders) use ($output) {
                $orders->each(function ($order) use ($output) {
                    fputcsv($output, self::mapOrderData($order), ';');
                });
            });

        fclose($output);

        return $filePath;
    }

    private static function mapOrderData(Model $order): array
    {
        return [
            'id' => $order->id,
            'number' => $order->number,
            'ordered_at' => $order->ordered_at ?? $order->created_at,
            'total' => $order->total,
            'taxes_total' => $order->taxes_total,
            'shipping_total' => $order->shipping_total,
            'promotions_total' => $order->promotions_total,
            'currency' => $order->currency,
            'status' => $order->status,
            'fulfillment_status' => $order->fulfillment_status,
            'shipping_method' => $order->shippingMethod?->name,
            'payment_method' => $order->paymentMethod?->name,
            'language' => $order->language,
            'user_id' => $order->user_id,
            'notes' => $order->notes,
            'channel' => $order->channel?->slug,
            'via' => $order->via,
            'email' => $order->billpayer?->email,
            'phone' => $order->billpayer?->phone,
            'name' => $order->billpayer?->name ?? $order->billpayer?->firstname . ' ' . $order->billpayer?->lastname,
            'company_name' => $order->billpayer?->company_name,
            'tax_nr' => $order->billpayer?->tax_nr,
            'registration_nr' => $order->billpayer?->registration_nr,
            'country' => $order->billpayer?->address?->country_id,
            'postalcode' => $order->billpayer?->address?->postalcode,
            'city' => $order->billpayer?->address?->city,
            'address' => $order->billpayer?->address?->address,
            'address2' => $order->billpayer?->address?->address2,
            'shipping_name' => $order->shippingAddress?->name,
            'shipping_country' => $order->shippingAddress?->country_id,
            'shipping_postalcode' => $order->shippingAddress?->postalcode,
            'shipping_city' => $order->shippingAddress?->city,
            'shipping_address' => $order->shippingAddress?->address,
            'shipping_address2' => $order->shippingAddress?->address2,
            'shipping_email' => $order->shippingAddress?->email,
            'shipping_phone' => $order->shippingAddress?->phone,
        ];
    }

    private static function getHeaders(): array
    {
        return array_keys(self::mapOrderData(new class extends Model {
        }));
    }
}
