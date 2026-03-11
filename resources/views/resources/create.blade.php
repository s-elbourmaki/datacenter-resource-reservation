@extends('layouts.app')

@push('styles')
    @vite(['resources/css/resources/create.css'])
@endpush

@section('content')
    <div class="main-content resource-create-container">
        <div class="auth-page">
            <div class="card auth-card resource-create-card">
                <div class="auth-logo resource-create-header">
                    <h2 class="logo-text resource-create-title">Ajouter
                        une <span style="color: var(--primary);">Ressource</span></h2>
                    <p class="resource-create-subtitle">Enregistrement d'un nouvel équipement dans le parc.</p>
                </div>

                <form action="{{ route('resources.store') }}" method="POST">
                    @csrf

                    <div class="form-group form-group-custom">
                        <label class="form-label-custom">Nom de l'équipement</label>
                        <input type="text" name="name" placeholder="ex: Serveur Dell PowerEdge" required
                            class="form-input-custom">
                    </div>

                    <div class="specs-grid">
                        <div class="form-group">
                            <label class="form-label-custom">CPU (Cœurs)</label>
                            <input type="number" name="cpu" required min="1" class="form-input-custom">
                        </div>
                        <div class="form-group">
                            <label class="form-label-custom">RAM (Go)</label>
                            <input type="number" name="ram" required min="1" class="form-input-custom">
                        </div>
                    </div>

                    <div class="form-group form-group-custom">
                        <label class="form-label-custom">Type de ressource</label>
                        <select name="type" class="form-input-custom">
                            <option value="Serveur">Serveur Physique</option>
                            <option value="VM">Machine Virtuelle</option>
                            <option value="Switch">Switch Réseau</option>
                            <option value="Stockage">Baie de Stockage</option>
                        </select>
                    </div>

                    <div class="form-group form-group-custom">
                        <label class="form-label-custom">Position Rack</label>
                        <input type="text" name="rack_position" placeholder="ex: U10, U42" required
                            class="form-input-custom">
                    </div>

                    <div class="form-group form-group-custom">
                        <label class="form-label-custom">Catégorie</label>
                        <select name="category" class="form-input-custom" required>
                            <option value="Standard">Standard</option>
                            <option value="Database">Database</option>
                            <option value="Web">Web Server</option>
                            <option value="App">App Server</option>
                            <option value="Backup">Backup</option>
                            <option value="NAS">Stockage NAS</option>
                            <option value="Compute">Compute Node</option>
                            <option value="Dev">Development</option>
                            <option value="Staging">Staging</option>
                            <option value="AI">AI Workstation</option>
                            <option value="Network">Network Device</option>
                            <option value="Archive">Archive</option>
                            <option value="Monitoring">Monitoring</option>
                        </select>
                    </div>

                    <div class="auth-footer" style="display: flex; flex-direction: column; gap: 15px;">
                        <button type="submit" class="btn-primary btn-submit-resource">
                            <i class="fas fa-save" style="margin-right: 8px;"></i> ENREGISTRER DANS LE PARC
                        </button>
                        <a href="{{ route('resources.index') }}" class="cancel-link">
                            Annuler et revenir au catalogue
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection