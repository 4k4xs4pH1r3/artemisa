
// Misc-FullCalendar.js
// ====================================================================
// This file should not be included in your project.
// This is just a sample how to initialize plugins or components.
//
// - ThemeOn.net -



$(document).ready(function() {


	// Calendar
	// =================================================================
	// Require Full Calendar
	// -----------------------------------------------------------------
	// http://fullcalendar.io/
	// =================================================================


	// initialize the external events
	// -----------------------------------------------------------------
	$('#demo-external-events .fc-event').each(function() {
		// store data so the calendar knows to render an event upon drop
		$(this).data('event', {
			title: $.trim($(this).text()), // use the element's text as the event title
			stick: true, // maintain when user navigates (see docs on the renderEvent method)
			className : $(this).data('class')
		});


		// make the event draggable using jQuery UI
		$(this).draggable({
			zIndex: 99999,
			revert: true,      // will cause the event to go back to its
			revertDuration: 0  //  original position after the drag
		});
	});


	// Initialize the calendar
	// -----------------------------------------------------------------
	$('#demo-calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		editable: true,
		droppable: true, // this allows things to be dropped onto the calendar
		drop: function() {
			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
				// if so, remove the element from the "Draggable Events" list
				$(this).remove();
			}
		},
		defaultDate: '2015-01-12',
		eventLimit: true, // allow "more" link when too many events
		events: [
			{
				title: 'Happy Hour',
				start: '2015-01-05',
				end: '2015-01-07',
				className: 'purple',
                                description: 'El Rector de la Universidad El Bosque, Doctor Rafael S??nchez Par??s, se permite invitar a toda la comunidad universitaria a la Audiencia de Rendici??n de Cuentas 2016-2017',
			},
			{
				title: 'Birthday Party',
				start: '2015-01-15',
				end: '2015-01-17',
				className: 'mint',
                                description: 'El Rector de la Universidad El Bosque, Doctor Rafael S??nchez Par??s, se permite invitar a toda la comunidad universitaria a la Audiencia de Rendici??n de Cuentas 2016-2017',
			},
			{
				title: 'All Day Event',
				start: '2015-01-15',
				className: 'warning',
                                description: 'El Rector de la Universidad El Bosque, Doctor Rafael S??nchez Par??s, se permite invitar a toda la comunidad universitaria a la Audiencia de Rendici??n de Cuentas 2016-2017',
			},
			{
				title: 'Meeting',
				start: '2015-01-20T10:30:00',
				end: '2015-01-20T12:30:00',
				className: 'danger',
                                description: 'El Rector de la Universidad El Bosque, Doctor Rafael S??nchez Par??s, se permite invitar a toda la comunidad universitaria a la Audiencia de Rendici??n de Cuentas 2016-2017',
			},
			{
				title: 'All Day Event',
				start: '2015-02-01',
				className: 'warning',
                                description: 'El Rector de la Universidad El Bosque, Doctor Rafael S??nchez Par??s, se permite invitar a toda la comunidad universitaria a la Audiencia de Rendici??n de Cuentas 2016-2017',
			},
			{
				title: 'Long Event',
				start: '2015-02-07',
				end: '2015-02-10',
				className: 'purple',
                                description: 'El Rector de la Universidad El Bosque, Doctor Rafael S??nchez Par??s, se permite invitar a toda la comunidad universitaria a la Audiencia de Rendici??n de Cuentas 2016-2017',
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2015-02-09T16:00:00'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2015-02-16T16:00:00',
				className: 'success'
			},
			{
				title: 'Conference',
				start: '2015-02-11',
				end: '2015-02-13',
				className: 'dark'
			},
			{
				title: 'Meeting',
				start: '2015-02-12T10:30:00',
				end: '2015-02-12T12:30:00'
			},
			{
				title: 'Lunch',
				start: '2015-02-12T12:00:00',
				className: 'pink'
			},
			{
				title: 'Meeting',
				start: '2015-02-12T14:30:00'
			},
			{
				title: 'Happy Hour',
				start: '2015-02-12T17:30:00'
			},
			{
				title: 'Dinner',
				start: '2015-02-12T20:00:00'
			},
			{
				title: 'Birthday Party',
				start: '2015-02-13T07:00:00'
			},
			{
				title: 'Click for Google',
				url: 'http://google.com/',
				start: '2015-02-28'
			}
		],
                eventRender: function(event, element) {
                    element.qtip({
                        content: event.description + '<br />' + event.start,
                        style: {
                            background: 'black',
                            color: '#FFFFFF'
                        },
                        position: {
                            corner: {
                                target: 'center',
                                tooltip: 'bottomMiddle'
                            }
                        }
                    });
                }
	});

});
