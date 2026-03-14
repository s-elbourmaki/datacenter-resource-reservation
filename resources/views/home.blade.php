<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bughaz Digital DataCenter — Infrastructure Mondiale</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.8.5/d3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/topojson/3.0.2/topojson.min.js"></script>

  @vite(['resources/css/bughaz-theme.css', 'resources/css/home.css', 'resources/js/home.js'])

</head>
<body>

<!-- ═══════════ PRELOADER ═══════════ -->
<div class="preloader" id="preloader">
  <div class="preloader-logo">
    <img src="{{ asset('images/logo_bughazdigital.png') }}" alt="Bughaz Digital" style="height: 60px; width: auto; margin-bottom: 10px;">
    <div>BUGHAZ<span>DIGITAL</span></div>
  </div>
  <div class="preloader-bar"><div class="preloader-fill"></div></div>
</div>

<!-- ═══════════ NAV ═══════════ -->
<nav id="main-nav">
  <div class="nav-inner">
    <a href="{{ url('/') }}" class="logo">
      <img src="{{ asset('images/logo_bughazdigital.png') }}" alt="Bughaz Digital" style="height: 60px; width: auto; margin-right: 12px;">
      <span class="logo-text">BUGHAZ<span>DIGITAL</span></span>
    </a>
    <ul class="nav-links">
      <li><a href="#services" class="nav-link">Services</a></li>
      <li><a href="{{ route('resources.index') }}" class="nav-link">Consulter le catalogue</a></li>
      <li><a href="#why" class="nav-link">Infrastructure</a></li>
      <li><a href="#locations" class="nav-link">Localisations</a></li>
      <li><a href="#certs" class="nav-link">Certifications</a></li>
      @auth
        <li><a href="{{ url('/dashboard') }}" class="nav-link nav-cta">Dashboard</a></li>
      @else
        <li><a href="{{ route('login') }}" class="nav-link nav-cta">Connexion</a></li>
      @endauth
    </ul>
    <button class="hamburger" id="hamburger" aria-label="Menu de navigation">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<!-- ═══════════ MOBILE MENU ═══════════ -->
<div class="mobile-menu" id="mobileMenu">
  <a href="#services" class="mob-link">Services</a>
  <a href="{{ route('resources.index') }}" class="mob-link">Consulter le catalogue</a>
  <a href="#why" class="mob-link">Infrastructure</a>
  <a href="#locations" class="mob-link">Localisations</a>
  <a href="#certs" class="mob-link">Certifications</a>
  @auth
    <a href="{{ url('/dashboard') }}" class="mob-link mob-cta">Dashboard</a>
  @else
    <a href="{{ route('login') }}" class="mob-link mob-cta">Connexion</a>
  @endauth
</div>

<!-- ═══════════ HERO ═══════════ -->
<section class="hero">
  <div id="map-container">
    <svg id="world-map" aria-label="Carte mondiale des data centers Bughaz Digital"></svg>
  </div>
  <!-- Map tooltip -->
  <div class="map-tooltip" id="mapTooltip">
    <div class="tt-id"></div>
    <h5></h5>
    <div class="tt-status">Opérationnel 24/7</div>
  </div>
  <div class="hero-veil"></div>
  <div class="hero-veil-bottom"></div>

  <div class="hero-content">
    <div class="hero-badge">
      <div class="pulse-dot"></div>
      Réseau Mondial Opérationnel — 14 Sites Actifs
    </div>
    <h1>
      <span class="h-ice">Colocation</span><br>
      Mondiale &amp;<br>
      <span class="h-red">Interconnexion</span>
    </h1>
    <p class="hero-sub">
      La plus grande plateforme de data centers au monde, conçue pour propulser vos déploiements les plus complexes. Des baies individuelles aux infrastructures privées à grande échelle.
    </p>
    <div class="hero-actions">
      <a href="#services" class="btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="5 12 19 12"/><polyline points="13 6 19 12 13 18"/></svg>
        Nos Solutions
      </a>
      <a href="#locations" class="btn-ghost">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="10" r="3"/><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
        Voir les Sites
      </a>
    </div>
    <div class="hero-stats">
      <div class="hstat">
        <div class="hstat-num"><span class="counter" data-target="99">0</span><em>.999%</em></div>
        <div class="hstat-label">Uptime SLA</div>
      </div>
      <div class="hstat">
        <div class="hstat-num"><span class="counter" data-target="14">0</span><em>+</em></div>
        <div class="hstat-label">Data Centers</div>
      </div>
      <div class="hstat">
        <div class="hstat-num"><span class="counter" data-target="400">0</span><em>G</em></div>
        <div class="hstat-label">Bande Passante</div>
      </div>
      <div class="hstat">
        <div class="hstat-num"><span class="counter" data-target="8000">0</span><em>+</em></div>
        <div class="hstat-label">Clients Actifs</div>
      </div>
    </div>
  </div>

  <div class="map-legend">
    <h4>Légende</h4>
    <div class="legend-item">
      <div class="leg-dot" style="background:var(--red)"></div>
      <span>Data Center Bughaz Digital</span>
    </div>
    <div class="legend-item">
      <div class="leg-line" style="background:var(--steel)"></div>
      <span>Route de données active</span>
    </div>
    <div class="legend-item">
      <div class="leg-dot" style="background:#2ecc71"></div>
      <span>Opérationnel 24/7</span>
    </div>
  </div>

  <div class="scroll-hint">
    <span>Défiler</span>
    <div class="scroll-arrow">
      <svg viewBox="0 0 20 20" fill="none" stroke="var(--muted)" stroke-width="2">
        <polyline points="4 7 10 13 16 7"/>
      </svg>
    </div>
  </div>
</section>

<!-- ═══════════ MARQUEE ═══════════ -->
<div class="marquee-strip">
  <div class="marquee-track">
    <span class="accent">Tier IV Certifié</span><span class="marquee-sep">◆</span>
    <span>ISO 27001</span><span class="marquee-sep">◆</span>
    <span class="accent">PCI-DSS v4</span><span class="marquee-sep">◆</span>
    <span>Uptime 99.999%</span><span class="marquee-sep">◆</span>
    <span class="accent">Redondance N+1</span><span class="marquee-sep">◆</span>
    <span>Alimentation 2N</span><span class="marquee-sep">◆</span>
    <span class="accent">SOC 2 Type II</span><span class="marquee-sep">◆</span>
    <span>Fibre 400G</span><span class="marquee-sep">◆</span>
    <span class="accent">RGPD Conforme</span><span class="marquee-sep">◆</span>
    <span>PUE &lt; 1.25</span><span class="marquee-sep">◆</span>
  </div>
</div>

<!-- ═══════════ SERVICES ═══════════ -->
<section id="services">
  <div class="container">
    <div class="svc-header reveal">
      <div>
        <div class="sec-label">Nos Services</div>
        <h2 class="sec-title">Solutions <span class="t-blue">Complètes</span><br>Pour Chaque Besoin</h2>
      </div>
      <p class="sec-desc">De la colocation bare-metal au cloud hybride, chaque solution est conçue pour la performance maximale et une résilience absolue.</p>
    </div>
    <div class="svc-grid reveal">

      <div class="svc-card">
        <div class="svc-num">01</div>
        <div class="svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="1.7">
            <rect x="2" y="2" width="20" height="8" rx="1"/>
            <rect x="2" y="14" width="20" height="8" rx="1"/>
            <line x1="6" y1="6" x2="6.01" y2="6" stroke-linecap="round" stroke-width="2"/>
            <line x1="10" y1="6" x2="10.01" y2="6" stroke-linecap="round" stroke-width="2"/>
            <line x1="6" y1="18" x2="6.01" y2="18" stroke-linecap="round" stroke-width="2"/>
            <line x1="10" y1="18" x2="10.01" y2="18" stroke-linecap="round" stroke-width="2"/>
          </svg>
        </div>
        <h3>Colocation</h3>
        <p>Hébergez vos équipements dans nos salles haute densité avec accès 24/7, alimentation redondante et connectivité multi-opérateurs garantie.</p>
        <a href="#" class="svc-more">
          En savoir plus
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </div>

      <div class="svc-card">
        <div class="svc-num">02</div>
        <div class="svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="1.7">
            <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/>
          </svg>
        </div>
        <h3>Cloud Privé</h3>
        <p>Infrastructure virtualisée dédiée sur VMware ou OpenStack. Scalabilité instantanée, isolation totale des données, SLA garanti contractuellement.</p>
        <a href="#" class="svc-more">
          En savoir plus
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </div>

      <div class="svc-card">
        <div class="svc-num">03</div>
        <div class="svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="1.7">
            <circle cx="12" cy="12" r="2"/>
            <path d="M16.24 7.76a6 6 0 0 1 0 8.49m-8.48-.01a6 6 0 0 1 0-8.49m11.31-2.82a10 10 0 0 1 0 14.14m-14.14 0a10 10 0 0 1 0-14.14"/>
          </svg>
        </div>
        <h3>Interconnexion</h3>
        <p>Points de présence sur les principaux IX mondiaux. Peering direct 300+ opérateurs, liens dédiés 10G à 400G en fibre noire internationale.</p>
        <a href="#" class="svc-more">
          En savoir plus
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </div>

      <div class="svc-card">
        <div class="svc-num">04</div>
        <div class="svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="1.7">
            <polyline points="23 4 23 10 17 10"/>
            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
          </svg>
        </div>
        <h3>Reprise d'Activité</h3>
        <p>Disaster Recovery as a Service avec RPO 15 min et RTO inférieur à 1 heure. Réplication asynchrone vers site secondaire géographiquement distant.</p>
        <a href="#" class="svc-more">
          En savoir plus
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </div>

      <div class="svc-card">
        <div class="svc-num">05</div>
        <div class="svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="1.7">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
        </div>
        <h3>Cybersécurité</h3>
        <p>SOC managé 24/7, SIEM nouvelle génération, WAF applicatif, protection DDoS jusqu'à 10 Tbps et conformité RGPD/NIS2 intégrée.</p>
        <a href="#" class="svc-more">
          En savoir plus
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </div>

      <div class="svc-card">
        <div class="svc-num">06</div>
        <div class="svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="1.7">
            <rect x="4" y="4" width="16" height="16" rx="2"/>
            <rect x="9" y="9" width="6" height="6"/>
            <line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/>
            <line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/>
            <line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/>
            <line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/>
          </svg>
        </div>
        <h3>HPC &amp; GPU</h3>
        <p>Clusters haute performance pour IA générative, simulation scientifique et rendu 3D. NVIDIA H100 NVLink et A100 disponibles à la demande.</p>
        <a href="#" class="svc-more">
          En savoir plus
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </div>

    </div>
  </div>
</section>

<!-- ═══════════ INFRA STRIP ═══════════ -->
<div class="infra-strip">
  <div class="infra-inner">
    <div class="infra-stat">
      <div class="infra-stat-num"><span class="counter-dark" data-target="99">0</span><em>.999%</em></div>
      <div class="infra-stat-label">Disponibilité SLA</div>
      <div class="infra-stat-desc">Certifié Tier IV Uptime Institute avec redondance totale de l'alimentation</div>
    </div>
    <div class="infra-stat">
      <div class="infra-stat-num"><span class="counter-dark" data-target="300">0</span><em>+</em></div>
      <div class="infra-stat-label">Opérateurs Réseau</div>
      <div class="infra-stat-desc">Peering direct avec les principaux carriers mondiaux sur chaque site</div>
    </div>
    <div class="infra-stat">
      <div class="infra-stat-num"><span class="counter-dark" data-target="240">0</span><em>MW</em></div>
      <div class="infra-stat-label">Capacité Totale</div>
      <div class="infra-stat-desc">Puissance déployée dans nos 14 data centers à travers 4 continents</div>
    </div>
    <div class="infra-stat">
      <div class="infra-stat-num"><span class="counter-dark" data-target="1">0</span><em>.2 PUE</em></div>
      <div class="infra-stat-label">Efficience Énergétique</div>
      <div class="infra-stat-desc">Refroidissement adiabatique et sources d'énergie renouvelables certifiées</div>
    </div>
  </div>
</div>

<!-- ═══════════ WHY ═══════════ -->
<section id="why">
  <div class="container">
    <div class="why-grid">
      <div class="reveal">
        <div class="sec-label">Pourquoi Bughaz Digital</div>
        <h2 class="sec-title">Infrastructure<br>Conçue Pour<br><span class="t-blue">La Continuité</span></h2>
        <p class="sec-desc">Chaque composant est dimensionné pour garantir la disponibilité de vos services critiques, sans compromis.</p>
        <div class="why-features">
          <div class="feat">
            <div class="feat-icon-wrap">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
              </svg>
            </div>
            <div class="feat-text">
              <h4>Alimentation Redondante 2N+1</h4>
              <p>Générateurs diesel avec démarrage automatique en moins de 10 secondes, UPS double conversion, 72h d'autonomie garantie.</p>
            </div>
          </div>
          <div class="feat">
            <div class="feat-icon-wrap">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </div>
            <div class="feat-text">
              <h4>Supervision NOC/SOC 24/7/365</h4>
              <p>Centre opérationnel réseau et sécurité en activité permanente. MTTR inférieur à 15 minutes sur incidents critiques.</p>
            </div>
          </div>
          <div class="feat">
            <div class="feat-icon-wrap">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                <rect x="3" y="11" width="18" height="11" rx="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
              </svg>
            </div>
            <div class="feat-text">
              <h4>Sécurité Périmétrique Multicouche</h4>
              <p>Contrôle biométrique, vidéosurveillance 4K, mantrap à double sas, rondes de sécurité toutes les heures.</p>
            </div>
          </div>
          <div class="feat">
            <div class="feat-icon-wrap">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
              </svg>
            </div>
            <div class="feat-text">
              <h4>Monitoring Temps Réel</h4>
              <p>Tableau de bord unifié en accès client : température par baie, bande passante, latence inter-sites, alertes configurables.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="uptime-panel reveal" id="uptimePanel">
        <div class="up-header">
          <h3>Disponibilité Réseau</h3>
          <div class="up-online">Tous Systèmes Opérationnels</div>
        </div>
        <div class="up-big">99<em>.999%</em></div>
        <div class="up-sub">SLA Garanti — Tier IV Uptime Institute</div>
        <div class="up-bars">
          <div class="up-bar-row">
            <span class="up-bar-name">Compute</span>
            <div class="up-bar-track"><div class="up-bar-fill" data-width="99.9" style="background:var(--steel)"></div></div>
            <span class="up-bar-pct">99.9%</span>
          </div>
          <div class="up-bar-row">
            <span class="up-bar-name">Stockage</span>
            <div class="up-bar-track"><div class="up-bar-fill" data-width="100" style="background:var(--ice)"></div></div>
            <span class="up-bar-pct">100%</span>
          </div>
          <div class="up-bar-row">
            <span class="up-bar-name">Réseau</span>
            <div class="up-bar-track"><div class="up-bar-fill" data-width="99.9" style="background:var(--steel)"></div></div>
            <span class="up-bar-pct">99.9%</span>
          </div>
          <div class="up-bar-row">
            <span class="up-bar-name">Énergie</span>
            <div class="up-bar-track"><div class="up-bar-fill" data-width="100" style="background:var(--ice)"></div></div>
            <span class="up-bar-pct">100%</span>
          </div>
          <div class="up-bar-row">
            <span class="up-bar-name">Cooling</span>
            <div class="up-bar-track"><div class="up-bar-fill" data-width="100" style="background:var(--ice)"></div></div>
            <span class="up-bar-pct">100%</span>
          </div>
        </div>
        <div class="up-incidents">
          <div class="up-inc-title">Statut des Services — Dernières 24h</div>
          <div class="up-inc-item"><span class="inc-name">Réseau Paris CDG1</span><span class="inc-status">Nominal</span></div>
          <div class="up-inc-item"><span class="inc-name">Réseau Francfort FRA1</span><span class="inc-status">Nominal</span></div>
          <div class="up-inc-item"><span class="inc-name">Réseau Singapour SIN1</span><span class="inc-status">Nominal</span></div>
          <div class="up-inc-item"><span class="inc-name">API Monitoring</span><span class="inc-status">Nominal</span></div>
        </div>
        <div class="up-clock">
          <span>Heure serveur UTC :</span>
          <span class="up-clock-time" id="liveClock">--:--:--</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ LOCATIONS ═══════════ -->
<section id="locations">
  <div class="container">
    <div class="reveal">
      <div class="sec-label">Présence Mondiale</div>
      <h2 class="sec-title">14 Sites <span class="t-blue">Stratégiques</span></h2>
      <p class="sec-desc">Implantés aux carrefours des autoroutes numériques pour minimiser la latence et maximiser la connectivité globale.</p>
    </div>

    <div class="loc-tabs" style="margin-top:2.5rem;">
      <div class="loc-tab active" data-region="europe">Europe</div>
      <div class="loc-tab" data-region="americas">Amériques</div>
      <div class="loc-tab" data-region="apac">APAC</div>
      <div class="loc-tab" data-region="mea">MEA</div>
    </div>

    <div class="loc-grid" id="locGrid">
      <!-- Populated by JS -->
    </div>
  </div>
</section>

<!-- ═══════════ CERTS ═══════════ -->
<section id="certs">
  <div class="container">
    <div class="reveal">
      <div class="sec-label">Conformité &amp; Certifications</div>
      <h2 class="sec-title">Confiance <span class="t-blue">Certifiée</span></h2>
      <p class="sec-desc">Nos infrastructures sont auditées annuellement par les organismes de certification les plus exigeants au monde.</p>
    </div>
    <div class="certs-flex reveal">
      <!-- Certification cards -->
      <div class="cert">
        <div class="cert-ico"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg></div>
        <div><div class="cert-name">ISO 27001</div><div class="cert-sub">Sécurité de l'information</div></div>
      </div>
      <div class="cert">
        <div class="cert-ico"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></div>
        <div><div class="cert-name">PCI-DSS v4</div><div class="cert-sub">Données de paiement</div></div>
      </div>
      <div class="cert">
        <div class="cert-ico"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></div>
        <div><div class="cert-name">Tier IV</div><div class="cert-sub">Uptime Institute</div></div>
      </div>
      <div class="cert">
        <div class="cert-ico"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></div>
        <div><div class="cert-name">SOC 2 Type II</div><div class="cert-sub">Contrôles de sécurité</div></div>
      </div>
      <div class="cert">
        <div class="cert-ico"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></div>
        <div><div class="cert-name">RGPD / NIS2</div><div class="cert-sub">Hébergement données EU</div></div>
      </div>
      <div class="cert">
        <div class="cert-ico"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3H14z"/><path d="M7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg></div>
        <div><div class="cert-name">ISO 50001</div><div class="cert-sub">Management de l'énergie</div></div>
      </div>
      <div class="cert">
        <div class="cert-ico"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg></div>
        <div><div class="cert-name">ISO 9001</div><div class="cert-sub">Management de la qualité</div></div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ CTA ═══════════ -->
<div class="cta-banner" id="contact">
  <div class="cta-inner">
    <div class="cta-text">
      <h2>Prêt à Moderniser<br><em>Votre Infrastructure</em> ?</h2>
      <p>Nos experts répondent sous 2 heures. Audit complet gratuit et proposition sur mesure sans engagement.</p>
    </div>
    <div class="cta-btns">
      @auth
        <a href="{{ url('/dashboard') }}" class="btn-primary">Mon Dashboard</a>
      @else
        <a href="{{ route('login') }}" class="btn-primary">Démarrer Maintenant</a>
      @endauth
      <a href="tel:+212754788193" class="btn-ice">+212 754788193</a>
    </div>
  </div>
</div>

<!-- ═══════════ FOOTER ═══════════ -->
<footer>
  <div class="footer-grid">
    <div class="footer-brand">
      <div class="logo">
        <img src="{{ asset('images/logo_bughazdigital.png') }}" alt="Bughaz Digital" style="height: 35px; width: auto; margin-right: 10px;">
        <span class="logo-text" style="color:var(--white)">BUGHAZ<span>DIGITAL</span></span>
      </div>
      <p>Infrastructure de classe mondiale, opérée par des experts passionnés. Votre partenaire pour la continuité numérique.</p>
    </div>
    <div class="footer-col">
      <h4>Services</h4>
      <ul>
        <li><a href="#">Colocation</a></li>
        <li><a href="#">Cloud Privé</a></li>
        <li><a href="#">Interconnexion</a></li>
        <li><a href="#">DRaaS</a></li>
        <li><a href="#">HPC / GPU</a></li>
        <li><a href="#">Cybersécurité</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Entreprise</h4>
      <ul>
        <li><a href="#">À propos</a></li>
        <li><a href="#">Carrières</a></li>
        <li><a href="#">Newsroom</a></li>
        <li><a href="#">Partenaires</a></li>
        <li><a href="#">Blog Technique</a></li>
        <li><a href="#">Relations Investisseurs</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Support</h4>
      <ul>
        <li><a href="#">Documentation</a></li>
        <li><a href="#">Status Page</a></li>
        <li><a href="#">Portail Client</a></li>
        <li><a href="#">NOC 24/7</a></li>
        <li><a href="#">SLA &amp; Contrats</a></li>
        <li><a href="#">Conformité</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>© 2026 Bughaz Digital DataCenter — Tous droits réservés</p>
    <div class="footer-badges">
      <span class="fbadge">Tier IV</span>
      <span class="fbadge">ISO 27001</span>
      <span class="fbadge">SOC 2</span>
      <span class="fbadge">PCI-DSS</span>
    </div>
  </div>
</footer>

<!-- ═══════════ BACK TO TOP ═══════════ -->
<button class="back-to-top" id="backToTop" aria-label="Retour en haut">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
    <polyline points="18 15 12 9 6 15"/>
  </svg>
</button>

</body>
</html>
