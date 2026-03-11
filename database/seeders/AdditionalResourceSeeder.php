<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdditionalResourceSeeder extends Seeder
{
    public function run(): void
    {
        $manager = User::where('role', 'responsable')->first();
        $managerId = $manager ? $manager->id : null;

        // Format: [Name, Type, CPU, RAM, Category, Rack, Status]
        $serverTypes = [
            ['DB-Primary-01', 'Serveur', 64, 256, 'Database', 'U10', 'disponible'],
            ['Web-Front-01', 'Serveur', 16, 32, 'Web', 'U11', 'disponible'],
            ['Web-Front-02', 'Serveur', 16, 32, 'Web', 'U12', 'maintenance'],
            ['App-Core-01', 'Serveur', 32, 64, 'App', 'U13', 'disponible'],
            ['Backup-Sys-01', 'Serveur', 8, 16, 'Backup', 'Tower', 'disponible'],
            ['NAS-Storage-01', 'Stockage', 4, 16, 'NAS', 'U20', 'disponible'],
            ['NAS-Storage-02', 'Stockage', 4, 16, 'NAS', 'U21', 'maintenance'],
            ['Compute-Node-01', 'Serveur', 48, 128, 'Compute', 'U14', 'disponible'],
            ['Compute-Node-02', 'Serveur', 48, 128, 'Compute', 'U15', 'maintenance'],
            ['Dev-Env-01', 'Serveur', 16, 32, 'Dev', 'U05', 'disponible'],
            ['Staging-Env-01', 'Serveur', 16, 32, 'Staging', 'U06', 'disponible'],
            ['DB-Legacy-01', 'Serveur', 12, 24, 'Database', 'U08', 'maintenance'],
            ['File-Srv-01', 'Serveur', 8, 16, 'File', 'Tower', 'disponible'],
            ['Monitor-Sys-01', 'Serveur', 8, 16, 'Monitoring', 'U25', 'disponible'],
            ['AI-GPU-Node-01', 'Workstation', 64, 512, 'AI', 'U30', 'maintenance'],
            ['Switch-Core-01', 'Reseau', 4, 8, 'Switch', 'U40', 'disponible'],
            ['Firewall-Main-01', 'Reseau', 8, 16, 'Security', 'U41', 'disponible'],
            ['Load-Balancer-01', 'Reseau', 8, 16, 'Network', 'U42', 'disponible'],
            ['Mail-Srv-01', 'Serveur', 12, 24, 'Mail', 'U09', 'disponible'],
            ['Archive-Store-01', 'Stockage', 4, 32, 'Archive', 'U22', 'disponible'],
        ];

        foreach ($serverTypes as $server) {
            Resource::create([
                'name' => $server[0],
                'type' => $server[1],
                'cpu' => $server[2],
                'ram' => $server[3],
                'category' => $server[4],
                'rack_position' => $server[5],
                'status' => $server[6],
                'manager_id' => $managerId,
            ]);
        }
    }
}
