<?php

namespace App\Filament\Owner\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DailyRevenueChartWidget extends ChartWidget
{
    protected ?string $heading = 'Daily Revenue (Last 7 Days)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $startDate = Carbon::today()->subDays(6);
        $endDate = Carbon::today();

        // Get daily revenue
        $revenues = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $labels = [];
        $data = [];

        // Fill in missing days
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($date)->format('D, M d');
            $data[] = $revenues->has($date) ? $revenues[$date]->total : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (Rp)',
                    'data' => $data,
                    'backgroundColor' => '#f97316', // Orange-500
                    'borderColor' => '#ea580c', // Orange-600
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
