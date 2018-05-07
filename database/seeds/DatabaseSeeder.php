<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([
            AccessStatusTableSeeder::class,
            AttendanceApprovalTableSeeder::class,
            AttendanceSettingTableSeeder::class,
            AttendanceValidationTableSeeder::class,
            BanksTableSeeder::class,
            BranchOfficesTableSeeder::class,
            CountriesTableSeeder::class,
            CurrenciesTableSeeder::class,
            DeliveryTermsTableSeeder::class,
            DivisionsTableSeeder::class,
            EducationLevelTableSeeder::class,
            JobPositionsTableSeeder::class,
            LeaveApprovalTableSeeder::class,
            LeaveTypeTableSeeder::class,
            MaritalStatusTableSeeder::class,
            NotificationGroupTypeTableSeeder::class,
            PaymentTermsTableSeeder::class,
            PayrollSettingTableSeeder::class,
            PermissionTableSeeder::class,
            RecruitmentStatusTableSeeder::class,
            ReligionsTableSeeder::class,
            ReportProblemTypeTableSeeder::class,
            RolesTableSeeder::class,
            SalaryBonusCutTypeSeeder::class,
            SalaryReportConfirmationStatusTableSeeder::class,
            ShiftTableSeeder::class,
            SlotMakerTableSeeder::class,
            SlotTableSeeder::class,
            StorageActionTypeSeeder::class,
            StorageItemCategoryTableSeeder::class,
            StorageItemStatusTableSeeder::class,
            StorageItemTestStatusTableSeeder::class,
            StorageItemTypesTableSeeder::class,
            StoragePurchaseOrderStatusTableSeeder::class,
            StorageRequisitionApprovalTableSeeder::class,
            UnitOfMeasurementsTableSeeder::class,
            UnitOfMeasurementTypeTableSeeder::class
        ]);
    }
}
