<?php

namespace Modules\Core\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;

class TaxGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('accounts_taxes')->delete();

        DB::table('accounts_tax_groups')->delete();

        $user = User::first();

        $company = Company::first();

        $now = Carbon::now();

        $taxGroups = [
            [
                'id'                 => 1,
                'sort'               => 1,
                'company_id'         => $company?->id,
                'country_id'         => 104,
                'creator_id'         => $user?->id,
                'name'               => 'Tax 15%',
                'preceding_subtotal' => null,
                'created_at'         => $now,
                'updated_at'         => $now,
            ],
        ];

        DB::table('accounts_tax_groups')->insert($taxGroups);
    }
}
