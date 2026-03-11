document.addEventListener('DOMContentLoaded', () => {
    const resourceSelect = document.getElementById('resource_id');
    const calendarGrid = document.getElementById('calendar-grid');
    const calendarTitle = document.getElementById('calendar-title');
    const prevBtn = document.getElementById('prev-month');
    const nextBtn = document.getElementById('next-month');

    // Inputs
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const displayStart = document.getElementById('display_start_date');
    const displayEnd = document.getElementById('display_end_date');

    // State
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    let bookedRanges = [];
    let selection = { start: null, end: null };

    // 1. Resource Change Listener
    if (resourceSelect) {
        resourceSelect.addEventListener('change', function () {
            window.updateDetails(this); // Keep existing detailed view logic
            fetchAvailability(this.value);
            resetSelection();
        });

        // Init if pre-selected
        if (resourceSelect.value) {
            window.updateDetails(resourceSelect);
            fetchAvailability(resourceSelect.value);
        }
    }

    // 2. Navigation Listeners
    prevBtn.addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar();
    });

    nextBtn.addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar();
    });

    // 3. Functions
    async function fetchAvailability(resourceId) {
        if (!resourceId) {
            bookedRanges = [];
            renderCalendar();
            return;
        }

        try {
            const baseUrl = window.availabilityApiUrl || '/api/resources';
            // console.log(`Fetching availability for resource ${resourceId} at ${baseUrl}`);
            const response = await fetch(`${baseUrl}/${resourceId}/availability`);
            if (!response.ok) throw new Error('Network error');
            bookedRanges = await response.json();
            renderCalendar();
        } catch (error) {
            console.error('Error fetching availability:', error);
            // Fallback: clear bookings if error
            bookedRanges = [];
            renderCalendar();
        }
    }

    function resetSelection() {
        selection = { start: null, end: null };
        updateInputs();
        renderCalendar();
    }

    function renderCalendar() {
        if (!calendarGrid) return;

        calendarGrid.innerHTML = '';

        // Update Title
        const monthNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
        calendarTitle.innerText = `${monthNames[currentMonth]} ${currentYear}`;

        // Headers
        const days = ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'];
        days.forEach(day => {
            const el = document.createElement('div');
            el.className = 'calendar-day-header';
            el.innerText = day;
            calendarGrid.appendChild(el);
        });

        // Days calculation
        const firstDay = new Date(currentYear, currentMonth, 1).getDay(); // 0 = Sunday
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        // Padding days
        for (let i = 0; i < firstDay; i++) {
            const el = document.createElement('div');
            el.className = 'calendar-day disabled';
            calendarGrid.appendChild(el);
        }

        // Real days
        for (let i = 1; i <= daysInMonth; i++) {
            const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            const dateObj = new Date(currentYear, currentMonth, i);

            const el = document.createElement('div');
            el.className = 'calendar-day';
            el.innerHTML = `<span class="day-number">${i}</span>`;

            // Check status
            const isBooked = isDateBooked(dateStr);
            const isPast = dateObj < today;

            if (isPast) {
                el.classList.add('disabled');
            } else if (isBooked) {
                el.classList.add('booked');
                // Removed text label as requested for compact design
            } else {
                // Clickable
                el.addEventListener('click', () => handleDateClick(dateStr));
            }

            // Selection styles
            if (selection.start === dateStr) el.classList.add('selected');
            if (selection.end === dateStr) el.classList.add('selected');
            if (selection.start && selection.end && dateStr > selection.start && dateStr < selection.end) {
                el.classList.add('in-range');
            }

            calendarGrid.appendChild(el);
        }
    }

    function isDateBooked(dateStr) {
        return bookedRanges.some(range => {
            return dateStr >= range.start_date && dateStr <= range.end_date;
        });
    }

    function handleDateClick(dateStr) {
        if (!selection.start || (selection.start && selection.end)) {
            // New selection
            selection.start = dateStr;
            selection.end = null;
        } else {
            // End selection
            if (dateStr < selection.start) {
                selection.start = dateStr; // Clicked before start, restart
            } else {
                // Validate range
                if (hasBookingBetween(selection.start, dateStr)) {
                    alert('La période sélectionnée contient des dates indisponibles.');
                    selection.start = dateStr; // Restart at clicked
                    selection.end = null;
                } else {
                    selection.end = dateStr;
                }
            }
        }
        updateInputs();
        renderCalendar();
    }

    function hasBookingBetween(start, end) {
        // Simple check if any booked date falls inside start -> end
        let current = new Date(start);
        const last = new Date(end);

        while (current <= last) {
            const d = current.toISOString().split('T')[0];
            if (isDateBooked(d)) return true;
            current.setDate(current.getDate() + 1);
        }
        return false;
    }

    function updateInputs() {
        startDateInput.value = selection.start || '';
        endDateInput.value = selection.end || '';

        displayStart.innerText = selection.start || '---';
        displayEnd.innerText = selection.end || '---';
    }

    // Initial render
    renderCalendar();
});

// Existing helper (kept for specs preview)
window.updateDetails = function (select) {
    const preview = document.getElementById('preview-card');
    if (!preview) return;

    const option = select.options[select.selectedIndex];

    if (select.value) {
        preview.style.display = 'block';

        const cpu = document.getElementById('p-cpu');
        const ram = document.getElementById('p-ram');

        if (cpu && option) cpu.innerText = option.getAttribute('data-cpu') || 'N/A';
        if (ram && option) ram.innerText = option.getAttribute('data-ram') || 'N/A';
    } else {
        preview.style.display = 'none';
    }
};
