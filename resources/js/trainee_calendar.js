(function($, undefined) {
    var defaults = {
        defaultView: 'month',
        aspectRatio: 1.35,
        header: {
            left: 'title',
            center: '',
            right: 'today prev,next'
        },
        weekends: true,
        weekNumbers: false,
        weekNumberCalculation: 'iso',
        weekNumberTitle: 'W',
        allDayDefault: true,
        ignoreTimezone: true,
        lazyFetching: true,
        startParam: 'start',
        endParam: 'end',
        titleFormat: {
            month: 'MMMM yyyy',
            week: "MMM d[ yyyy]{ '—'[ MMM] d yyyy}",
            day: 'dddd, MMM d, yyyy'
        },
        columnFormat: {
            month: 'ddd',
            week: 'ddd M/d',
            day: 'dddd M/d'
        },
        timeFormat: { // for event elements
            '': 'h(:mm)t' // default
        },
        isRTL: false,
        firstDay: 0,
        monthNames: ['January','February','March','April','May','June','July','August','September','October','November','December'],
        monthNamesShort: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        dayNames: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
        dayNamesShort: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
        buttonText: {
            prev: "<span class='fc-text-arrow'>‹</span>",
            next: "<span class='fc-text-arrow'>›</span>",
            prevYear: "<span class='fc-text-arrow'>«</span>",
            nextYear: "<span class='fc-text-arrow'>»</span>",
            today: 'today',
        },
        theme: false,
        buttonIcons: {
            prev: 'circle-triangle-w',
            next: 'circle-triangle-e'
        },
        unselectAuto: true,
        dropAccept: '*',
        handleWindowResize: true
    };
    var rtlDefaults = {
        header: {
            left: 'next,prev today',
            center: '',
            right: 'title'
        },
        buttonText: {
            prev: "<span class='fc-text-arrow'>›</span>",
            next: "<span class='fc-text-arrow'>‹</span>",
            prevYear: "<span class='fc-text-arrow'>»</span>",
            nextYear: "<span class='fc-text-arrow'>«</span>"
        },
        buttonIcons: {
            prev: 'circle-triangle-e',
            next: 'circle-triangle-w'
        }
    };
    var fc = $.fullCalendar = { version: "1.6.4" };
    var fcViews = fc.views = {};

    $.fn.fullCalendar = function(options) {
        if (typeof options == 'string') {
            var args = Array.prototype.slice.call(arguments, 1);
            var res;

            this.each(function() {
                var calendar = $.data(this, 'fullCalendar');

                if (calendar && $.isFunction(calendar[options])) {
                    var r = calendar[options].apply(calendar, args);

                    if (res === undefined) {
                        res = r;
                    }
                    if (options == 'destroy') {
                        $.removeData(this, 'fullCalendar');
                    }
                }
            });

            if (res !== undefined) {
                return res;
            }

            return this;
        }
        options = options || {};
        var eventSources = options.eventSources || [];
        delete options.eventSources;

        if (options.events) {
            eventSources.push(options.events);
            delete options.events;
        }
        options = $.extend(true, {},
            defaults,
            (options.isRTL || options.isRTL===undefined && defaults.isRTL) ? rtlDefaults : {},
            options
        );

        this.each(function(i, _element) {
            var element = $(_element);
            var calendar = new Calendar(element, options, eventSources);
            element.data('fullCalendar', calendar); // TODO: look into memory leak implications
            calendar.render();
        });

        return this;

    };

    function setDefaults(d) {
        $.extend(true, defaults, d);
    }

    function Calendar(element, options, eventSources) {
        var t = this;
        t.options = options;
        t.render = render;
        t.destroy = destroy;
        t.refetchEvents = refetchEvents;
        t.reportEvents = reportEvents;
        t.reportEventChange = reportEventChange;
        t.rerenderEvents = rerenderEvents;
        t.changeView = changeView;
        t.select = select;
        t.prev = prev;
        t.next = next;
        t.prevYear = prevYear;
        t.nextYear = nextYear;
        t.today = today;
        t.incrementDate = incrementDate;
        t.formatDate = function(format, date) {
            return formatDate(format, date, options)
        };
        t.formatDates = function(format, date1, date2) {
            return formatDates(format, date1, date2, options)
        };
        t.getDate = getDate;
        t.getView = getView;
        t.option = option;
        t.trigger = trigger;
        EventManager.call(t, options, eventSources);
        var isFetchNeeded = t.isFetchNeeded;
        var fetchEvents = t.fetchEvents;
        var _element = element[0];
        var header;
        var headerElement;
        var content;
        var tm;
        var currentView;
        var elementOuterWidth;
        var suggestedViewHeight;
        var resizeUID = 0;
        var ignoreWindowResize = 0;
        var date = new Date();
        var events = [];
        var _dragElement;
        setYMD(date, options.year, options.month, options.date);

        function render(inc) {
            if (!content) {
                initialRender();
            } else if (elementVisible()) {
                // mainly for the public API
                calcSize();
                _renderView(inc);
            }
        }

        function initialRender() {
            tm = options.theme ? 'ui' : 'fc';
            element.addClass('fc');

            if (options.isRTL) {
                element.addClass('fc-rtl');
            } else {
                element.addClass('fc-ltr');
            }
            if (options.theme) {
                element.addClass('ui-widget');
            }
            content = $("<div class='fc-content' style='position:relative'/>")
                .prependTo(element);
            header = new Header(t, options);
            headerElement = header.render();

            if (headerElement) {
                element.prepend(headerElement);
            }
            changeView(options.defaultView);

            if (options.handleWindowResize) {
                $(window).resize(windowResize);
            }
            if (!bodyVisible()) {
                lateRender();
            }
        }

        function lateRender() {
            setTimeout(function() {
                if (!currentView.start && bodyVisible()) {
                    renderView();
                }
            },0);
        }

        function destroy() {
            if (currentView) {
                trigger('viewDestroy', currentView, currentView, currentView.element);
            }

            $(window).unbind('resize', windowResize);
            header.destroy();
            content.remove();
            element.removeClass('fc fc-rtl ui-widget');
        }

        function elementVisible() {
            return element.is(':visible');
        }

        function bodyVisible() {
            return $('body').is(':visible');
        }

        function changeView(newViewName) {
            if (!currentView || newViewName != currentView.name) {
                _changeView(newViewName);
            }
        }

        function _changeView(newViewName) {
            ignoreWindowResize++;

            if (currentView) {
                trigger('viewDestroy', currentView, currentView, currentView.element);
                freezeContentHeight();
                currentView.element.remove();
                header.deactivateButton(currentView.name);
            }

            header.activateButton(newViewName);
            currentView = new fcViews[newViewName](
                $("<div class='fc-view fc-view-" + newViewName + "' style='position:relative'/>")
                    .appendTo(content), t
            );
            renderView();
            unfreezeContentHeight();
            ignoreWindowResize--;
        }

        function renderView(inc) {
            if (
                !currentView.start ||
                inc || date < currentView.start || date >= currentView.end
            ) {
                if (elementVisible()) {
                    _renderView(inc);
                }
            }
        }

        function _renderView(inc) {
            ignoreWindowResize++;

            if (currentView.start) {
                trigger('viewDestroy', currentView, currentView, currentView.element);
                clearEvents();
            }

            freezeContentHeight();
            currentView.render(date, inc || 0);
            setSize();
            unfreezeContentHeight();
            (currentView.afterRender || noop)();
            updateTitle();
            updateTodayButton();
            trigger('viewRender', currentView, currentView, currentView.element);
            currentView.trigger('viewDisplay', _element);
            ignoreWindowResize--;
            getAndRenderEvents();
        }

        function updateSize() {
            if (elementVisible()) {
                clearEvents();
                calcSize();
                setSize();
                renderEvents();
            }
        }

        function calcSize() {
            if (options.contentHeight) {
                suggestedViewHeight = options.contentHeight;
            } else if (options.height) {
                suggestedViewHeight = options.height - (headerElement ? headerElement.height() : 0) - vsides(content);
            } else {
                suggestedViewHeight = Math.round(content.width() / Math.max(options.aspectRatio, .5));
            }
        }

        function setSize() {

            if (suggestedViewHeight === undefined) {
                calcSize();
            }

            ignoreWindowResize++;
            currentView.setHeight(suggestedViewHeight);
            currentView.setWidth(content.width());
            ignoreWindowResize--;
            elementOuterWidth = element.outerWidth();
        }


        function windowResize() {
            if (!ignoreWindowResize) {
                if (currentView.start) {
                    var uid = ++resizeUID;
                    setTimeout(function() { // add a delay
                        if (uid == resizeUID && !ignoreWindowResize && elementVisible()) {
                            if (elementOuterWidth != (elementOuterWidth = element.outerWidth())) {
                                ignoreWindowResize++;
                                updateSize();
                                currentView.trigger('windowResize', _element);
                                ignoreWindowResize--;
                            }
                        }
                    }, 200);
                }else{
                    lateRender();
                }
            }
        }

        function refetchEvents() {
            clearEvents();
            fetchAndRenderEvents();
        }

        function rerenderEvents(modifiedEventID) {
            clearEvents();
            renderEvents(modifiedEventID);
        }

        function renderEvents(modifiedEventID) {
            if (elementVisible()) {
                currentView.setEventData(events);
                currentView.renderEvents(events, modifiedEventID);
                currentView.trigger('eventAfterAllRender');
            }
        }

        function clearEvents() {
            currentView.clearEvents();
        }

        function getAndRenderEvents() {
            if (!options.lazyFetching || isFetchNeeded(currentView.visStart, currentView.visEnd)) {
                fetchAndRenderEvents();
            }
            else {
                renderEvents();
            }
        }

        function fetchAndRenderEvents() {
            fetchEvents(currentView.visStart, currentView.visEnd);
        }

        function reportEvents(_events) {
            events = _events;
            renderEvents();
        }

        function reportEventChange(eventID) {
            rerenderEvents(eventID);
        }

        function updateTitle() {
            header.updateTitle(currentView.title);
        }

        function updateTodayButton() {
            var today = new Date();

            if (today >= currentView.start && today < currentView.end) {
                header.disableButton('today');
            } else {
                header.enableButton('today');
            }
        }

        function select(start, end, allDay) {
            currentView.select(start, end, allDay===undefined ? true : allDay);
        }

        function prev() {
            renderView(-1);
        }

        function next() {
            renderView(1);
        }

        function prevYear() {
            addYears(date, -1);
            renderView();
        }

        function nextYear() {
            addYears(date, 1);
            renderView();
        }

        function today() {
            date = new Date();
            renderView();
        }

        function incrementDate(years, months, days) {
            if (years !== undefined) {
                addYears(date, years);
            }
            if (months !== undefined) {
                addMonths(date, months);
            }
            if (days !== undefined) {
                addDays(date, days);
            }
            renderView();
        }

        function getDate() {
            return cloneDate(date);
        }

        function freezeContentHeight() {
            content.css({
                width: '100%',
                height: content.height(),
                overflow: 'hidden'
            });
        }

        function unfreezeContentHeight() {
            content.css({
                width: '',
                height: '',
                overflow: ''
            });
        }

        function getView() {
            return currentView;
        }

        function option(name, value) {
            if (value === undefined) {
                return options[name];
            }
            if (name == 'height' || name == 'contentHeight' || name == 'aspectRatio') {
                options[name] = value;
                updateSize();
            }
        }

        function trigger(name, thisObj) {
            if (options[name]) {
                return options[name].apply(
                    thisObj || _element,
                    Array.prototype.slice.call(arguments, 2)
                );
            }
        }

        if (options.droppable) {
            $(document)
                .bind('dragstart', function(ev, ui) {
                    var _e = ev.target;
                    var e = $(_e);

                    if (!e.parents('.fc').length) { // not already inside a calendar
                        var accept = options.dropAccept;

                        if ($.isFunction(accept) ? accept.call(_e, e) : e.is(accept)) {
                            _dragElement = _e;
                            currentView.dragStart(_dragElement, ev, ui);
                        }
                    }
                })
                .bind('dragstop', function(ev, ui) {
                    if (_dragElement) {
                        _dragElement = null;
                    }
                });
        }
    }

    function Header(calendar, options) {
        var t = this;
        t.render = render;
        t.destroy = destroy;
        t.updateTitle = updateTitle;
        t.activateButton = activateButton;
        t.deactivateButton = deactivateButton;
        t.disableButton = disableButton;
        t.enableButton = enableButton;
        var element = $([]);
        var tm;

        function render() {
            tm = options.theme ? 'ui' : 'fc';
            var sections = options.header;

            if (sections) {
                element = $("<table class='fc-header' style='width:100%'/>")
                    .append(
                        $("<tr/>")
                            .append(renderSection('left'))
                            .append(renderSection('right'))
                    );

                return element;
            }
        }

        function destroy() {
            element.remove();
        }

        function renderSection(position) {
            var e = $("<td class='fc-header-" + position + "'/>");
            var buttonStr = options.header[position];

            if (buttonStr) {
                $.each(buttonStr.split(' '), function(i) {
                    if (i > 0) {
                        e.append("<span class='fc-header-space'/>");
                    }
                    var prevButton;
                    $.each(this.split(','), function(j, buttonName) {
                        if (buttonName == 'title') {
                            e.append("<span class='fc-header-title'><h2> </h2></span>");
                            if (prevButton) {
                                prevButton.addClass(tm + '-corner-right');
                            }
                            prevButton = null;
                        } else {
                            var buttonClick;
                            if (calendar[buttonName]) {
                                buttonClick = calendar[buttonName];
                            } else if (fcViews[buttonName]) {
                                buttonClick = function() {
                                    button.removeClass(tm + '-state-hover');
                                    calendar.changeView(buttonName);
                                };
                            }
                            if (buttonClick) {
                                var icon = options.theme ? smartProperty(options.buttonIcons, buttonName) : null;
                                var text = smartProperty(options.buttonText, buttonName);
                                var button = $(
                                    "<span class='fc-button fc-button-" + buttonName + " " + tm + "-state-default'>" +
                                    (icon ?
                                            "<span class='fc-icon-wrap'>" +
                                            "<span class='ui-icon ui-icon-" + icon + "'/>" +
                                            "</span>" :
                                            text
                                    ) +
                                    "</span>"
                                )
                                    .click(function() {
                                        if (!button.hasClass(tm + '-state-disabled')) {
                                            buttonClick();
                                        }
                                    })
                                    .mousedown(function() {
                                        button
                                            .not('.' + tm + '-state-active')
                                            .not('.' + tm + '-state-disabled')
                                            .addClass(tm + '-state-down');
                                    })
                                    .mouseup(function() {
                                        button.removeClass(tm + '-state-down');
                                    })
                                    .hover(
                                        function() {
                                            button
                                                .not('.' + tm + '-state-active')
                                                .not('.' + tm + '-state-disabled')
                                                .addClass(tm + '-state-hover');
                                        },
                                        function() {
                                            button
                                                .removeClass(tm + '-state-hover')
                                                .removeClass(tm + '-state-down');
                                        }
                                    )
                                    .appendTo(e);
                                disableTextSelection(button);
                                if (!prevButton) {
                                    button.addClass(tm + '-corner-left');
                                }
                                prevButton = button;
                            }
                        }
                    });
                    if (prevButton) {
                        prevButton.addClass(tm + '-corner-right');
                    }
                });
            }

            return e;
        }

        function updateTitle(html) {
            element.find('h2')
                .html(html);
        }

        function activateButton(buttonName) {
            element.find('span.fc-button-' + buttonName)
                .addClass(tm + '-state-active');
        }

        function deactivateButton(buttonName) {
            element.find('span.fc-button-' + buttonName)
                .removeClass(tm + '-state-active');
        }

        function disableButton(buttonName) {
            element.find('span.fc-button-' + buttonName)
                .addClass(tm + '-state-disabled');
        }

        function enableButton(buttonName) {
            element.find('span.fc-button-' + buttonName)
                .removeClass(tm + '-state-disabled');
        }

    }

    fc.sourceNormalizers = [];
    fc.sourceFetchers = [];

    var ajaxDefaults = {
        dataType: 'json',
        cache: false
    };

    var eventGUID = 1;

    function EventManager(options, _sources) {
        var t = this;
        t.isFetchNeeded = isFetchNeeded;
        t.fetchEvents = fetchEvents;
        t.addEventSource = addEventSource;
        t.renderEvent = renderEvent;
        t.normalizeEvent = normalizeEvent;
        var trigger = t.trigger;
        var getView = t.getView;
        var reportEvents = t.reportEvents;
        var stickySource = { events: [] };
        var sources = [ stickySource ];
        var rangeStart, rangeEnd;
        var currentFetchID = 0;
        var pendingSourceCnt = 0;
        var loadingLevel = 0;
        var cache = [];

        for (var i=0; i<_sources.length; i++) {
            _addEventSource(_sources[i]);
        }

        function isFetchNeeded(start, end) {
            return !rangeStart || start < rangeStart || end > rangeEnd;
        }

        function fetchEvents(start, end) {
            rangeStart = start;
            rangeEnd = end;
            cache = [];
            var fetchID = ++currentFetchID;
            var len = sources.length;
            pendingSourceCnt = len;
            for (var i=0; i<len; i++) {
                fetchEventSource(sources[i], fetchID);
            }
        }

        function fetchEventSource(source, fetchID) {
            _fetchEventSource(source, function(events) {
                if (fetchID == currentFetchID) {
                    if (events) {
                        if (options.eventDataTransform) {
                            events = $.map(events, options.eventDataTransform);
                        }
                        if (source.eventDataTransform) {
                            events = $.map(events, source.eventDataTransform);
                        }
                        for (var i=0; i<events.length; i++) {
                            events[i].source = source;
                            normalizeEvent(events[i]);
                        }
                        cache = cache.concat(events);
                    }
                    pendingSourceCnt--;
                    if (!pendingSourceCnt) {
                        reportEvents(cache);
                    }
                }
            });
        }

        function _fetchEventSource(source, callback) {
            var i;
            var fetchers = fc.sourceFetchers;
            var res;
            for (i=0; i<fetchers.length; i++) {
                res = fetchers[i](source, rangeStart, rangeEnd, callback);
                if (res === true) {
                    return;
                } else if (typeof res == 'object') {
                    _fetchEventSource(res, callback);
                    return;
                }
            }
            var events = source.events;
            if (events) {
                if ($.isFunction(events)) {
                    pushLoading();
                    events(cloneDate(rangeStart), cloneDate(rangeEnd), function(events) {
                        callback(events);
                        popLoading();
                    });
                } else if ($.isArray(events)) {
                    callback(events);
                } else {
                    callback();
                }
            }else{
                var url = source.url;
                if (url) {
                    var success = source.success;
                    var error = source.error;
                    var complete = source.complete;
                    var customData;
                    if ($.isFunction(source.data)) {
                        customData = source.data();
                    } else {
                        customData = source.data;
                    }

                    var data = $.extend({}, customData || {});
                    var startParam = firstDefined(source.startParam, options.startParam);
                    var endParam = firstDefined(source.endParam, options.endParam);

                    if (startParam) {
                        data[startParam] = Math.round(+rangeStart / 1000);
                    }
                    if (endParam) {
                        data[endParam] = Math.round(+rangeEnd / 1000);
                    }
                    pushLoading();
                    $.ajax($.extend({}, ajaxDefaults, source, {
                        data: data,
                        success: function(events) {
                            events = events || [];
                            var res = applyAll(success, this, arguments);
                            if ($.isArray(res)) {
                                events = res;
                            }
                            callback(events);
                        },
                        error: function() {
                            applyAll(error, this, arguments);
                            callback();
                        },
                        complete: function() {
                            applyAll(complete, this, arguments);
                            popLoading();
                        }
                    }));
                }else{
                    callback();
                }
            }
        }

        function addEventSource(source) {
            source = _addEventSource(source);
            if (source) {
                pendingSourceCnt++;
                fetchEventSource(source, currentFetchID);
            }
        }

        function _addEventSource(source) {
            if ($.isFunction(source) || $.isArray(source)) {
                source = { events: source };
            } else if (typeof source == 'string') {
                source = { url: source };
            }
            if (typeof source == 'object') {
                normalizeSource(source);
                sources.push(source);

                return source;
            }
        }

        function renderEvent(event, stick) {
            normalizeEvent(event);
            if (!event.source) {
                if (stick) {
                    stickySource.events.push(event);
                    event.source = stickySource;
                }
                cache.push(event);
            }
            reportEvents(cache);
        }

        function pushLoading() {
            if (!loadingLevel++) {
                trigger('loading', null, true, getView());
            }
        }

        function popLoading() {
            if (!--loadingLevel) {
                trigger('loading', null, false, getView());
            }
        }

        function normalizeEvent(event) {
            var source = event.source || {};
            var ignoreTimezone = firstDefined(source.ignoreTimezone, options.ignoreTimezone);
            event._id = event._id || (event.id === undefined ? '_fc' + eventGUID++ : event.id + '');

            if (event.date) {
                if (!event.start) {
                    event.start = event.date;
                }
                delete event.date;
            }
            event._start = cloneDate(event.start = parseDate(event.start, ignoreTimezone));
            event.end = parseDate(event.end, ignoreTimezone);

            if (event.end && event.end <= event.start) {
                event.end = null;
            }
            event._end = event.end ? cloneDate(event.end) : null;

            if (event.allDay === undefined) {
                event.allDay = firstDefined(source.allDayDefault, options.allDayDefault);
            }
            if (event.className) {
                if (typeof event.className == 'string') {
                    event.className = event.className.split(/\s+/);
                }
            } else {
                event.className = [];
            }
        }

        function normalizeSource(source) {
            if (source.className) {
                if (typeof source.className == 'string') {
                    source.className = source.className.split(/\s+/);
                }
            } else {
                source.className = [];
            }
            var normalizers = fc.sourceNormalizers;

            for (var i=0; i<normalizers.length; i++) {
                normalizers[i](source);
            }
        }

        function isSourcesEqual(source1, source2) {
            return source1 && source2 && getSourcePrimitive(source1) == getSourcePrimitive(source2);
        }

        function getSourcePrimitive(source) {
            return ((typeof source == 'object') ? (source.events || source.url) : '') || source;
        }

    }

    fc.addDays = addDays;
    fc.cloneDate = cloneDate;
    fc.parseDate = parseDate;
    fc.parseTime = parseTime;
    fc.formatDate = formatDate;
    fc.formatDates = formatDates;
    var dayIDs = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'],
        DAY_MS = 86400000,
        HOUR_MS = 3600000,
        MINUTE_MS = 60000;

    function addYears(d, n, keepTime) {
        d.setFullYear(d.getFullYear() + n);

        if (!keepTime) {
            clearTime(d);
        }

        return d;
    }

    function addMonths(d, n, keepTime) {
        if (+d) {
            var m = d.getMonth() + n,
                check = cloneDate(d);
            check.setDate(1);
            check.setMonth(m);
            d.setMonth(m);

            if (!keepTime) {
                clearTime(d);
            }
            while (d.getMonth() != check.getMonth()) {
                d.setDate(d.getDate() + (d < check ? 1 : -1));
            }
        }

        return d;
    }

    function addDays(d, n, keepTime) {
        if (+d) {
            var dd = d.getDate() + n,
                check = cloneDate(d);
            check.setHours(9);
            check.setDate(dd);
            d.setDate(dd);

            if (!keepTime) {
                clearTime(d);
            }
            fixDate(d, check);
        }

        return d;
    }

    function fixDate(d, check) {
        if (+d) {
            while (d.getDate() != check.getDate()) {
                d.setTime(+d + (d < check ? 1 : -1) * HOUR_MS);
            }
        }
    }

    function addMinutes(d, n) {
        d.setMinutes(d.getMinutes() + n);

        return d;
    }

    function clearTime(d) {
        d.setHours(0);
        d.setMinutes(0);
        d.setSeconds(0);
        d.setMilliseconds(0);

        return d;
    }

    function cloneDate(d, dontKeepTime) {
        if (dontKeepTime) {
            return clearTime(new Date(+d));
        }

        return new Date(+d);
    }

    function zeroDate() {
        var i=0, d;
        do {
            d = new Date(1970, i++, 1);
        } while (d.getHours()); // != 0

        return d;
    }

    function dayDiff(d1, d2) { // d1 - d2
        return Math.round((cloneDate(d1, true) - cloneDate(d2, true)) / DAY_MS);
    }

    function setYMD(date, y, m, d) {
        if (y !== undefined && y != date.getFullYear()) {
            date.setDate(1);
            date.setMonth(0);
            date.setFullYear(y);
        }
        if (m !== undefined && m != date.getMonth()) {
            date.setDate(1);
            date.setMonth(m);
        }
        if (d !== undefined) {
            date.setDate(d);
        }
    }

    function parseDate(s, ignoreTimezone) {
        if (typeof s == 'object') {
            return s;
        }
        if (typeof s == 'number') {
            return new Date(s * 1000);
        }
        if (typeof s == 'string') {
            if (s.match(/^\d+(\.\d+)?$/)) {
                return new Date(parseFloat(s) * 1000);
            }
            if (ignoreTimezone === undefined) {
                ignoreTimezone = true;
            }
        }

        return null;
    }

    function parseTime(s) {
        if (typeof s == 'number') {
            return s * 60;
        }
        if (typeof s == 'object') {
            return s.getHours() * 60 + s.getMinutes();
        }
        var m = s.match(/(\d+)(?::(\d+))?\s*(\w+)?/);
        if (m) {
            var h = parseInt(m[1], 10);
            if (m[3]) {
                h %= 12;

                if (m[3].toLowerCase().charAt(0) == 'p') {
                    h += 12;
                }
            }

            return h * 60 + (m[2] ? parseInt(m[2], 10) : 0);
        }
    }

    function formatDate(date, format, options) {
        return formatDates(date, null, format, options);
    }


    function formatDates(date1, date2, format, options) {
        options = options || defaults;
        var date = date1,
            otherDate = date2,
            i, len = format.length, c,
            i2, formatter,
            res = '';
        for (i=0; i<len; i++) {
            c = format.charAt(i);
            if (c == "'") {
                for (i2=i+1; i2<len; i2++) {
                    if (format.charAt(i2) == "'") {
                        if (date) {
                            if (i2 == i+1) {
                                res += "'";
                            }else{
                                res += format.substring(i+1, i2);
                            }
                            i = i2;
                        }
                        break;
                    }
                }
            } else if (c == '(') {
                for (i2=i+1; i2<len; i2++) {
                    if (format.charAt(i2) == ')') {
                        var subres = formatDate(date, format.substring(i+1, i2), options);

                        if (parseInt(subres.replace(/\D/, ''), 10)) {
                            res += subres;
                        }
                        i = i2;
                        break;
                    }
                }
            } else if (c == '[') {
                for (i2=i+1; i2<len; i2++) {
                    if (format.charAt(i2) == ']') {
                        var subformat = format.substring(i+1, i2);
                        var subres = formatDate(date, subformat, options);

                        if (subres != formatDate(otherDate, subformat, options)) {
                            res += subres;
                        }
                        i = i2;
                        break;
                    }
                }
            } else if (c == '{') {
                date = date2;
                otherDate = date1;
            } else if (c == '}') {
                date = date1;
                otherDate = date2;
            } else {
                for (i2=len; i2>i; i2--) {
                    if (formatter = dateFormatters[format.substring(i, i2)]) {
                        if (date) {
                            res += formatter(date, options);
                        }
                        i = i2 - 1;
                        break;
                    }
                }
                if (i2 == i) {
                    if (date) {
                        res += c;
                    }
                }
            }
        }

        return res;
    };

    var dateFormatters = {
        s	: function(d)	{ return d.getSeconds() },
        ss	: function(d)	{ return zeroPad(d.getSeconds()) },
        m	: function(d)	{ return d.getMinutes() },
        mm	: function(d)	{ return zeroPad(d.getMinutes()) },
        h	: function(d)	{ return d.getHours() % 12 || 12 },
        hh	: function(d)	{ return zeroPad(d.getHours() % 12 || 12) },
        H	: function(d)	{ return d.getHours() },
        HH	: function(d)	{ return zeroPad(d.getHours()) },
        d	: function(d)	{ return d.getDate() },
        dd	: function(d)	{ return zeroPad(d.getDate()) },
        ddd	: function(d,o)	{ return o.dayNamesShort[d.getDay()] },
        dddd: function(d,o)	{ return o.dayNames[d.getDay()] },
        M	: function(d)	{ return d.getMonth() + 1 },
        MM	: function(d)	{ return zeroPad(d.getMonth() + 1) },
        MMM	: function(d,o)	{ return o.monthNamesShort[d.getMonth()] },
        MMMM: function(d,o)	{ return o.monthNames[d.getMonth()] },
        yy	: function(d)	{ return (d.getFullYear()+'').substring(2) },
        yyyy: function(d)	{ return d.getFullYear() },
        t	: function(d)	{ return d.getHours() < 12 ? 'a' : 'p' },
        tt	: function(d)	{ return d.getHours() < 12 ? 'am' : 'pm' },
        T	: function(d)	{ return d.getHours() < 12 ? 'A' : 'P' },
        TT	: function(d)	{ return d.getHours() < 12 ? 'AM' : 'PM' },
        u	: function(d)	{ return formatDate(d, "yyyy-MM-dd'T'HH:mm:ss'Z'") },
        S	: function(d)	{
            var date = d.getDate();

            if (date > 10 && date < 20) {
                return 'th';
            }

            return ['st', 'nd', 'rd'][date%10-1] || 'th';
        },
        w   : function(d, o) {
            return o.weekNumberCalculation(d);
        },
    };
    fc.dateFormatters = dateFormatters;

    fc.applyAll = applyAll;

    function exclEndDay(event) {
        if (event.end) {
            return _exclEndDay(event.end, event.allDay);
        } else {
            return addDays(cloneDate(event.start), 1);
        }
    }

    function _exclEndDay(end, allDay) {
        end = cloneDate(end);

        return allDay || end.getHours() || end.getMinutes() ? addDays(end, 1) : clearTime(end);
    }

    function setOuterWidth(element, width, includeMargins) {
        for (var i=0, e; i<element.length; i++) {
            e = $(element[i]);
            e.width(Math.max(0, width - hsides(e, includeMargins)));
        }
    }

    function setOuterHeight(element, height, includeMargins) {
        for (var i=0, e; i<element.length; i++) {
            e = $(element[i]);
            e.height(Math.max(0, height - vsides(e, includeMargins)));
        }
    }

    function hsides(element, includeMargins) {
        return hpadding(element) + hborders(element) + (includeMargins ? hmargins(element) : 0);
    }

    function hpadding(element) {
        return (parseFloat($.css(element[0], 'paddingLeft', true)) || 0) +
            (parseFloat($.css(element[0], 'paddingRight', true)) || 0);
    }

    function hmargins(element) {
        return (parseFloat($.css(element[0], 'marginLeft', true)) || 0) +
            (parseFloat($.css(element[0], 'marginRight', true)) || 0);
    }

    function hborders(element) {
        return (parseFloat($.css(element[0], 'borderLeftWidth', true)) || 0) +
            (parseFloat($.css(element[0], 'borderRightWidth', true)) || 0);
    }

    function vsides(element, includeMargins) {
        return vpadding(element) +  vborders(element) + (includeMargins ? vmargins(element) : 0);
    }

    function vpadding(element) {
        return (parseFloat($.css(element[0], 'paddingTop', true)) || 0) +
            (parseFloat($.css(element[0], 'paddingBottom', true)) || 0);
    }

    function vmargins(element) {
        return (parseFloat($.css(element[0], 'marginTop', true)) || 0) +
            (parseFloat($.css(element[0], 'marginBottom', true)) || 0);
    }

    function vborders(element) {
        return (parseFloat($.css(element[0], 'borderTopWidth', true)) || 0) +
            (parseFloat($.css(element[0], 'borderBottomWidth', true)) || 0);
    }

    function noop() { }

    function dateCompare(a, b) {
        return a - b;
    }

    function arrayMax(a) {
        return Math.max.apply(Math, a);
    }

    function zeroPad(n) {
        return (n < 10 ? '0' : '') + n;
    }

    function smartProperty(obj, name) {
        if (obj[name] !== undefined) {
            return obj[name];
        }
        var parts = name.split(/(?=[A-Z])/),
            i=parts.length-1, res;

        for (; i>=0; i--) {
            res = obj[parts[i].toLowerCase()];

            if (res !== undefined) {
                return res;
            }
        }

        return obj[''];
    }

    function htmlEscape(s) {
        return s.replace(/&/g, '&')
            .replace(/</g, '<')
            .replace(/>/g, '>')
            .replace(/'/g, '\'')
            .replace(/"/g, '"')
            .replace(/\n/g, '<br />');
    }

    function disableTextSelection(element) {
        element
            .attr('unselectable', 'on')
            .css('MozUserSelect', 'none')
            .bind('selectstart.ui', function() { return false; });
    }

    function markFirstLast(e) {
        e.children()
            .removeClass('fc-first fc-last')
            .filter(':first-child')
            .addClass('fc-first')
            .end()
            .filter(':last-child')
            .addClass('fc-last');
    }

    function setDayID(cell, date) {
        cell.each(function(i, _cell) {
            _cell.className = _cell.className.replace(/^fc-\w*/, 'fc-' + dayIDs[date.getDay()]);
        });
    }

    function getSkinCss(event, opt) {
        var source = event.source || {};
        var eventColor = event.color;
        var sourceColor = source.color;
        var optionColor = opt('eventColor');
        var backgroundColor =
            event.backgroundColor ||
            eventColor ||
            source.backgroundColor ||
            sourceColor ||
            opt('eventBackgroundColor') ||
            optionColor;
        var borderColor =
            event.borderColor ||
            eventColor ||
            source.borderColor ||
            sourceColor ||
            opt('eventBorderColor') ||
            optionColor;
        var textColor =
            event.textColor ||
            source.textColor ||
            opt('eventTextColor');
        var statements = [];
        if (backgroundColor) {
            statements.push('background-color:' + backgroundColor);
        }
        if (borderColor) {
            statements.push('border-color:' + borderColor);
        }
        if (textColor) {
            statements.push('color:' + textColor);
        }

        return statements.join(';');
    }
    function applyAll(functions, thisObj, args) {
        if ($.isFunction(functions)) {
            functions = [ functions ];
        }
        if (functions) {
            var i;
            var ret;
            for (i=0; i<functions.length; i++) {
                ret = functions[i].apply(thisObj, args) || ret;
            }

            return ret;
        }
    }

    function firstDefined() {
        for (var i=0; i<arguments.length; i++) {
            if (arguments[i] !== undefined) {
                return arguments[i];
            }
        }
    }

    fcViews.month = MonthView;

    function MonthView(element, calendar) {
        var t = this;

        t.render = render;

        BasicView.call(t, element, calendar, 'month');
        var opt = t.opt;
        var renderBasic = t.renderBasic;
        var getCellsPerWeek = t.getCellsPerWeek;
        var formatDate = calendar.formatDate;

        function render(date, delta) {

            if (delta) {
                addMonths(date, delta);
                date.setDate(1);
            }
            var firstDay = opt('firstDay');
            var start = cloneDate(date, true);
            start.setDate(1);
            var end = addMonths(cloneDate(start), 1);
            var visStart = cloneDate(start);
            addDays(visStart, -((visStart.getDay() - firstDay + 7) % 7));
            var visEnd = cloneDate(end);
            addDays(visEnd, (7 - visEnd.getDay() + firstDay) % 7);
            var colCnt = getCellsPerWeek();
            var rowCnt = Math.round(dayDiff(visEnd, visStart) / 7);

            if (opt('weekMode') == 'fixed') {
                addDays(visEnd, (6 - rowCnt) * 7);
                rowCnt = 6;
            }

            t.title = formatDate(start, opt('titleFormat'));
            t.start = start;
            t.end = end;
            t.visStart = visStart;
            t.visEnd = visEnd;
            renderBasic(rowCnt, colCnt, true);
        }

    }

    function BasicView(element, calendar, viewName) {
        var t = this;
        t.renderBasic = renderBasic;
        t.setHeight = setHeight;
        t.setWidth = setWidth;
        t.defaultSelectionEnd = defaultSelectionEnd;
        t.dragStart = dragStart;
        t.defaultEventEnd = defaultEventEnd;
        t.colLeft = colLeft;
        t.colRight = colRight;
        t.colContentLeft = colContentLeft;
        t.colContentRight = colContentRight;
        t.getIsCellAllDay = function() { return true };
        t.allDayRow = allDayRow;
        t.getRowCnt = function() { return rowCnt };
        t.getColCnt = function() { return colCnt };
        t.getColWidth = function() { return colWidth };
        t.getDaySegmentContainer = function() { return daySegmentContainer };
        View.call(t, element, calendar, viewName);
        SelectionManager.call(t);
        BasicEventRenderer.call(t);
        var opt = t.opt;
        var trigger = t.trigger;
        var renderOverlay = t.renderOverlay;
        var clearOverlays = t.clearOverlays;
        var daySelectionMousedown = t.daySelectionMousedown;
        var cellToDate = t.cellToDate;
        var dateToCell = t.dateToCell;
        var rangeToSegments = t.rangeToSegments;
        var formatDate = calendar.formatDate;
        var table;
        var head;
        var headCells;
        var body;
        var bodyRows;
        var bodyCells;
        var bodyFirstCells;
        var firstRowCellInners;
        var firstRowCellContentInners;
        var daySegmentContainer;
        var viewWidth;
        var viewHeight;
        var colWidth;
        var weekNumberWidth;
        var rowCnt, colCnt;
        var showNumbers;
        var coordinateGrid;
        var hoverListener;
        var colPositions;
        var colContentPositions;
        var tm;
        var colFormat;
        var showWeekNumbers;
        var weekNumberTitle;
        var weekNumberFormat;
        disableTextSelection(element.addClass('fc-grid'));

        function renderBasic(_rowCnt, _colCnt, _showNumbers) {
            rowCnt = _rowCnt;
            colCnt = _colCnt;
            showNumbers = _showNumbers;
            updateOptions();

            if (!body) {
                buildEventContainer();
            }

            buildTable();
        }

        function updateOptions() {
            tm = opt('theme') ? 'ui' : 'fc';
            colFormat = opt('columnFormat');
            showWeekNumbers = opt('weekNumbers');
            weekNumberTitle = opt('weekNumberTitle');

            if (opt('weekNumberCalculation') != 'iso') {
                weekNumberFormat = "w";
            } else {
                weekNumberFormat = "W";
            }
        }

        function buildEventContainer() {
            daySegmentContainer =
                $("<div class='fc-event-container' style='position:absolute;z-index:8;top:0;left:0'/>")
                    .appendTo(element);
        }

        function buildTable() {
            var html = buildTableHTML();

            if (table) {
                table.remove();
            }
            table = $(html).appendTo(element);
            head = table.find('thead');
            headCells = head.find('.fc-day-header');
            body = table.find('tbody');
            bodyRows = body.find('tr');
            bodyCells = body.find('.fc-day');
            bodyFirstCells = bodyRows.find('td:first-child');
            firstRowCellInners = bodyRows.eq(0).find('.fc-day > div');
            firstRowCellContentInners = bodyRows.eq(0).find('.fc-day-content > div');
            markFirstLast(head.add(head.find('tr'))); // marks first+last tr/th's
            markFirstLast(bodyRows); // marks first+last td's
            bodyRows.eq(0).addClass('fc-first');
            bodyRows.filter(':last').addClass('fc-last');

            bodyCells.each(function(i, _cell) {
                var date = cellToDate(
                    Math.floor(i / colCnt),
                    i % colCnt
                );
                trigger('dayRender', t, date, $(_cell));
            });
        }

        function buildTableHTML() {
            var html =
                "<table class='fc-border-separate' style='width:100%' cellspacing='0'>" +
                buildHeadHTML() +
                buildBodyHTML() +
                "</table>";

            return html;
        }

        function buildHeadHTML() {
            var headerClass = tm + "-widget-header";
            var html = '';
            var col;
            var date;

            html += "<thead><tr>";

            if (showWeekNumbers) {
                html +=
                    "<th class='fc-week-number " + headerClass + "'>" +
                    htmlEscape(weekNumberTitle) +
                    "</th>";
            }

            for (col=0; col<colCnt; col++) {
                date = cellToDate(0, col);
                html +=
                    "<th class='fc-day-header fc-" + dayIDs[date.getDay()] + " " + headerClass + "'>" +
                    htmlEscape(formatDate(date, colFormat)) +
                    "</th>";
            }

            html += "</tr></thead>";

            return html;
        }

        function buildBodyHTML() {
            var contentClass = tm + "-widget-content";
            var html = '';
            var row;
            var col;
            var date;

            html += "<tbody>";

            for (row=0; row<rowCnt; row++) {
                html += "<tr class='fc-week'>";

                if (showWeekNumbers) {
                    date = cellToDate(row, 0);
                    html +=
                        "<td class='fc-week-number " + contentClass + "'>" +
                        "<div>" +
                        htmlEscape(formatDate(date, weekNumberFormat)) +
                        "</div>" +
                        "</td>";
                }

                for (col=0; col<colCnt; col++) {
                    date = cellToDate(row, col);
                    html += buildCellHTML(date);
                }

                html += "</tr>";
            }
            html += "</tbody>";

            return html;
        }

        function buildCellHTML(date) {
            var contentClass = tm + "-widget-content";
            var month = t.start.getMonth();
            var today = clearTime(new Date());
            var html = '';
            var classNames = [
                'fc-day',
                'fc-' + dayIDs[date.getDay()],
                contentClass
            ];

            if (date.getMonth() != month) {
                classNames.push('fc-other-month');
            }
            if (+date == +today) {
                classNames.push(
                    'fc-today',
                    tm + '-state-highlight'
                );
            } else if (date < today) {
                classNames.push('fc-past');
            } else {
                classNames.push('fc-future');
            }

            html +=
                "<td" +
                " class='" + classNames.join(' ') + "'" +
                " data-date='" + formatDate(date, 'yyyy-MM-dd') + "'" +
                ">" +
                "<div>";

            if (showNumbers) {
                html += "<div class='fc-day-number'>" + date.getDate() + "</div>";
            }

            html +=
                "<div class='fc-day-content'>" +
                "<div style='position:relative'> </div>" +
                "</div>" +
                "</div>" +
                "</td>";

            return html;
        }

        function setHeight(height) {
            viewHeight = height;
            var bodyHeight = viewHeight - head.height();
            var rowHeight;
            var rowHeightLast;
            var cell;

            if (opt('weekMode') == 'variable') {
                rowHeight = rowHeightLast = Math.floor(bodyHeight / (rowCnt==1 ? 2 : 6));
            } else {
                rowHeight = Math.floor(bodyHeight / rowCnt);
                rowHeightLast = bodyHeight - rowHeight * (rowCnt-1);
            }

            bodyFirstCells.each(function(i, _cell) {
                if (i < rowCnt) {
                    cell = $(_cell);
                    cell.find('> div').css(
                        'min-height',
                        (i==rowCnt-1 ? rowHeightLast : rowHeight) - vsides(cell)
                    );
                }
            });
        }

        function setWidth(width) {
            viewWidth = width;
            colPositions.clear();
            colContentPositions.clear();
            weekNumberWidth = 0;

            if (showWeekNumbers) {
                weekNumberWidth = head.find('th.fc-week-number').outerWidth();
            }

            colWidth = Math.floor((viewWidth - weekNumberWidth) / colCnt);
            setOuterWidth(headCells.slice(0, -1), colWidth);
        }

        function renderCellOverlay(row0, col0, row1, col1) { // row1,col1 is inclusive
            var rect = coordinateGrid.rect(row0, col0, row1, col1, element);

            return renderOverlay(rect, element);
        }

        function defaultSelectionEnd(startDate, allDay) {
            return cloneDate(startDate);
        }

        function dragStart(_dragElement, ev, ui) {
            hoverListener.start(function(cell) {
                clearOverlays();

                if (cell) {
                    renderCellOverlay(cell.row, cell.col, cell.row, cell.col);
                }
            }, ev);
        }

        function defaultEventEnd(event) {
            return cloneDate(event.start);
        }

        colPositions = new HorizontalPositionCache(function(col) {
            return firstRowCellInners.eq(col);
        });

        colContentPositions = new HorizontalPositionCache(function(col) {
            return firstRowCellContentInners.eq(col);
        });

        function colLeft(col) {
            return colPositions.left(col);
        }

        function colRight(col) {
            return colPositions.right(col);
        }

        function colContentLeft(col) {
            return colContentPositions.left(col);
        }

        function colContentRight(col) {
            return colContentPositions.right(col);
        }

        function allDayRow(i) {
            return bodyRows.eq(i);
        }
    }

    function BasicEventRenderer() {
        var t = this;
        t.renderEvents = renderEvents;
        t.clearEvents = clearEvents;

        DayEventRenderer.call(t);

        function renderEvents(events, modifiedEventId) {
            t.renderDayEvents(events, modifiedEventId);
        }

        function clearEvents() {
            t.getDaySegmentContainer().empty();
        }
    }

    setDefaults({
        allDaySlot: true,
        allDayText: 'all-day',
        firstHour: 6,
        slotMinutes: 30,
        defaultEventMinutes: 120,
        axisFormat: 'h(:mm)tt',
        timeFormat: {
            agenda: 'h:mm{ - h:mm}'
        },
        dragOpacity: {
            agenda: .5
        },
        minTime: 0,
        maxTime: 24,
        slotEventOverlap: true
    });

    function View(element, calendar, viewName) {
        var t = this;
        t.element = element;
        t.calendar = calendar;
        t.name = viewName;
        t.opt = opt;
        t.trigger = trigger;
        t.setEventData = setEventData;
        t.eventEnd = eventEnd;
        t.showEvents = showEvents;
        t.eventDrop = eventDrop;
        t.eventResize = eventResize;
        var defaultEventEnd = t.defaultEventEnd;
        var normalizeEvent = calendar.normalizeEvent;
        var reportEventChange = calendar.reportEventChange;
        var eventsByID = {};
        var eventElementsByID = {};
        var eventElementCouples = [];
        var options = calendar.options;

        function opt(name, viewNameOverride) {
            var v = options[name];

            if ($.isPlainObject(v)) {
                return smartProperty(v, viewNameOverride || viewName);
            }

            return v;
        }

        function trigger(name, thisObj) {
            return calendar.trigger.apply(
                calendar,
                [name, thisObj || t].concat(Array.prototype.slice.call(arguments, 2), [t])
            );
        }

        function setEventData(events) {
            eventsByID = {};
            var i, len=events.length, event;

            for (i=0; i<len; i++) {
                event = events[i];

                if (eventsByID[event._id]) {
                    eventsByID[event._id].push(event);
                } else {
                    eventsByID[event._id] = [event];
                }
            }
        }

        function eventEnd(event) {
            return event.end ? cloneDate(event.end) : defaultEventEnd(event);
        }

        function showEvents(event, exceptElement) {
            eachEventElement(event, exceptElement, 'show');
        }

        function eachEventElement(event, exceptElement, funcName) {
            var elements = eventElementsByID[event._id],
                i, len = elements.length;

            for (i=0; i<len; i++) {
                if (!exceptElement || elements[i][0] != exceptElement[0]) {
                    elements[i][funcName]();
                }
            }
        }

        function eventDrop(e, event, dayDelta, minuteDelta, allDay, ev, ui) {
            var oldAllDay = event.allDay;
            var eventId = event._id;
            moveEvents(eventsByID[eventId], dayDelta, minuteDelta, allDay);
            trigger(
                'eventDrop',
                e,
                event,
                dayDelta,
                minuteDelta,
                allDay,

                function() {
                    moveEvents(eventsByID[eventId], -dayDelta, -minuteDelta, oldAllDay);
                    reportEventChange(eventId);
                },
                ev,
                ui
            );
            reportEventChange(eventId);
        }


        function eventResize(e, event, dayDelta, minuteDelta, ev, ui) {
            var eventId = event._id;
            elongateEvents(eventsByID[eventId], dayDelta, minuteDelta);
            trigger(
                'eventResize',
                e,
                event,
                dayDelta,
                minuteDelta,

                function() {
                    // TODO: investigate cases where this inverse technique might not work
                    elongateEvents(eventsByID[eventId], -dayDelta, -minuteDelta);
                    reportEventChange(eventId);
                },
                ev,
                ui
            );
            reportEventChange(eventId);
        }

        t.getCellsPerWeek = getCellsPerWeek;
        t.dateToCell = dateToCell;
        t.dateToDayOffset = dateToDayOffset;
        t.dayOffsetToCellOffset = dayOffsetToCellOffset;
        t.cellOffsetToCell = cellOffsetToCell;
        t.cellToDate = cellToDate;
        t.cellToCellOffset = cellToCellOffset;
        t.cellOffsetToDayOffset = cellOffsetToDayOffset;
        t.dayOffsetToDate = dayOffsetToDate;
        t.rangeToSegments = rangeToSegments;
        var hiddenDays = opt('hiddenDays') || [];
        var isHiddenDayHash = [];
        var cellsPerWeek;
        var dayToCellMap = [];
        var cellToDayMap = [];
        var isRTL = opt('isRTL');

        (function() {

            if (opt('weekends') === false) {
                hiddenDays.push(0, 6); // 0=sunday, 6=saturday
            }

            for (var dayIndex=0, cellIndex=0; dayIndex<7; dayIndex++) {
                dayToCellMap[dayIndex] = cellIndex;
                isHiddenDayHash[dayIndex] = $.inArray(dayIndex, hiddenDays) != -1;
                if (!isHiddenDayHash[dayIndex]) {
                    cellToDayMap[cellIndex] = dayIndex;
                    cellIndex++;
                }
            }
            cellsPerWeek = cellIndex;

            if (!cellsPerWeek) {
                throw 'invalid hiddenDays';
            }

        })();

        function getCellsPerWeek() {
            return cellsPerWeek;
        }

        function cellToDate() {
            var cellOffset = cellToCellOffset.apply(null, arguments);
            var dayOffset = cellOffsetToDayOffset(cellOffset);
            var date = dayOffsetToDate(dayOffset);

            return date;
        }

        function cellToCellOffset(row, col) {
            var colCnt = t.getColCnt();
            var dis = isRTL ? -1 : 1;
            var dit = isRTL ? colCnt - 1 : 0;

            if (typeof row == 'object') {
                col = row.col;
                row = row.row;
            }
            var cellOffset = row * colCnt + (col * dis + dit);

            return cellOffset;
        }

        function cellOffsetToDayOffset(cellOffset) {
            var day0 = t.visStart.getDay();
            cellOffset += dayToCellMap[day0];

            return Math.floor(cellOffset / cellsPerWeek) * 7
                + cellToDayMap[ // # of days from partial last week
                (cellOffset % cellsPerWeek + cellsPerWeek) % cellsPerWeek
                    ]
                - day0;
        }

        function dayOffsetToDate(dayOffset) {
            var date = cloneDate(t.visStart);
            addDays(date, dayOffset);

            return date;
        }

        function dateToCell(date) {
            var dayOffset = dateToDayOffset(date);
            var cellOffset = dayOffsetToCellOffset(dayOffset);
            var cell = cellOffsetToCell(cellOffset);

            return cell;
        }

        function dateToDayOffset(date) {
            return dayDiff(date, t.visStart);
        }

        function dayOffsetToCellOffset(dayOffset) {
            var day0 = t.visStart.getDay();
            dayOffset += day0;

            return Math.floor(dayOffset / 7) * cellsPerWeek
                + dayToCellMap[(dayOffset % 7 + 7) % 7]
                - dayToCellMap[day0];
        }

        function cellOffsetToCell(cellOffset) {
            var colCnt = t.getColCnt();
            var dis = isRTL ? -1 : 1;
            var dit = isRTL ? colCnt - 1 : 0;
            var row = Math.floor(cellOffset / colCnt);
            var col = ((cellOffset % colCnt + colCnt) % colCnt) * dis + dit;

            return {
                row: row,
                col: col
            };
        }

        function rangeToSegments(startDate, endDate) {
            var rowCnt = t.getRowCnt();
            var colCnt = t.getColCnt();
            var segments = [];
            var rangeDayOffsetStart = dateToDayOffset(startDate);
            var rangeDayOffsetEnd = dateToDayOffset(endDate);
            var rangeCellOffsetFirst = dayOffsetToCellOffset(rangeDayOffsetStart);
            var rangeCellOffsetLast = dayOffsetToCellOffset(rangeDayOffsetEnd) - 1;

            for (var row=0; row<rowCnt; row++) {
                var rowCellOffsetFirst = row * colCnt;
                var rowCellOffsetLast = rowCellOffsetFirst + colCnt - 1;
                var segmentCellOffsetFirst = Math.max(rangeCellOffsetFirst, rowCellOffsetFirst);
                var segmentCellOffsetLast = Math.min(rangeCellOffsetLast, rowCellOffsetLast);

                if (segmentCellOffsetFirst <= segmentCellOffsetLast) {
                    var segmentCellFirst = cellOffsetToCell(segmentCellOffsetFirst);
                    var segmentCellLast = cellOffsetToCell(segmentCellOffsetLast);
                    var cols = [ segmentCellFirst.col, segmentCellLast.col ].sort();
                    var isStart = cellOffsetToDayOffset(segmentCellOffsetFirst) == rangeDayOffsetStart;
                    var isEnd = cellOffsetToDayOffset(segmentCellOffsetLast) + 1 == rangeDayOffsetEnd;

                    segments.push({
                        row: row,
                        leftCol: cols[0],
                        rightCol: cols[1],
                        isStart: isStart,
                        isEnd: isEnd
                    });
                }
            }

            return segments;
        }
    }

    function DayEventRenderer() {
        var t = this;
        t.renderDayEvents = renderDayEvents;
        t.draggableDayEvent = draggableDayEvent;
        var opt = t.opt;
        var trigger = t.trigger;
        var eventEnd = t.eventEnd;
        var showEvents = t.showEvents;
        var eventDrop = t.eventDrop;
        var eventResize = t.eventResize;
        var getRowCnt = t.getRowCnt;
        var getColCnt = t.getColCnt;
        var getColWidth = t.getColWidth;
        var allDayRow = t.allDayRow; // TODO: rename
        var colLeft = t.colLeft;
        var colRight = t.colRight;
        var colContentLeft = t.colContentLeft;
        var colContentRight = t.colContentRight;
        var dateToCell = t.dateToCell;
        var getDaySegmentContainer = t.getDaySegmentContainer;
        var formatDates = t.calendar.formatDates;
        var clearOverlays = t.clearOverlays;
        var getHoverListener = t.getHoverListener;
        var rangeToSegments = t.rangeToSegments;
        var cellToDate = t.cellToDate;
        var cellToCellOffset = t.cellToCellOffset;
        var cellOffsetToDayOffset = t.cellOffsetToDayOffset;
        var dateToDayOffset = t.dateToDayOffset;
        var dayOffsetToCellOffset = t.dayOffsetToCellOffset;

        function renderDayEvents(events, modifiedEventId) {
            var segments = _renderDayEvents(
                events,
                false,
                true
            );

            segmentElementEach(segments, function(segment, element) {
            });

            attachHandlers(segments, modifiedEventId);

            segmentElementEach(segments, function(segment, element) {
                trigger('eventAfterRender', segment.event, segment.event, element);
            });
        }

        function _renderDayEvents(events, doAppend, doRowHeights) {
            var finalContainer = getDaySegmentContainer();
            var renderContainer = doAppend ? $("<div/>") : finalContainer;
            var segments = buildSegments(events);
            var html;
            var elements;

            calculateHorizontals(segments);

            html = buildHTML(segments);

            renderContainer[0].innerHTML = html;

            elements = renderContainer.children();

            if (doAppend) {
                finalContainer.append(elements);
            }

            resolveElements(segments, elements);

            segmentElementEach(segments, function(segment, element) {
                segment.hsides = hsides(element, true);
            });

            segmentElementEach(segments, function(segment, element) {
                element.width(
                    Math.max(0, segment.outerWidth - segment.hsides)
                );
            });

            segmentElementEach(segments, function(segment, element) {
                segment.outerHeight = element.outerHeight(true);
            });

            setVerticals(segments, doRowHeights);

            return segments;
        }

        function buildSegments(events) {
            var segments = [];

            for (var i=0; i<events.length; i++) {
                var eventSegments = buildSegmentsForEvent(events[i]);
                segments.push.apply(segments, eventSegments);
            }

            return segments;
        }

        function buildSegmentsForEvent(event) {
            var startDate = event.start;
            var endDate = exclEndDay(event);
            var segments = rangeToSegments(startDate, endDate);

            for (var i=0; i<segments.length; i++) {
                segments[i].event = event;
            }

            return segments;
        }

        function calculateHorizontals(segments) {
            var isRTL = opt('isRTL');

            for (var i=0; i<segments.length; i++) {
                var segment = segments[i];
                var leftFunc = (isRTL ? segment.isEnd : segment.isStart) ? colContentLeft : colLeft;
                var rightFunc = (isRTL ? segment.isStart : segment.isEnd) ? colContentRight : colRight;

                var left = leftFunc(segment.leftCol);
                var right = rightFunc(segment.rightCol);
                segment.left = left;
                segment.outerWidth = right - left;
            }
        }

        function buildHTML(segments) {
            var html = '';

            for (var i=0; i<segments.length; i++) {
                html += buildHTMLForSegment(segments[i]);
            }

            return html;
        }

        function buildHTMLForSegment(segment) {
            var html = '';
            var isRTL = opt('isRTL');
            var event = segment.event;
            var url = event.url;
            var classNames = [ 'fc-event', 'fc-event-hori' ];

            if (segment.isStart) {
                classNames.push('fc-event-start');
            }
            if (segment.isEnd) {
                classNames.push('fc-event-end');
            }

            classNames = classNames.concat(event.className);

            if (event.source) {
                classNames = classNames.concat(event.source.className || []);
            }
            var skinCss = getSkinCss(event, opt);

            if (url) {
                html += "<a href='" + htmlEscape(url) + "'";
            } else {
                html += "<div";
            }
            html +=
                " class='" + classNames.join(' ') + "'" +
                " style=" +
                "'" +
                "position:absolute;" +
                "left:" + segment.left + "px;" +
                skinCss +
                "'" +
                ">" +
                "<div class='fc-event-inner'>";

            if (!event.allDay && segment.isStart) {
                html +=
                    "<span class='fc-event-time'>" +
                    htmlEscape(
                        formatDates(event.start, event.end, opt('timeFormat'))
                    ) +
                    "</span>";
            }
            html +=
                "<span class='fc-event-title'>" +
                htmlEscape(event.title || '') +
                "</span>" +
                "</div>";
            html += "</" + (url ? "a" : "div") + ">";

            return html;
        }

        function resolveElements(segments, elements) {
            for (var i=0; i<segments.length; i++) {
                var segment = segments[i];
                var event = segment.event;
                var element = elements.eq(i);
                var triggerRes = trigger('eventRender', event, event, element);

                if (triggerRes === false) {
                    element.remove();
                } else {
                    if (triggerRes && triggerRes !== true) {
                        triggerRes = $(triggerRes)
                            .css({
                                position: 'absolute',
                                left: segment.left
                            });
                        element.replaceWith(triggerRes);
                        element = triggerRes;
                    }
                    segment.element = element;
                }
            }
        }

        function setVerticals(segments, doRowHeights) {
            var rowContentHeights = calculateVerticals(segments);
            var rowContentElements = getRowContentElements();
            var rowContentTops = [];

            if (doRowHeights) {
                for (var i=0; i<rowContentElements.length; i++) {
                    rowContentElements[i].height(rowContentHeights[i]);
                }
            }

            for (var i=0; i<rowContentElements.length; i++) {
                rowContentTops.push(
                    rowContentElements[i].position().top
                );
            }

            segmentElementEach(segments, function(segment, element) {
                element.css(
                    'top',
                    rowContentTops[segment.row] + segment.top
                );
            });
        }

        function calculateVerticals(segments) {
            var rowCnt = getRowCnt();
            var colCnt = getColCnt();
            var rowContentHeights = [];
            var segmentRows = buildSegmentRows(segments);

            for (var rowI=0; rowI<rowCnt; rowI++) {
                var segmentRow = segmentRows[rowI];
                var colHeights = [];

                for (var colI=0; colI<colCnt; colI++) {
                    colHeights.push(0);
                }

                for (var segmentI=0; segmentI<segmentRow.length; segmentI++) {
                    var segment = segmentRow[segmentI];
                    segment.top = arrayMax(
                        colHeights.slice(
                            segment.leftCol,
                            segment.rightCol + 1
                        )
                    );

                    for (var colI=segment.leftCol; colI<=segment.rightCol; colI++) {
                        colHeights[colI] = segment.top + segment.outerHeight;
                    }
                }
                rowContentHeights.push(arrayMax(colHeights));
            }

            return rowContentHeights;
        }

        function buildSegmentRows(segments) {
            var rowCnt = getRowCnt();
            var segmentRows = [];
            var segmentI;
            var segment;
            var rowI;

            for (segmentI=0; segmentI<segments.length; segmentI++) {
                segment = segments[segmentI];
                rowI = segment.row;

                if (segment.element) {
                    if (segmentRows[rowI]) {
                        segmentRows[rowI].push(segment);
                    } else {
                        segmentRows[rowI] = [ segment ];
                    }
                }
            }

            for (rowI=0; rowI<rowCnt; rowI++) {
                segmentRows[rowI] = sortSegmentRow(
                    segmentRows[rowI] || []
                );
            }

            return segmentRows;
        }

        function sortSegmentRow(segments) {
            var sortedSegments = [];
            var subrows = buildSegmentSubrows(segments);

            for (var i=0; i<subrows.length; i++) {
                sortedSegments.push.apply(sortedSegments, subrows[i]);
            }

            return sortedSegments;
        }

        function buildSegmentSubrows(segments) {
            var subrows = [];
            for (var i=0; i<segments.length; i++) {
                var segment = segments[i];

                for (var j=0; j<subrows.length; j++) {
                    if (!isDaySegmentCollision(segment, subrows[j])) {
                        break;
                    }
                }

                if (subrows[j]) {
                    subrows[j].push(segment);
                } else {
                    subrows[j] = [ segment ];
                }
            }

            return subrows;
        }

        function getRowContentElements() {
            var i;
            var rowCnt = getRowCnt();
            var rowDivs = [];

            for (i=0; i<rowCnt; i++) {
                rowDivs[i] = allDayRow(i)
                    .find('div.fc-day-content > div');
            }

            return rowDivs;
        }

        function draggableDayEvent(event, eventElement) {
            var hoverListener = getHoverListener();
            var dayDelta;
            eventElement.draggable({
                delay: 50,
                opacity: opt('dragOpacity'),
                revertDuration: opt('dragRevertDuration'),
                start: function(ev, ui) {
                    trigger('eventDragStart', eventElement, event, ev, ui);
                    hoverListener.start(function(cell, origCell, rowDelta, colDelta) {
                        eventElement.draggable('option', 'revert', !cell || !rowDelta && !colDelta);
                        clearOverlays();

                        if (cell) {
                            var origDate = cellToDate(origCell);
                            var date = cellToDate(cell);
                            dayDelta = dayDiff(date, origDate);
                        } else {
                            dayDelta = 0;
                        }
                    }, ev, 'drag');
                },
                stop: function(ev, ui) {
                    hoverListener.stop();
                    clearOverlays();
                    trigger('eventDragStop', eventElement, event, ev, ui);

                    if (dayDelta) {
                        eventDrop(this, event, dayDelta, 0, event.allDay, ev, ui);
                    } else {
                        eventElement.css('filter', '');
                        showEvents(event, eventElement);
                    }
                }
            });
        }
    }

    function isDaySegmentCollision(segment, otherSegments) {
        for (var i=0; i<otherSegments.length; i++) {
            var otherSegment = otherSegments[i];

            if (
                otherSegment.leftCol <= segment.rightCol &&
                otherSegment.rightCol >= segment.leftCol
            ) {
                return true;
            }
        }

        return false;
    }

    function segmentElementEach(segments, callback) { // TODO: use in AgendaView?
        for (var i=0; i<segments.length; i++) {
            var segment = segments[i];
            var element = segment.element;

            if (element) {
                callback(segment, element, i);
            }
        }
    }

    function SelectionManager() {
        var t = this;
        t.select = select;
        t.reportSelection = reportSelection;
        t.daySelectionMousedown = daySelectionMousedown;
        var opt = t.opt;
        var trigger = t.trigger;
        var defaultSelectionEnd = t.defaultSelectionEnd;
        var selected = false;

        if (opt('selectable') && opt('unselectAuto')) {
            $(document).mousedown(function(ev) {
                var ignore = opt('unselectCancel');

                if (ignore) {
                    if ($(ev.target).parents(ignore).length) {
                        return;
                    }
                }
            });
        }

        function select(startDate, endDate, allDay) {
            if (!endDate) {
                endDate = defaultSelectionEnd(startDate, allDay);
            }
            reportSelection(startDate, endDate, allDay);
        }

        function reportSelection(startDate, endDate, allDay, ev) {
            selected = true;
            trigger('select', null, startDate, endDate, allDay, ev);
        }

        function daySelectionMousedown(ev) {
            var cellToDate = t.cellToDate;
            var getIsCellAllDay = t.getIsCellAllDay;
            var hoverListener = t.getHoverListener();

            if (ev.which == 1 && opt('selectable')) {
                var _mousedownElement = this;
                var dates;
                hoverListener.start(function(cell, origCell) {
                    if (cell && getIsCellAllDay(cell)) {
                        dates = [ cellToDate(origCell), cellToDate(cell) ].sort(dateCompare);
                    }else{
                        dates = null;
                    }
                }, ev);
                $(document).one('mouseup', function(ev) {
                    hoverListener.stop();

                    if (dates) {
                        reportSelection(dates[0], dates[1], true, ev);
                    }
                });
            }
        }
    }

    function HorizontalPositionCache(getElement) {

        var t = this,
            elements = {},
            lefts = {},
            rights = {};

        function e(i) {
            return elements[i] = elements[i] || getElement(i);
        }

        t.left = function(i) {
            return lefts[i] = lefts[i] === undefined ? e(i).position().left : lefts[i];
        };

        t.right = function(i) {
            return rights[i] = rights[i] === undefined ? t.left(i) + e(i).width() : rights[i];
        };

        t.clear = function() {
            elements = {};
            lefts = {};
            rights = {};
        };
    }

})(jQuery);
$(document).ready(function() {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#external-events div.external-event').each(function() {
        var eventObject = {
            title: $.trim($(this).text())
        };
        $(this).data('eventObject', eventObject);
        $(this).draggable({
            zIndex: 999,
            revert: true,
            revertDuration: 0
        });

    });

    var calendar =  $('#calendar').fullCalendar({
        header: {
            left: 'title',
            center: 'agendaDay,agendaWeek,month',
            right: 'prev,next today'
        },
        editable: true,
        firstDay: 1,
        selectable: true,
        defaultView: 'month',

        axisFormat: 'h:mm',
        columnFormat: {
            month: 'ddd',
            week: 'ddd d',
            day: 'dddd M/d',
            agendaDay: 'dddd d'
        },
        titleFormat: {
            month: 'MMMM yyyy',
            week: "MMMM yyyy",
            day: 'MMMM yyyy'
        },
        allDaySlot: false,
        selectHelper: true,
        select: function(start, end, allDay) {
            var title = prompt('Event Title:');

            if (title) {
                calendar.fullCalendar('renderEvent',
                    {
                        title: title,
                        start: start,
                        end: end,
                        allDay: allDay
                    },
                    true
                );
            }
        },
        droppable: true,
        drop: function(date, allDay) {
            var originalEventObject = $(this).data('eventObject');
            var copiedEventObject = $.extend({}, originalEventObject);
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

            if ($('#drop-remove').is(':checked')) {
                $(this).remove();
            }

        },

        events: [
            {
                title: 'All Day Event',
                start: new Date(y, m, 1)
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d-3, 16, 0),
                allDay: false,
                className: 'info'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d+4, 16, 0),
                allDay: false,
                className: 'info'
            },
            {
                title: 'Meeting',
                start: new Date(y, m, d, 10, 30),
                allDay: false,
                className: 'important'
            },
            {
                title: 'Lunch',
                start: new Date(y, m, d, 12, 0),
                end: new Date(y, m, d, 14, 0),
                allDay: false,
                className: 'important'
            },
            {
                title: 'Birthday Party',
                start: new Date(y, m, d+1, 19, 0),
                end: new Date(y, m, d+1, 22, 30),
                allDay: false,
            },
            {
                title: 'Click for Google',
                start: new Date(y, m, 28),
                end: new Date(y, m, 29),
                url: 'https://ccp.cloudaccess.net/aff.php?aff=5188',
                className: 'success'
            }
        ],
    });

});
