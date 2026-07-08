@php($report = $report ?? ['percent' => 0, 'completed' => 0, 'total' => 0, 'contents' => [], 'next_step' => null, 'last_done' => null])
<div class="course-progress">

  {{-- Where the student is right now (the headline the instructor scans). --}}
  <div class="mb-1">
    @if(($report['total'] ?? 0) > 0 && empty($report['next_step']))
      <span class="badge badge-success" style="font-size:.85rem;">&#10003; Completed all steps</span>
    @elseif(!empty($report['next_step']))
      <span class="text-muted" style="font-size:.8rem;">Currently at:</span>
      <span class="badge badge-info" style="font-size:.9rem;">{{ $report['next_step']['title'] }}</span>
      <small class="text-muted">— {{ $report['next_step']['content_title'] }} · {{ $report['next_step']['type'] }}</small>
    @else
      <span class="text-muted">Not started yet</span>
    @endif
  </div>

  {{-- Overall completion bar. --}}
  <div class="d-flex align-items-center" style="gap:.5rem;">
    <div class="progress flex-grow-1" style="height:14px;min-width:120px;background:#e9ecef;">
      <div class="progress-bar bg-success" role="progressbar"
           style="width: {{ $report['percent'] }}%;"
           aria-valuenow="{{ $report['percent'] }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <small class="text-muted text-nowrap" style="margin-left:.5rem;">
      {{ $report['completed'] }}/{{ $report['total'] }} ({{ $report['percent'] }}%)
    </small>
  </div>

  @if(!empty($report['last_done']))
    <div class="mt-1">
      <small class="text-muted">Last completed: <strong>{{ $report['last_done']['title'] }}</strong></small>
    </div>
  @endif

  {{-- Full step-by-step breakdown. --}}
  @if(!empty($report['contents']))
    <details class="mt-2" {{ ($open ?? false) ? 'open' : '' }}>
      <summary style="cursor:pointer;">All steps</summary>
      <div class="mt-2">
        @foreach($report['contents'] as $content)
          <div class="mb-2">
            <strong>{{ $content['title'] }}</strong>
            <small class="text-muted">({{ $content['completed'] }}/{{ $content['total'] }})</small>
            <ul class="list-unstyled mb-1" style="margin-left:1rem;">
              @foreach($content['steps'] as $step)
                <li @if(!empty($step['current'])) style="background:#e8f4fd;border-radius:4px;padding:1px 4px;" @endif>
                  @if($step['done'])
                    <span style="color:#28a745;font-weight:bold;">&#10003;</span>
                  @elseif(!empty($step['current']))
                    <span style="color:#17a2b8;font-weight:bold;">&#9654;</span>
                  @else
                    <span style="color:#adb5bd;">&#9675;</span>
                  @endif
                  <span class="text-muted" style="font-size:.8rem;">[{{ $step['type'] }}]</span>
                  {{ $step['title'] }}
                  @if(!empty($step['current']))
                    <span class="badge badge-info" style="font-size:.7rem;">current</span>
                  @endif
                </li>
              @endforeach
            </ul>
          </div>
        @endforeach
      </div>
    </details>
  @else
    <small class="text-muted">No tracked steps yet.</small>
  @endif
</div>
