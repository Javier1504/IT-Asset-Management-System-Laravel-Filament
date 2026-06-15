@foreach ($menu as $si => $section)
    <div class="sb-section-label">{{ $section['label'] }}</div>

    @foreach ($section['items'] as $ii => $item)
        @php
            $collapseId = "sbCollapse_{$prefix}_{$si}_{$ii}";
            $hasSub = !empty($item['sub']);
            $isParentActive = $hasSub && collect($item['sub'])->contains('active', true);
            $isActive = $item['active'] || $isParentActive;
        @endphp

        <div class="sb-item">
            {{-- Parent link / toggle --}}
            @if ($hasSub)
                <a class="sb-link {{ $isActive ? 'active' : '' }}" role="button" data-bs-toggle="collapse"
                    href="#{{ $collapseId }}" aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                    aria-controls="{{ $collapseId }}" title="{{ $item['title'] }}">
                    <span class="sb-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"
                            stroke-linecap="round" stroke-linejoin="round">
                            {!! $item['icon'] !!}
                        </svg>
                    </span>
                    <span class="sb-link-text">{{ $item['title'] }}</span>
                    @if (!empty($item['badge']))
                        <span class="sb-badge">{{ $item['badge'] }}</span>
                    @endif
                    <svg class="sb-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </a>

                {{-- Sub menu --}}
                <div class="sb-collapse collapse {{ $isActive ? 'show' : '' }}" id="{{ $collapseId }}">
                    <div class="sb-sub">
                        @foreach ($item['sub'] as $sub)
                            <a href="{{ $sub['route'] }}" class="sb-sub-link {{ $sub['active'] ? 'active' : '' }}">
                                <span class="sb-sub-dot"></span>
                                {{ $sub['title'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <a href="{{ $item['route'] }}" class="sb-link {{ $isActive ? 'active' : '' }}" title="{{ $item['title'] }}">
                    <span class="sb-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"
                            stroke-linecap="round" stroke-linejoin="round">
                            {!! $item['icon'] !!}
                        </svg>
                    </span>
                    <span class="sb-link-text">{{ $item['title'] }}</span>
                    @if (!empty($item['badge']))
                        <span class="sb-badge">{{ $item['badge'] }}</span>
                    @endif
                </a>
            @endif
        </div>
    @endforeach

    @if (!$loop->last)
        <div class="sb-divider"></div>
    @endif
@endforeach
