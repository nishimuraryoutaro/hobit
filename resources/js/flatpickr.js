import flatpickr from "flatpickr";
import { Japanese } from "flatpickr/dist/l10n/ja.js"

flatpickr("#event_date", {
  "locale": Japanese,
  minDate: "today",
  maxDate: new Date().fp_incr(30)
});

const setting = {
  "locale": Japanese,
  enableTime: true,
  noCalendar: true,
  dateFormat: "H:i",
  time_24hr: true,
  minTime: "03:00",
  maxTime: "23:00",
}

flatpickr("#start_time", setting);
flatpickr("#end_time", setting);