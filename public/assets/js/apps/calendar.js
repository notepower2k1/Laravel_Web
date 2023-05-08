"use strict";

!function (NioApp, $) {
  "use strict";

  // Variable
  var $win = $(window),
    $body = $('body'),
    breaks = NioApp.Break;
  NioApp.Calendar = function () {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    var tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1);
    var t_dd = String(tomorrow.getDate()).padStart(2, '0');
    var t_mm = String(tomorrow.getMonth() + 1).padStart(2, '0');
    var t_yyyy = tomorrow.getFullYear();
    var yesterday = new Date(today);
    yesterday.setDate(today.getDate() - 1);
    var y_dd = String(yesterday.getDate()).padStart(2, '0');
    var y_mm = String(yesterday.getMonth() + 1).padStart(2, '0');
    var y_yyyy = yesterday.getFullYear();
    var YM = yyyy + '-' + mm;
    var YESTERDAY = y_yyyy + '-' + y_mm + '-' + y_dd;
    var TODAY = yyyy + '-' + mm + '-' + dd;
    var TOMORROW = t_yyyy + '-' + t_mm + '-' + t_dd;
    var month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var calendarEl = document.getElementById('calendar');
    var eventsEl = document.getElementById('externalEvents');
    var removeEvent = document.getElementById('removeEvent');
    var addEventBtn = $('#addEvent');
    var addEventForm = $('#addEventForm');
    var addEventPopup = $('#addEventPopup');
    var updateEventBtn = $('#updateEvent');
    var editEventForm = $('#editEventForm');
    var editEventPopup = $('#editEventPopup');
    var previewEventPopup = $('#previewEventPopup');
    var deleteEventBtn = $('#deleteEvent');
    var localStorageData = window.localStorage.getItem('calendar');
   
    if(localStorageData){
      localStorageData = JSON.parse(localStorageData);
    }
    var mobileView = NioApp.Win.width < NioApp.Break.md ? true : false;
    var calendar = new FullCalendar.Calendar(calendarEl, {
      timeZone: 'UTC',
      initialView: mobileView ? 'listWeek' : 'dayGridMonth',
      themeSystem: 'bootstrap5',
      headerToolbar: {
        left: 'title prev,next',
        center: null,
        right: 'today dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      height: 800,
      contentHeight: 780,
      aspectRatio: 3,
      editable: true,
      droppable: true,
      views: {
        dayGridMonth: {
          dayMaxEventRows: 2
        }
      },
      direction: NioApp.State.isRTL ? "rtl" : "ltr",
      nowIndicator: true,
      now: TODAY + getTime(),
      eventMouseEnter: function eventMouseEnter(info) {
        var elm = info.el,
          title = info.event._def.title,
          content = info.event._def.extendedProps.description;
        if (content) {
          var fcPopover = new bootstrap.Popover(elm, {
            template: '<div class="popover event-popover"><div class="popover-arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
            title: title,
            content: content ? content : '',
            placement: 'top'
          });
          fcPopover.show();
        }
      },
      eventMouseLeave: function eventMouseLeave() {
        removePopover();
      },
      eventDragStart: function eventDragStart() {
        removePopover();
      },
      eventClick: function eventClick(info) {
        // Get data
        var title = info.event._def.title;
        var description = info.event._def.extendedProps.description;
        var start = info.event._instance.range.start;
        var startDate = start.getFullYear() + '-' + String(start.getMonth() + 1).padStart(2, '0') + '-' + String(start.getDate()).padStart(2, '0');
        var startTime = start.toUTCString().split(' ');
        startTime = startTime[startTime.length - 2];
        startTime = startTime == '00:00:00' ? '' : startTime;
        var end = info.event._instance.range.end;
        var endDate = end.getFullYear() + '-' + String(end.getMonth() + 1).padStart(2, '0') + '-' + String(end.getDate()).padStart(2, '0');
        var endTime = end.toUTCString().split(' ');
        endTime = endTime[endTime.length - 2];
        endTime = endTime == '00:00:00' ? '' : endTime;
        var className = info.event._def.ui.classNames[0].slice(3);
        var eventId = info.event._def.publicId;

        //Set data in eidt form
        $('#edit-event-title').val(title);
        $('#edit-event-start-date').val(startDate).datepicker('update');
        $('#edit-event-end-date').val(endDate).datepicker('update');
        $('#edit-event-start-time').val(startTime);
        $('#edit-event-end-time').val(endTime);
        $('#edit-event-description').val(description);
        $('#edit-event-theme').val(className);
        $('#edit-event-theme').trigger('change.select2');
        editEventForm.attr('data-id', eventId);

        // Set data in preview
        var previewStart = String(start.getDate()).padStart(2, '0') + ' ' + month[start.getMonth()] + ' ' + start.getFullYear() + (startTime ? ' - ' + to12(startTime) : '');
        var previewEnd = String(end.getDate()).padStart(2, '0') + ' ' + month[end.getMonth()] + ' ' + end.getFullYear() + (endTime ? ' - ' + to12(endTime) : '');
        $('#preview-event-title').text(title);
        $('#preview-event-header').addClass('fc-' + className);
        $('#preview-event-start').text(previewStart);
        $('#preview-event-end').text(previewEnd);
        $('#preview-event-description').text(description);
        !description ? $('#preview-event-description-check').css('display', 'none') : null;
        removePopover();
        var fcMorePopover = document.querySelectorAll('.fc-more-popover');
        fcMorePopover && fcMorePopover.forEach(function (elm) {
          elm.remove();
        });
        previewEventPopup.modal('show');
      },

      //get Data From Local And Show   
      events: localStorageData?localStorageData:[]
    });
    calendar.render();

    //Add event

    addEventBtn.on("click", function (e) {
      e.preventDefault();
      var eventTitle = $('#event-title').val();
      var eventStartDate = $('#event-start-date').val();
      var eventEndDate = $('#event-end-date').val();
      var eventStartTime = $('#event-start-time').val();
      var eventEndTime = $('#event-end-time').val();
      var eventDescription = $('#event-description').val();
      var eventTheme = $('#event-theme').val();
      var eventStartTimeCheck = eventStartTime ? 'T' + eventStartTime + 'Z' : '';
      var eventEndTimeCheck = eventEndTime ? 'T' + eventEndTime + 'Z' : '';
      var id = MyLib.generateUid().toString();
      calendar.addEvent({
        id: id,
        title: eventTitle,
        start: eventStartDate + eventStartTimeCheck,
        end: eventEndDate + eventEndTimeCheck,
        className: "fc-" + eventTheme,
        description: eventDescription
      });

      const obj = {
        'id': id,
        'title': eventTitle,
        'start': eventStartDate + eventStartTimeCheck,
        'end': eventEndDate + eventEndTimeCheck,
        'className': "fc-" + eventTheme,
        'description': eventDescription
      }
      saveInLocalStorage(obj);

      addEventPopup.modal('hide');
    });
    updateEventBtn.on("click", function (e) {
      e.preventDefault();
      var eventTitle = $('#edit-event-title').val();
      var eventStartDate = $('#edit-event-start-date').val();
      var eventEndDate = $('#edit-event-end-date').val();
      var eventStartTime = $('#edit-event-start-time').val();
      var eventEndTime = $('#edit-event-end-time').val();
      var eventDescription = $('#edit-event-description').val();
      var eventTheme = $('#edit-event-theme').val();
      var eventStartTimeCheck = eventStartTime ? 'T' + eventStartTime + 'Z' : '';
      var eventEndTimeCheck = eventEndTime ? 'T' + eventEndTime + 'Z' : '';
      var selectEvent = calendar.getEventById(editEventForm[0].dataset.id);
      selectEvent.remove();
      deleteFromLocalStorage(selectEvent)

      var id = editEventForm[0].dataset.id;
      calendar.addEvent({
        id: id,
        title: eventTitle,
        start: eventStartDate + eventStartTimeCheck,
        end: eventEndDate + eventEndTimeCheck,
        className: "fc-" + eventTheme,
        description: eventDescription
      });

      const obj = {
        'id': id,
        'title': eventTitle,
        'start': eventStartDate + eventStartTimeCheck,
        'end': eventEndDate + eventEndTimeCheck,
        'className': "fc-" + eventTheme,
        'description': eventDescription
      }
      saveInLocalStorage(obj);
      editEventPopup.modal('hide');
    });

    deleteEventBtn.on("click", function (e) {
      e.preventDefault();
      var selectEvent = calendar.getEventById(editEventForm[0].dataset.id);
      selectEvent.remove();
      deleteFromLocalStorage(selectEvent)
    });
    
    //suport event

    function saveInLocalStorage(obj){
      const dataExist = window.localStorage.getItem('calendar');
      if(dataExist){
        var parseJson = JSON.parse(dataExist);
        parseJson.push(obj)
        window.localStorage.setItem('calendar',JSON.stringify(parseJson));
      }
      else{
        var arrayObject = [];
        arrayObject.push(obj)

        window.localStorage.setItem('calendar',JSON.stringify(arrayObject));
      }
    }

    function deleteFromLocalStorage(selectEvent){

      let event_id = selectEvent._def.publicId;


      let dataExist = window.localStorage.getItem('calendar');
      if(dataExist){

        let parseJson = JSON.parse(dataExist);

        //find index
        let filtered  = parseJson.filter(item => item.id != `${event_id}`);


        window.localStorage.setItem('calendar',JSON.stringify(filtered));
      }
    }

    function getTime() {
      var now     = new Date(); 
      var hour    = now.getHours();
      var minute  = now.getMinutes();
      var second  = now.getSeconds(); 
      if(hour.toString().length == 1) {
           hour = '0'+hour;
      }
      if(minute.toString().length == 1) {
           minute = '0'+minute;
      }
      if(second.toString().length == 1) {
           second = '0'+second;
      }   
      var dateTime =  'T'+hour+':'+minute+':'+second;   
      return dateTime;
    }

    var MyLib = {
      //Max id guaranted to be unique will be 999 999 999. 
      //Add more zeros to increase the value.
      lastUid : 100000000, 
  
      generateUid : function(){
          this.lastUid++;
  
          //Way to get a random int value betwen min and max: 
          //Math.floor(Math.random() * (max - min) ) + min;
          var randValue = Math.floor(Math.random() * (99999 - 10000)) + 10000;
  
          return Number(this.lastUid.toString() + randValue);
      }
  };
    //idk :(
    function removePopover() {
      var fcPopover = document.querySelectorAll('.event-popover');
      fcPopover.forEach(function (elm) {
        elm.remove();
      });
    }
    function to12(time) {
      time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
      if (time.length > 1) {
        time = time.slice(1);
        time.pop();
        time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
        time[0] = +time[0] % 12 || 12;
      }
      time = time.join('');
      return time;
    }
    function customCalSelect(cat) {
      if (!cat.id) {
        return cat.text;
      }
      var $cat = $('<span class="fc-' + cat.element.value + '"> <span class="dot"></span>' + cat.text + '</span>');
      return $cat;
    }
    ;
    function removePopover() {
      var fcPopover = document.querySelectorAll('.event-popover');
      fcPopover.forEach(function (elm) {
        elm.remove();
      });
    }
    NioApp.Select2('.select-calendar-theme', {
      templateResult: customCalSelect
    });
    addEventPopup.on('hidden.bs.modal', function (e) {
      setTimeout(function () {
        $('#addEventForm input,#addEventForm textarea').val('');
        $('#event-theme').val('event-primary');
        $('#event-theme').trigger('change.select2');
      }, 1000);
    });
    previewEventPopup.on('hidden.bs.modal', function (e) {
      $('#preview-event-header').removeClass().addClass('modal-header');
    });
  };
  NioApp.coms.docReady.push(NioApp.Calendar);
}(NioApp, jQuery);