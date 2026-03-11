<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $query = Resource::query();

        // Filtre par recherche (Nom, modèle, type...)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filtre par type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filtre par catégorie
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Filtre par statut
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $resources = $query->get();

        // Données dynamiques pour les filtres
        $types = Resource::distinct()->pluck('type')->filter();
        $categories = Resource::distinct()->pluck('category')->filter();
        $statuses = Resource::distinct()->pluck('status')->filter();

        return view('resources.index', compact('resources', 'types', 'categories', 'statuses'));
    }

    public function show(Resource $resource)
    {
        return view('resources.show', compact('resource'));
    }

    public function exportResources()
    {
        $fileName = 'resources_' . date('Y-m-d_H-i') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Nom', 'Type', 'Catégorie', 'CPU', 'RAM', 'Statut', 'Manager']);

            foreach (Resource::with('manager')->cursor() as $resource) {
                fputcsv($handle, [
                    $resource->id,
                    $resource->name,
                    $resource->type,
                    $resource->category,
                    $resource->cpu,
                    $resource->ram,
                    $resource->status,
                    $resource->manager ? $resource->manager->name : 'N/A'
                ]);
            }
            fclose($handle);
        }, $fileName);
    }

    public function managerIndex()
    {
        if (Auth::user()->role === 'admin') {
            // L'admin voit tout le catalogue
            $resources = Resource::with('manager')->get();
        } else {
            // Le responsable ne voit que ses ressources
            $resources = Resource::where('manager_id', Auth::id())->get();
        }

        return view('resources.manager', compact('resources'));
    }

    public function create()
    {
        $managers = User::where('role', 'responsable')->get();
        return view('resources.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'cpu' => 'required|integer',
            'ram' => 'required|integer',
            'category' => 'required|string',
            'rack_position' => 'nullable|string|max:10',
        ]);

        Resource::create([
            'name' => $request->name,
            'type' => $request->type,
            'cpu' => $request->cpu,
            'ram' => $request->ram,
            'category' => $request->category,
            'rack_position' => $request->rack_position,
            'status' => 'disponible',
            'manager_id' => auth()->id(),
        ]);

        return redirect()->route('resources.index')->with('success', 'Ressource ajoutée au parc.');
    }

    public function edit(Resource $resource)
    {
        if ($resource->manager_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }
        $managers = User::where('role', 'responsable')->get();
        return view('resources.edit', compact('resource', 'managers'));
    }

    public function update(Request $request, Resource $resource)
    {
        if ($resource->manager_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'maintenance_start' => 'nullable|date',
            'maintenance_end' => 'nullable|date|after:maintenance_start',
            'rack_position' => 'nullable|string|max:10',
        ]);

        $resource->update($request->all());

        Log::create([
            'user_id' => Auth::id(),
            'action' => 'Admin: Mise à jour',
            'description' => "Modifications globales sur {$resource->name}"
        ]);

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Catalogue mis à jour.');
        }

        return redirect()->route('resources.manager')->with('success', 'Ressource mise à jour avec succès.');
    }

    public function toggleMaintenance(Resource $resource)
    {
        if ($resource->manager_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $newStatus = ($resource->status === 'maintenance') ? 'disponible' : 'maintenance';
        $resource->update(['status' => $newStatus]);

        return redirect()->back()->with('success', "État de la ressource changé en {$newStatus}.");
    }

    public function printQr(Resource $resource)
    {
        if ($resource->manager_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('resources.print_qr', compact('resource'));
    }

    public function toggleActivation(Resource $resource)
    {
        if ($resource->manager_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $newStatus = ($resource->status === 'désactivée') ? 'disponible' : 'désactivée';
        $resource->update(['status' => $newStatus]);

        $message = ($newStatus === 'désactivée')
            ? 'La ressource a été bloquée avec succès.'
            : 'La ressource a été réactivée avec succès.';

        return redirect()->back()->with('success', $message);
    }
}