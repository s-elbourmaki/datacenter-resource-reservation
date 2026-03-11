
// Function to handle tab switching
window.switchTab = function (tabId) {
    document.querySelectorAll('.hub-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.hub-tab-btn').forEach(el => el.classList.remove('active'));

    document.getElementById(tabId).classList.add('active');

    let target = event ? event.currentTarget : null;
    if (target) target.classList.add('active');

    if (tabId === 'calendar' && window.calendar) {
        setTimeout(() => {
            window.calendar.render();
        }, 100);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar-wrapper');
    if (!calendarEl) return;

    // Check if FullCalendar is loaded
    if (typeof FullCalendar === 'undefined') {
        console.error('FullCalendar not loaded');
        return;
    }

    window.calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        height: 650,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        buttonText: {
            today: "Auj.",
            month: 'Mois',
            week: 'Semaine',
            list: 'Liste'
        },
        events: window.reservationEvents || [],
        eventClick: function (info) {
            info.jsEvent.preventDefault();
            alert('Réservation de ' + info.event.extendedProps.user + '\nStatut: ' + info.event.extendedProps.status);
        }
    });
    // Render initially hidden, will be re-rendered on tab switch
    window.calendar.render();
});
