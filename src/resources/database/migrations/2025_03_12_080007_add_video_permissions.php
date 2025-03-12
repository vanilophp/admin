<?php

use Illuminate\Database\Migrations\Migration;
use Konekt\Acl\Models\PermissionProxy;
use Konekt\Acl\Models\RoleProxy;
use Konekt\Acl\PermissionRegistrar;
use Konekt\AppShell\Acl\ResourcePermissionMapper;

return new class extends Migration {
    private array $resources = ['video'];

    private ?ResourcePermissionMapper $mapper = null;

    public function up(): void
    {
        $adminRole = RoleProxy::where('name', 'admin')->first();

        foreach ($this->resources as $resource) {
            $permissions = $this->getPermissionsForResource($resource);

            foreach ($permissions as $permission) {
                PermissionProxy::create([
                    'name' => $permission
                ]);
            }

            if ($adminRole) {
                $adminRole->givePermissionTo(...$permissions);
            }
        }
    }

    public function down(): void
    {
        foreach ($this->resources as $resource) {
            foreach ($this->getPermissionsForResource($resource) as $permissionName) {
                PermissionProxy::where(['name' => $permissionName])->delete();
            }
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function getPermissionsForResource(string $resource): array
    {
        return $this->mapper()->allPermissionsFor($resource);
    }

    private function mapper(): ResourcePermissionMapper
    {
        if (!$this->mapper) {
            $this->mapper = new ResourcePermissionMapper();
        }

        return $this->mapper;
    }
};
