<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [
            'المستخدمين',
            'قائمة المستخدمين',
            'صلاحيات المستخدمين',

            'اضافة مستخدم',
            'تعديل مستخدم',
            'حذف مستخدم',

            'عرض صلاحية',
            'اضافة صلاحية',
            'تعديل صلاحية',
            'حذف صلاحية',

            'التصنيفات',
            'إدارةالتصنيفات',
            'اضافة تصنيف',
            'تعديل تصنيف',
            'حذف تصنيف',

            'الكورسات',
            'إدارةالكورسات',
            'اضافة كورس',
            'تعديل كورس',
            'حذف كورس',

            'الطلاب',
            'إدارةالطلاب',
            'إدارة تسجيل الطلاب',
            
            'اضافة طالب',
            'تعديل طالب',
            'حذف طالب',

            'تسجيل طالب',
            'تعديل تسجيل الطالب',
            'حذف تسجيل الطالب',

            'المدربيين',
            'إدارة المدربيين',
            'اضافة مدرب',
            'تعديل مدرب',
            'حذف مدرب',

            'الملف الشخصي',
            'الكورسات المسجلة',
            'تسجيل كورس',
            'حذف تسجيل',

        ];

        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }
    }
}
