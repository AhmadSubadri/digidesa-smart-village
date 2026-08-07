<?php

namespace Database\Seeders;

use App\Models\BudgetPeriod;
use App\Models\BudgetItem;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        // APBKal 2025
        $period2025 = BudgetPeriod::firstOrCreate(
            ['fiscal_year' => 2025],
            [
                'title' => 'APBKal Condongcatur Tahun Anggaran 2025',
                'status' => 'active',
                'total_income' => 3_850_000_000,
                'total_expense' => 3_780_000_000,
                'total_financing' => 70_000_000,
            ]
        );

        // Income items
        $incomeItems = [
            ['code' => '1.1', 'category' => 'Pendapatan Asli Kalurahan', 'sub_category' => null, 'item_name' => 'Hasil Usaha BUMKal', 'planned_amount' => 150_000_000, 'realized_amount' => 125_000_000, 'sort_order' => 1],
            ['code' => '1.2', 'category' => 'Pendapatan Asli Kalurahan', 'sub_category' => null, 'item_name' => 'Hasil Aset Kalurahan', 'planned_amount' => 50_000_000, 'realized_amount' => 45_000_000, 'sort_order' => 2],
            ['code' => '2.1', 'category' => 'Transfer', 'sub_category' => 'Dana Desa', 'item_name' => 'Dana Desa (APBN)', 'planned_amount' => 1_500_000_000, 'realized_amount' => 1_500_000_000, 'sort_order' => 3],
            ['code' => '2.2', 'category' => 'Transfer', 'sub_category' => 'Alokasi Dana Desa', 'item_name' => 'ADD (APBD Kabupaten)', 'planned_amount' => 900_000_000, 'realized_amount' => 900_000_000, 'sort_order' => 4],
            ['code' => '2.3', 'category' => 'Transfer', 'sub_category' => 'Bantuan Keuangan', 'item_name' => 'Bantuan Keuangan Kabupaten', 'planned_amount' => 750_000_000, 'realized_amount' => 600_000_000, 'sort_order' => 5],
            ['code' => '2.4', 'category' => 'Transfer', 'sub_category' => 'Bantuan Keuangan', 'item_name' => 'Bantuan Keuangan Provinsi', 'planned_amount' => 500_000_000, 'realized_amount' => 500_000_000, 'sort_order' => 6],
        ];

        foreach ($incomeItems as $item) {
            BudgetItem::firstOrCreate(
                ['budget_period_id' => $period2025->id, 'code' => $item['code'], 'type' => 'income'],
                array_merge($item, [
                    'budget_period_id' => $period2025->id,
                    'type' => 'income',
                    'revised_amount' => $item['planned_amount'],
                    'percentage' => $item['planned_amount'] > 0 ? round($item['realized_amount'] / $item['planned_amount'] * 100, 2) : 0,
                ])
            );
        }

        // Expense items
        $expenseItems = [
            ['code' => '2.1.1', 'category' => 'Penyelenggaraan Pemerintahan', 'sub_category' => 'Belanja Pegawai', 'item_name' => 'Penghasilan Tetap Pamong Kalurahan', 'planned_amount' => 800_000_000, 'realized_amount' => 650_000_000, 'sort_order' => 1],
            ['code' => '2.1.2', 'category' => 'Penyelenggaraan Pemerintahan', 'sub_category' => 'Operasional', 'item_name' => 'Operasional Kantor Kalurahan', 'planned_amount' => 200_000_000, 'realized_amount' => 165_000_000, 'sort_order' => 2],
            ['code' => '2.2.1', 'category' => 'Pembangunan', 'sub_category' => 'Infrastruktur', 'item_name' => 'Pembangunan & Pemeliharaan Jalan', 'planned_amount' => 750_000_000, 'realized_amount' => 720_000_000, 'sort_order' => 3],
            ['code' => '2.2.2', 'category' => 'Pembangunan', 'sub_category' => 'Infrastruktur', 'item_name' => 'Pembangunan Saluran Irigasi', 'planned_amount' => 400_000_000, 'realized_amount' => 380_000_000, 'sort_order' => 4],
            ['code' => '2.2.3', 'category' => 'Pembangunan', 'sub_category' => 'Infrastruktur', 'item_name' => 'Rehabilitasi Balai Padukuhan', 'planned_amount' => 300_000_000, 'realized_amount' => 290_000_000, 'sort_order' => 5],
            ['code' => '2.3.1', 'category' => 'Pemberdayaan Masyarakat', 'sub_category' => 'Sosial', 'item_name' => 'BLT Dana Desa', 'planned_amount' => 450_000_000, 'realized_amount' => 450_000_000, 'sort_order' => 6],
            ['code' => '2.3.2', 'category' => 'Pemberdayaan Masyarakat', 'sub_category' => 'Kesehatan', 'item_name' => 'Posyandu & Stunting', 'planned_amount' => 180_000_000, 'realized_amount' => 125_000_000, 'sort_order' => 7],
            ['code' => '2.4.1', 'category' => 'Penanggulangan Bencana', 'sub_category' => 'Tanggap Darurat', 'item_name' => 'Cadangan Bencana', 'planned_amount' => 100_000_000, 'realized_amount' => 0, 'sort_order' => 8],
        ];

        foreach ($expenseItems as $item) {
            BudgetItem::firstOrCreate(
                ['budget_period_id' => $period2025->id, 'code' => $item['code'], 'type' => 'expense'],
                array_merge($item, [
                    'budget_period_id' => $period2025->id,
                    'type' => 'expense',
                    'revised_amount' => $item['planned_amount'],
                    'percentage' => $item['planned_amount'] > 0 ? round($item['realized_amount'] / $item['planned_amount'] * 100, 2) : 0,
                ])
            );
        }
    }
}
