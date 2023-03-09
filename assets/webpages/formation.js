import { Tooltip as Tooltip } from 'bootstrap';
import '../styles/css/webpages/formation.scss';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import frLocale from '@fullcalendar/core/locales/fr';

document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');
    let formationDates = [];

    const url = '/json/dates-formations/';
    const formation = '1';
    fetch(url + formation)
        .then(response => response.json())
        .then(data => {
            let dates = JSON.parse(data)
            Object.keys(dates).forEach(key => {
                formationDates.push({
                    title: dates[key].title,
                    start: dates[key].start,
                    end: dates[key].end,
                    extendedProps: {
                        description: dates[key].description,
                    },
                    backgroundColor: dates[key].color,
                    borderColor: dates[key].color,
                })
            });

            let calendar = new Calendar(calendarEl, {
                plugins: [ dayGridPlugin ],
                locale: frLocale,
                events: [...formationDates],
                height: "70vh",
                headerToolbar: {
                    start: 'prev',
                    center: 'title',
                    end: 'next'
                },
                eventDidMount: function(info) {
                    var tooltip = new Tooltip(info.el, {
                        title: info.event.extendedProps.description,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                },
                eventTextColor: "white",
            });

            calendar.render();
        })
        .catch(error => console.error(error));

    $( "#thumbnail-video" ).on("load", function() {
        let heightOfThumbnailVideo = document.getElementById('thumbnail-video').offsetHeight;
        $('#comments').css('height', heightOfThumbnailVideo+'px');
    });
});
