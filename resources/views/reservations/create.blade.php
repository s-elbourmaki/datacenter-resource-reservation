@extends('layouts.app')

@push('styles')
    @vite(['resources/css/reservations/create.css'])
@endpush

@section('content')
    <div class="page-header res-create-header">
        <div>
            <h1 class="page-title">Réserver une <span>Ressource</span></h1>
            <p class="page-subtitle res-create-subtitle">Planifiez votre allocation de ressources Data Center en quelques
                secondes.</p>
        </div>
    </div>

    <div class="card res-create-card">
        <div class="card-body">

            @if ($errors->any())
                <div class="res-error-container">
                    <ul class="res-error-list">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf

                <!-- Resource Selection -->
                <div class="res-form-group">
                    <label class="res-form-label">
                        <i class="fas fa-server"></i> Choisir l'équipement
                    </label>
                    <select name="resource_id" id="resource_id" required class="res-form-select">
                        <option value="">-- Liste des ressources disponibles --</option>
                        @foreach($resources as $resource)
                            <option value="{{ $resource->id }}" {{ (isset($selectedResourceId) && $selectedResourceId == $resource->id) ? 'selected' : '' }} data-cpu="{{ $resource->cpu }}"
                                data-ram="{{ $resource->ram }}">
                                {{ $resource->name }} ({{ $resource->type }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Technical Specs Preview (Hidden by default) -->
                <div id="preview-card" style="display: none;">
                    <h4 class="preview-title">
                        <i class="fas fa-info-circle"></i> Spécifications techniques :
                    </h4>
                    <div class="preview-grid">
                        <div class="preview-item">
                            <i class="fas fa-microchip"></i> CPU: <span id="p-cpu" class="preview-value"></span> Cores
                        </div>
                        <div class="preview-item">
                            <i class="fas fa-memory"></i> RAM: <span id="p-ram" class="preview-value"></span> GB
                        </div>
                    </div>
                </div>

                <!-- Custom Calendar -->
                <div class="res-form-group">
                    <label class="res-form-label">
                        <i class="far fa-calendar-alt"></i> Disponibilité & Sélection
                    </label>

                    <div class="calendar-container">
                        <!-- Calendar Widget -->
                        <div class="calendar-wrapper">
                            <div class="calendar-header">
                                <button type="button" id="prev-month" class="calendar-nav-btn"><i
                                        class="fas fa-chevron-left"></i></button>
                                <span id="calendar-title" class="calendar-title"></span>
                                <button type="button" id="next-month" class="calendar-nav-btn"><i
                                        class="fas fa-chevron-right"></i></button>
                            </div>
                            <div class="calendar-grid" id="calendar-grid">
                                <!-- JS injected -->
                            </div>
                        </div>

                        <!-- Legend Sidebar -->
                        <div class="calendar-legend">
                            <div class="legend-item">
                                <div class="legend-color" style="background: #f3f4f6; border: 1px solid #d1d5db;"></div>
                                <span>Indisponible</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background: white; border: 1px solid #ccc;"></div>
                                <span>Libre</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background: #fee2e2; border: 1px solid #ef4444;"></div>
                                <span>Réservé</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background: #e0e7ff; border: 1px solid var(--primary);">
                                </div>
                                <span>Sélection</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="date-range-grid" style="background: var(--bg-secondary); padding: 15px; border-radius: 8px;">
                    <div>
                        <label class="res-form-label" style="margin-bottom: 5px; font-size: 0.8rem;">Date de début</label>
                        <strong id="display_start_date" style="color: var(--primary);">---</strong>
                        <input type="hidden" name="start_date" id="start_date" required>
                    </div>
                    <div>
                        <label class="res-form-label" style="margin-bottom: 5px; font-size: 0.8rem;">Date de fin</label>
                        <strong id="display_end_date" style="color: var(--primary);">---</strong>
                        <input type="hidden" name="end_date" id="end_date" required>
                    </div>
                </div>

                <div class="res-form-group">
                    <label class="res-form-label">
                        <i class="fas fa-pen-alt"></i> Justification du besoin
                    </label>
                    <textarea name="justification" rows="3" required
                        placeholder="Expliquez pourquoi vous avez besoin de cette ressource..."
                        class="res-form-textarea">{{ old('justification') }}</textarea>
                </div>

                <div class="res-form-actions">
                    <button type="submit" class="btn btn-primary btn-confirm-res">
                        <i class="fas fa-check-circle"></i> Confirmer la réservation
                    </button>
                    <a href="{{ route('resources.index') }}" class="btn-cancel-res">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
                    window.availabilityApiUrl = "{{ url('/api/resources') }}";
        </script>
        @vite(['resources/js/reservations/create.js'])
    @endpush
@endsection