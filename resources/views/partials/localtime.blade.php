{{--
  Converts any element carrying a data-localtime="<ISO-8601 UTC>" attribute into
  the VIEWER's local timezone (so a session at 22:00 in the instructor's zone
  shows as the right wall-clock time for a student in the USA, UAE, etc.).
  Server stores/emits times in UTC; the browser renders them locally.
  Fallback: the element's server-rendered text (shown until JS runs / if disabled).
--}}
<script>
(function () {
  function fmt(iso, withTime) {
    var d = new Date(iso);
    if (isNaN(d.getTime())) return null;
    var opts = withTime
      ? { year: 'numeric', month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit' }
      : { year: 'numeric', month: 'short', day: '2-digit' };
    try { return d.toLocaleString([], opts); } catch (e) { return d.toString(); }
  }
  function apply(root) {
    (root || document).querySelectorAll('[data-localtime]').forEach(function (el) {
      if (el.dataset.localtimeDone) return;
      var withTime = el.getAttribute('data-localtime-date') === null || el.getAttribute('data-localtime-date') !== '1';
      var out = fmt(el.getAttribute('data-localtime'), withTime);
      if (out) { el.textContent = out; el.dataset.localtimeDone = '1'; }
    });
  }
  document.addEventListener('DOMContentLoaded', function () { apply(document); });
  window.applyLocalTimes = apply; // for dynamically injected content
})();
</script>
