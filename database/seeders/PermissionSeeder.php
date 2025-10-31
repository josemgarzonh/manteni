<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Para evitar duplicados o conflictos, vaciamos la tabla pivote primero
        DB::table('permission_role')->truncate();

        // Lista completa de permisos granulares para la aplicación
        $permissions = [
            // Acciones Generales
            'report_failure',

            // Dashboard
            'view_dashboard', 'view_my_tasks',

            // Menú: Configuración
            'access_settings_menu', 'manage_ips', 'manage_sedes', 'manage_servicios', 'manage_zonas', 'manage_roles',

            // Menú: Seguridad
            'access_security_menu', 'manage_users',

            // Menú: Inventario
            'access_inventory_menu',
            'view_asset_types', 'manage_asset_types',
            'view_assets', 'create_asset', 'edit_asset', 'delete_asset',
            'view_asset_hoja_de_vida', 'edit_asset_hoja_de_vida', 'download_asset_hoja_de_vida_pdf',
            'view_asset_bitacora', 'add_asset_bitacora_entry', 'download_asset_bitacora_pdf',
            'evaluate_asset_disposal',
            'view_spare_part_requests', 'manage_spare_part_requests',

            // Menú: Operaciones
            'access_operations_menu',
            'view_maintenance_requests', 'assign_maintenance_requests',
            'manage_maintenance_reports',
            'manage_task_teams',
            'view_failures_list', 'attend_failures',

            // Menú: Cronogramas
            'manage_schedules',

            // Menú: Protocolos y Tests
            'access_protocols_menu', 'manage_hospital_rounds', 'manage_defibrillator_tests',
        ];

        // Crear cada permiso si no existe
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Asignar TODOS los permisos al rol de Super Administrador
        $superAdminRole = Role::where('nombre_rol', 'Super Administrador')->first();
        if ($superAdminRole) {
            $allPermissions = Permission::all();
            $superAdminRole->permissions()->sync($allPermissions->pluck('id'));
        }
    }
}