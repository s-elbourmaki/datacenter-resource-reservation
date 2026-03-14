/* resources/js/home.js */

/* ══════════════════════════════════════
   PRELOADER
══════════════════════════════════════ */
window.addEventListener('load', () => {
  setTimeout(() => {
    const preloader = document.getElementById('preloader');
    if (preloader) preloader.classList.add('hidden');
  }, 2000);
  initMap();
});

/* ══════════════════════════════════════
   HAMBURGER / MOBILE MENU
══════════════════════════════════════ */
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');

if (hamburger && mobileMenu) {
  hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    mobileMenu.classList.toggle('open');
    document.body.style.overflow = mobileMenu.classList.contains('open') ? 'hidden' : '';
  });

  document.querySelectorAll('.mob-link').forEach(link => {
    link.addEventListener('click', () => {
      hamburger.classList.remove('active');
      mobileMenu.classList.remove('open');
      document.body.style.overflow = '';
    });
  });
}

/* ══════════════════════════════════════
   NAV SCROLL + ACTIVE SECTION TRACKING
══════════════════════════════════════ */
const mainNav = document.getElementById('main-nav');
const backToTop = document.getElementById('backToTop');
const sections = document.querySelectorAll('section[id]');

window.addEventListener('scroll', () => {
  const scrollY = window.scrollY;

  // Nav background
  if (mainNav) {
    if (scrollY > 60) mainNav.classList.add('scrolled');
    else mainNav.classList.remove('scrolled');
  }

  // Back to top
  if (backToTop) {
    if (scrollY > 600) backToTop.classList.add('show');
    else backToTop.classList.remove('show');
  }

  // Active nav link
  let current = '';
  sections.forEach(sec => {
    const top = sec.offsetTop - 100;
    if (scrollY >= top) current = sec.getAttribute('id');
  });
  document.querySelectorAll('.nav-link').forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('href') === '#' + current) {
      link.classList.add('active');
    }
  });
}, { passive: true });

if (backToTop) {
  backToTop.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

/* ══════════════════════════════════════
   SCROLL REVEAL
══════════════════════════════════════ */
const revealObs = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.classList.add('visible');
      revealObs.unobserve(e.target);
    }
  });
}, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

/* ══════════════════════════════════════
   COUNTER ANIMATION (with easing)
══════════════════════════════════════ */
function easeOutQuart(t) { return 1 - Math.pow(1 - t, 4); }

function animateCounter(el) {
  const target = +el.dataset.target;
  const duration = target > 100 ? 2000 : 1500;
  const start = performance.now();

  function update(now) {
    const elapsed = now - start;
    const progress = Math.min(elapsed / duration, 1);
    const value = Math.floor(easeOutQuart(progress) * target);
    el.textContent = value.toLocaleString('fr-FR');
    if (progress < 1) requestAnimationFrame(update);
    else el.textContent = target.toLocaleString('fr-FR');
  }
  requestAnimationFrame(update);
}

// Hero counters
const heroSection = document.querySelector('.hero');
if (heroSection) {
  const heroObs = new IntersectionObserver(entries => {
    if (entries[0].isIntersecting) {
      document.querySelectorAll('.counter').forEach(el => animateCounter(el));
      heroObs.disconnect();
    }
  }, { threshold: 0.3 });
  heroObs.observe(heroSection);
}

// Infra strip counters + bar animation
const infraStats = document.querySelectorAll('.infra-stat');
const infraObs = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.classList.add('visible');
      const counter = e.target.querySelector('.counter-dark');
      if (counter && !counter.dataset.animated) {
        counter.dataset.animated = '1';
        animateCounter(counter);
      }
    }
  });
}, { threshold: 0.3 });
infraStats.forEach(s => infraObs.observe(s));

// Uptime bars animation
const uptimePanel = document.getElementById('uptimePanel');
if (uptimePanel) {
  const uptimeObs = new IntersectionObserver(entries => {
    if (entries[0].isIntersecting) {
      document.querySelectorAll('.up-bar-fill').forEach(bar => {
        const w = bar.dataset.width;
        setTimeout(() => { bar.style.width = w + '%'; }, 200);
      });
      uptimeObs.disconnect();
    }
  }, { threshold: 0.2 });
  uptimeObs.observe(uptimePanel);
}

/* ══════════════════════════════════════
   LIVE CLOCK
══════════════════════════════════════ */
function updateClock() {
  const liveClock = document.getElementById('liveClock');
  if (liveClock) {
    const now = new Date();
    const utc = now.toISOString().slice(11, 19);
    liveClock.textContent = utc;
  }
}
setInterval(updateClock, 1000);
updateClock();

/* ══════════════════════════════════════
   LOCATION TABS (functional)
══════════════════════════════════════ */
const locationData = {
  europe: [
    { code: 'FR', name: 'Paris — CDG1', region: 'France · Europe Ouest', cap: '42 MW', area: '18 000 m²', ix: 'France-IX' },
    { code: 'DE', name: 'Francfort — FRA1', region: 'Allemagne · Europe Centrale', cap: '56 MW', area: '24 000 m²', ix: 'DE-CIX' },
    { code: 'NL', name: 'Amsterdam — AMS1', region: 'Pays-Bas · Europe Centrale', cap: '38 MW', area: '15 400 m²', ix: 'AMS-IX' },
    { code: 'GB', name: 'Londres — LON1', region: 'Royaume-Uni · Europe Ouest', cap: '48 MW', area: '20 000 m²', ix: 'LINX' },
  ],
  americas: [
    { code: 'US', name: 'New York — NYC1', region: 'États-Unis · Côte Est', cap: '52 MW', area: '22 000 m²', ix: 'NYIIX' },
    { code: 'US', name: 'Ashburn — IAD1', region: 'États-Unis · Virginie', cap: '38 MW', area: '16 500 m²', ix: 'Equinix IX' },
    { code: 'US', name: 'Los Angeles — LAX1', region: 'États-Unis · Côte Ouest', cap: '30 MW', area: '14 000 m²', ix: 'LAIIX' },
    { code: 'BR', name: 'São Paulo — GRU1', region: 'Brésil · Amérique du Sud', cap: '24 MW', area: '11 000 m²', ix: 'IX.br' },
  ],
  apac: [
    { code: 'SG', name: 'Singapour — SIN1', region: 'Singapour · Asie du Sud-Est', cap: '44 MW', area: '19 000 m²', ix: 'SGIX' },
    { code: 'JP', name: 'Tokyo — TYO1', region: 'Japon · Asie de l\'Est', cap: '50 MW', area: '21 000 m²', ix: 'JPNAP' },
    { code: 'AU', name: 'Sydney — SYD1', region: 'Australie · Océanie', cap: '28 MW', area: '12 000 m²', ix: 'IX Australia' },
    { code: 'IN', name: 'Mumbai — BOM1', region: 'Inde · Asie du Sud', cap: '32 MW', area: '14 500 m²', ix: 'NIXI' },
  ],
  mea: [
    { code: 'AE', name: 'Dubai — DXB1', region: 'EAU · Moyen-Orient', cap: '36 MW', area: '16 000 m²', ix: 'UAE-IX' },
    { code: 'MA', name: 'Casablanca — CMN1', region: 'Maroc · Afrique du Nord', cap: '18 MW', area: '9 000 m²', ix: 'CASIX' },
  ]
};

const locGrid = document.getElementById('locGrid');

function renderLocations(region) {
  if (!locGrid) return;
  const data = locationData[region] || [];
  locGrid.classList.add('fade');

  setTimeout(() => {
    locGrid.innerHTML = data.map(loc => `
      <div class="loc-card">
        <div class="loc-region-code">${loc.code}</div>
        <div class="loc-ping"></div>
        <h3>${loc.name}</h3>
        <div class="loc-reg">${loc.region}</div>
        <div class="loc-specs">
          <div class="loc-spec"><span class="k">Capacité</span><span class="v">${loc.cap}</span></div>
          <div class="loc-spec"><span class="k">Surface</span><span class="v">${loc.area}</span></div>
          <div class="loc-spec"><span class="k">Internet Exchange</span><span class="v">${loc.ix}</span></div>
        </div>
      </div>
    `).join('');
    locGrid.classList.remove('fade');
  }, 300);
}

// Init with Europe
if (locGrid) renderLocations('europe');

document.querySelectorAll('.loc-tab').forEach(tab => {
  tab.addEventListener('click', function() {
    document.querySelectorAll('.loc-tab').forEach(t => t.classList.remove('active'));
    this.classList.add('active');
    renderLocations(this.dataset.region);
  });
});

/* ══════════════════════════════════════
   WORLD MAP — D3 + TopoJSON
══════════════════════════════════════ */
const DC_SITES = [
  { id: 'PAR', name: 'Paris',       coords: [2.35,  48.85], tier: 1 },
  { id: 'FRA', name: 'Frankfurt',   coords: [8.68,  50.11], tier: 1 },
  { id: 'AMS', name: 'Amsterdam',   coords: [4.90,  52.37], tier: 1 },
  { id: 'LON', name: 'London',      coords: [-0.12, 51.50], tier: 1 },
  { id: 'NYC', name: 'New York',    coords: [-74.0, 40.71], tier: 1 },
  { id: 'IAD', name: 'Ashburn',     coords: [-77.49,39.04], tier: 2 },
  { id: 'LAX', name: 'Los Angeles', coords: [-118.2,34.05], tier: 2 },
  { id: 'SIN', name: 'Singapore',   coords: [103.82, 1.35], tier: 1 },
  { id: 'TYO', name: 'Tokyo',       coords: [139.69,35.69], tier: 1 },
  { id: 'SYD', name: 'Sydney',      coords: [151.21,-33.87],tier: 2 },
  { id: 'DXB', name: 'Dubai',       coords: [55.27, 25.20], tier: 1 },
  { id: 'GRU', name: 'São Paulo',   coords: [-46.63,-23.55],tier: 2 },
  { id: 'BOM', name: 'Mumbai',      coords: [72.88, 19.08], tier: 2 },
  { id: 'CMN', name: 'Casablanca',  coords: [-7.62, 33.59], tier: 2 },
];

const ROUTES = [
  ['NYC','LON'], ['LON','FRA'], ['FRA','AMS'], ['FRA','PAR'],
  ['LON','PAR'], ['PAR','CMN'], ['FRA','DXB'], ['DXB','BOM'],
  ['BOM','SIN'], ['SIN','TYO'], ['SIN','SYD'], ['NYC','IAD'],
  ['IAD','LAX'], ['NYC','GRU'], ['TYO','LAX'], ['LON','AMS'],
  ['DXB','SIN'],
];

let animationFrameIds = [];

function initMap() {
  const mapElem = document.getElementById('world-map');
  if (!mapElem) return;

  // Cancel any running animations
  animationFrameIds.forEach(id => cancelAnimationFrame(id));
  animationFrameIds = [];

  const container = document.getElementById('map-container');
  const svg = d3.select('#world-map');
  const W = container.clientWidth;
  const H = container.clientHeight;

  svg.attr('width', W).attr('height', H);

  const projection = d3.geoNaturalEarth1()
    .scale(W / 5.8)
    .translate([W * 0.5, H * 0.52]);

  const path = d3.geoPath().projection(projection);

  // Tooltip
  const tooltip = document.getElementById('mapTooltip');

  // Background sphere
  svg.append('path')
    .datum({type: 'Sphere'})
    .attr('class', 'sphere')
    .attr('d', path);

  // Graticule
  const graticule = d3.geoGraticule().step([20, 20])();
  svg.append('path')
    .datum(graticule)
    .attr('class', 'graticule')
    .attr('d', path);

  // Load world data
  d3.json('https://cdn.jsdelivr.net/npm/world-atlas@2/countries-110m.json')
    .then(world => {
      const countries = topojson.feature(world, world.objects.countries);

      svg.selectAll('.country')
        .data(countries.features)
        .join('path')
        .attr('class', 'country')
        .attr('d', path);

      const arcGroup = svg.append('g').attr('class', 'arc-group');
      const packetGroup = svg.append('g').attr('class', 'packet-group');

      const siteMap = {};
      DC_SITES.forEach(s => { siteMap[s.id] = s; });

      // Draw routes
      ROUTES.forEach(([fromId, toId], idx) => {
        const from = siteMap[fromId];
        const to   = siteMap[toId];
        if (!from || !to) return;

        const lineData = {
          type: 'LineString',
          coordinates: [from.coords, to.coords]
        };

        // Background arc
        arcGroup.append('path')
          .datum(lineData)
          .attr('class', 'arc-bg')
          .attr('d', path);

        // Animated arc
        const animPath = arcGroup.append('path')
          .datum(lineData)
          .attr('class', 'arc-anim')
          .attr('d', path);

        const node = animPath.node();
        if (!node) return;
        const totalLen = node.getTotalLength();
        const dashLen  = Math.max(totalLen * 0.15, 18);

        animPath
          .attr('stroke-dasharray', `${dashLen} ${totalLen}`)
          .attr('stroke-dashoffset', totalLen);

        // Packet dot
        const packet = packetGroup.append('circle')
          .attr('class', 'packet')
          .attr('r', 2.5)
          .attr('opacity', 0);

        // Proper animation loop
        const delay  = idx * 500 + Math.random() * 1000;
        const dur    = 4000 + Math.random() * 2000;

        function animateRoute() {
          const node = animPath.node();
          if (!node) return;

          animPath
            .attr('stroke-dashoffset', totalLen)
            .transition()
            .duration(dur)
            .ease(d3.easeLinear)
            .attr('stroke-dashoffset', -dashLen)
            .on('end', () => {
              setTimeout(animateRoute, 500 + Math.random() * 2000);
            });

          packet.attr('opacity', 0.9);
          const startTime = performance.now();

          function movePacket(now) {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / dur, 1);
            const node = animPath.node();
            if (!node) return;
            const pt = node.getPointAtLength(progress * totalLen);
            packet.attr('cx', pt.x).attr('cy', pt.y);

            if (progress < 1) {
              const id = requestAnimationFrame(movePacket);
              animationFrameIds.push(id);
            } else {
              packet.attr('opacity', 0);
            }
          }
          const id = requestAnimationFrame(movePacket);
          animationFrameIds.push(id);
        }

        setTimeout(animateRoute, delay);
      });

      // DC markers
      const dcGroup = svg.append('g').attr('class', 'dc-group');

      DC_SITES.forEach(site => {
        const [x, y] = projection(site.coords);
        if (!x || !y) return;

        const g = dcGroup.append('g')
          .attr('transform', `translate(${x},${y})`)
          .style('cursor', 'pointer');

        // Pulse rings
        const r1 = site.tier === 1 ? 14 : 10;
        const r2 = site.tier === 1 ? 8 : 6;

        g.append('circle')
          .attr('class', 'dc-ring-outer')
          .attr('r', r1)
          .style('animation-delay', `${Math.random() * 2}s`);

        g.append('circle')
          .attr('class', 'dc-ring-mid')
          .attr('r', r2)
          .style('animation-delay', `${Math.random() * 1.5 + 0.5}s`);

        // Center dot
        const dot = g.append('circle')
          .attr('class', 'dc-dot')
          .attr('r', site.tier === 1 ? 4.5 : 3.5);

        // Label
        if (site.tier === 1) {
          g.append('text')
            .attr('class', 'dc-label')
            .attr('y', -12)
            .attr('text-anchor', 'middle')
            .text(site.id);
        }

        // Tooltip interaction
        g.on('mouseenter', function(event) {
          if (!tooltip) return;
          tooltip.querySelector('h5').textContent = site.name;
          tooltip.querySelector('.tt-id').textContent = site.id + ' — Tier ' + site.tier;
          tooltip.style.left = (event.clientX + 15) + 'px';
          tooltip.style.top = (event.clientY - 10) + 'px';
          tooltip.classList.add('show');

          dot.transition().duration(200).attr('r', site.tier === 1 ? 6.5 : 5);
        })
        .on('mousemove', function(event) {
          if (!tooltip) return;
          tooltip.style.left = (event.clientX + 15) + 'px';
          tooltip.style.top = (event.clientY - 10) + 'px';
        })
        .on('mouseleave', function() {
          if (!tooltip) return;
          tooltip.classList.remove('show');
          dot.transition().duration(200).attr('r', site.tier === 1 ? 4.5 : 3.5);
        });
      });

    })
    .catch(() => {
      svg.select('.sphere').style('fill', '#C5DDE8');
    });
}

/* Handle resize with debounce */
let resizeTimer;
window.addEventListener('resize', () => {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(() => {
    animationFrameIds.forEach(id => cancelAnimationFrame(id));
    animationFrameIds = [];
    const map = document.querySelector('#world-map');
    if (map) {
      map.innerHTML = '';
      initMap();
    }
  }, 300);
});
