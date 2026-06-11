@props(['contracts', 'editable' => false, 'signable' => false])

@if($contracts->isNotEmpty())
@php
    $currencies = config('currency.currency');
@endphp

<div class="user-contracts">
    <div class="form_title">
        <div class="form_title__h1">Договоры</div>
        <div class="form_title__h2">Список оформленных договоров</div>
    </div>

    @foreach($contracts as $contract)
        <div class="user-contracts__item {{ $contract->is_signed ? 'user-contracts__item--signed' : '' }}"
             data-contract-id="{{ $contract->id }}">

            <div class="user-contracts__top">
                <div class="user-contracts__contract-title">
                    Договор{{ $contract->contract_number ? ' № ' . $contract->contract_number : '' }}
                    <span class="user-contracts__contract-date">от {{ $contract->created_at->format('d.m.Y') }}</span>
                </div>
                @if($contract->is_signed)
                    <span class="user-contracts__badge user-contracts__badge--signed">Подписан</span>
                @else
                    <span class="user-contracts__badge user-contracts__badge--pending">Ожидает подписания</span>
                @endif
            </div>

            <div class="user-contracts__rows">

                <div class="user-contracts__row">
                    <span class="user-contracts__label">Дисциплина</span>
                    <span class="user-contracts__value" data-contract-field="discipline">{{ $contract->discipline ?: '—' }}</span>
                </div>

                @if($contract->organizations)
                <div class="user-contracts__row">
                    <span class="user-contracts__label">Организация</span>
                    <span class="user-contracts__value" data-contract-field="organization">
                        {{ \App\Enums\OrganizationEnum::fromValueSafe($contract->organizations)?->label() ?? $contract->organizations }}
                    </span>
                </div>
                @endif

                <div class="user-contracts__row">
                    <span class="user-contracts__label">Период</span>
                    <span class="user-contracts__value" data-contract-field="period">
                        @if($contract->date_start && $contract->date_end)
                            {{ $contract->date_start->format('d.m.Y') }} — {{ $contract->date_end->format('d.m.Y') }}
                        @else
                            —
                        @endif
                    </span>
                </div>

                <div class="user-contracts__row">
                    <span class="user-contracts__label">Часов</span>
                    <span class="user-contracts__value"><span data-contract-field="hours">{{ $contract->hours }}</span>&nbsp;ч.</span>
                </div>

                <div class="user-contracts__row">
                    <span class="user-contracts__label">Сумма</span>
                    <span class="user-contracts__value user-contracts__value--price">
                        <span data-contract-field="price">{{ number_format($contract->price, 0, '.', ' ') }}</span>&nbsp;<span data-contract-field="currency">{{ $currencies[$contract->currency] ?? $contract->currency }}</span>
                    </span>
                </div>

            </div>

            <div class="user-contracts__actions">
                @if(!$contract->is_signed && $editable)
                    <a href="#" class="open-fancybox user-contracts__edit-btn"
                       data-form="admin_contract_edit"
                       data-transfer='{"contract_id": {{ $contract->id }}}'
                       title="Редактировать договор">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Редактировать
                    </a>
                @endif

                @if(!$contract->is_signed && $signable)
                    <a href="#" class="open-fancybox user-contracts__sign-btn"
                       data-form="cabinet_contract_sign"
                       data-transfer='{"contract_id": {{ $contract->id }}}'
                       title="Подписать договор">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                        Подписать договор
                    </a>
                @endif

                @if($contract->public_token)
                    <a href="{{ route('contract.public', $contract->public_token) }}"
                       target="_blank"
                       class="user-contracts__contract-link">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                            <path d="M14 2v6h6"/>
                            <path d="M9 13h6M9 17h4"/>
                        </svg>
                        Открыть договор
                    </a>
                    <button type="button"
                            class="user-contracts__copy-btn"
                            data-copy-url="{{ route('contract.public', $contract->public_token) }}"
                            title="Скопировать ссылку">
                        <svg class="icon-copy" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                        </svg>
                        <svg class="icon-check" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </button>
                @endif
            </div>

        </div>
    @endforeach
</div>
@endif
