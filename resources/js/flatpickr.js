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
  time_24hr: ture
}
flatpickr("#start_time", setting);
flatpickr("#end_time", setting); 