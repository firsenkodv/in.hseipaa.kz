@props(['contracts'])

@php $currencies = config('currency.currency'); @endphp

<div class="form_title">
    <div class="form_title__h1">Договоры</div>
    <div class="form_title__h2">Все договоры, отсортированные по дате начала обучения</div>
</div>

@if($contracts->isNotEmpty())
    <div class="admin-contracts">
        @foreach($contracts as $contract)
            <div class="admin-contracts__item {{ $contract->is_signed ? 'admin-contracts__item--signed' : '' }}">

                <div class="admin-contracts__discipline">
                    {{ $contract->discipline ?: '—' }}
                </div>

                <div class="admin-contracts__user">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                    @if($contract->user)
                        <a href="{{ route('admin_user', $contract->user_id) }}">{{ $contract->user->username }}</a>
                    @else
                        <span>—</span>
                    @endif
                </div>

                <div class="admin-contracts__meta">

                    <span class="admin-contracts__meta-item">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        @if($contract->date_start && $contract->date_end)
                            {{ $contract->date_start->format('d.m.Y') }} — {{ $contract->date_end->format('d.m.Y') }}
                        @else
                            —
                        @endif
                    </span>

                    <span class="admin-contracts__sep">·</span>

                    <span class="admin-contracts__meta-item admin-contracts__meta-item--price">
                        {{ number_format($contract->price, 0, '.', ' ') }}&nbsp;{{ $currencies[$contract->currency] ?? $contract->currency }}
                    </span>

                    <span class="admin-contracts__sep">·</span>

                    <span class="admin-contracts__meta-item">
                        {{ $contract->hours }}&nbsp;ч.
                    </span>

                    <span class="admin-contracts__sep">·</span>

                    @if($contract->is_signed)
                        <span class="admin-contracts__badge admin-contracts__badge--signed">Подписан</span>
                    @else
                        <span class="admin-contracts__badge admin-contracts__badge--pending">Ожидает подписания</span>
                    @endif

                </div>

                @if($contract->public_token)
                <div class="admin-contracts__actions">
                    <a href="{{ route('contract.public', $contract->public_token) }}"
                       target="_blank"
                       class="admin-contracts__link">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                            <polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
                        </svg>
                        Ссылка на договор
                    </a>
                </div>
                @endif

            </div>
        @endforeach

        {{ $contracts->withQueryString()->links('pagination::default') }}
    </div>
@else
    <div class="form_title">
        <div class="form_title__h2">Договоров пока нет</div>
    </div>
@endif
