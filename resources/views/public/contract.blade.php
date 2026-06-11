<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Договор на обучение — {{ config('app.name') }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, Helvetica, sans-serif; background: #f4f6f9; color: #282828; min-height: 100vh; }
        .page { max-width: 680px; margin: 0 auto; padding: 32px 16px 48px; }

        .header { text-align: center; margin-bottom: 32px; }
        .header__logo { font-size: 36px; font-weight: 700; color: #EF533F; text-decoration: none; letter-spacing: -0.3px; }
        .header__sub { font-size: 13px; color: #888; margin-top: 4px; }

        .card { background: #fff; border-radius: 10px; box-shadow: 0 2px 12px rgba(0,0,0,.08); padding: 32px; }

        .card__title { font-size: 22px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px; }
        .card__subtitle { font-size: 14px; color: #888; margin-bottom: 28px; }

        .status { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; margin-bottom: 24px; }
        .status--signed { background: #e8f9f0; color: #1a7a4a; }
        .status--pending { background: #fff7e6; color: #b45309; }
        .status__dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
        .status--signed .status__dot { background: #1a7a4a; }
        .status--pending .status__dot { background: #b45309; }

        .contract-table { width: 100%; border-collapse: collapse; margin-bottom: 28px; }
        .contract-table tr:not(:last-child) td { border-bottom: 1px solid #f0f0f0; }
        .contract-table td { padding: 11px 0; font-size: 14px; vertical-align: top; }
        .contract-table td:first-child { color: #888; width: 170px; padding-right: 16px; white-space: nowrap; }
        .contract-table td:last-child { color: #1a1a1a; font-weight: 500; }

        .sign-area { border-top: 1px solid #f0f0f0; padding-top: 24px; }
        .sign-notice { font-size: 13px; color: #666; line-height: 1.6; background: #fffaf0; border-left: 3px solid #f0b429; padding: 12px 16px; border-radius: 4px; margin-bottom: 20px; }

        .btn-sign { display: inline-flex; align-items: center; gap: 8px; background: #EF533F; color: #fff; border: none; border-radius: 6px; font-size: 15px; font-weight: 700; padding: 0 32px; height: 48px; cursor: pointer; transition: background .15s; }
        .btn-sign:hover { background: #074a7f; }
        .btn-sign:disabled { background: #b0c4d8; cursor: not-allowed; }

        .sign-success { display: none; align-items: center; gap: 10px; font-size: 15px; font-weight: 600; color: #1a7a4a; }
        .sign-success svg { flex-shrink: 0; }
        .sign-success.active { display: flex; }

        .sign-error { display: none; font-size: 14px; color: #c0392b; margin-top: 12px; }
        .sign-error.active { display: block; }

        .already-signed { font-size: 15px; color: #555; }
        .already-signed strong { color: #1a7a4a; }

        @media (max-width: 480px) {
            .card { padding: 20px 16px; }
            .contract-table td:first-child { width: 130px; font-size: 13px; }
            .contract-table td:last-child { font-size: 13px; }
        }
    </style>
</head>
<body>
<div class="page">

    <div class="header">
        <a class="header__logo" href="{{ config('app.url') }}">{{ config('app.name') }}</a>
        <div class="header__sub">Договор на обучение</div>
    </div>

    <div class="card">

        <div class="card__title">Договор на обучение</div>
        <div class="card__subtitle">Оформлен {{ $contract->created_at->format('d.m.Y') }}</div>

        @if($contract->is_signed)
            <div class="status status--signed">
                <span class="status__dot"></span> Подписан
            </div>
        @else
            <div class="status status--pending" id="js-status">
                <span class="status__dot"></span> Ожидает подписания
            </div>
        @endif

        @php
            $currencies = config('currency.currency');
            $orgLabel   = $contract->organizations
                ? (\App\Enums\OrganizationEnum::fromValueSafe($contract->organizations)?->label() ?? $contract->organizations)
                : null;
        @endphp

        <table class="contract-table">
            @if($contract->contract_number)
            <tr>
                <td>№ договора</td>
                <td><strong>{{ $contract->contract_number }}</strong></td>
            </tr>
            @endif
            @if($orgLabel)
            <tr>
                <td>Организация</td>
                <td>{{ $orgLabel }}</td>
            </tr>
            @endif
            <tr>
                <td>ФИО</td>
                <td>{{ $contract->full_name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $contract->email ?: '—' }}</td>
            </tr>
            <tr>
                <td>Телефон</td>
                <td>{{ $contract->phone ?: '—' }}</td>
            </tr>
            <tr>
                <td>Дисциплина</td>
                <td>{{ $contract->discipline ?: '—' }}</td>
            </tr>
            @if($contract->date_start && $contract->date_end)
            <tr>
                <td>Период обучения</td>
                <td>{{ $contract->date_start->format('d.m.Y') }} — {{ $contract->date_end->format('d.m.Y') }}</td>
            </tr>
            @endif
            @if($contract->price)
            <tr>
                <td>Стоимость</td>
                <td><strong>{{ number_format((float)$contract->price, 0, '.', ' ') }}&nbsp;{{ $currencies[$contract->currency] ?? $contract->currency }}</strong></td>
            </tr>
            @endif
            @if($contract->hours)
            <tr>
                <td>Количество часов</td>
                <td>{{ $contract->hours }}&nbsp;ч.</td>
            </tr>
            @endif
        </table>

        <div class="sign-area">
            @if($contract->is_signed)
                <div class="already-signed">
                    <strong>Договор подписан.</strong> Спасибо!
                </div>
            @else
                <div class="sign-notice">
                    Нажимая «Подписать», вы подтверждаете своё согласие с условиями договора.
                    После подписания изменение условий невозможно.
                </div>

                <button class="btn-sign" id="js-sign-btn" type="button">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                    </svg>
                    Подписать
                </button>

                <div class="sign-success" id="js-sign-success">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1a7a4a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/>
                    </svg>
                    Договор успешно подписан!
                </div>

                <div class="sign-error" id="js-sign-error">
                    Произошла ошибка. Попробуйте обновить страницу.
                </div>
            @endif
        </div>

    </div>

</div>

@if(!$contract->is_signed)
<script>
(function () {
    const btn     = document.getElementById('js-sign-btn');
    const success = document.getElementById('js-sign-success');
    const error   = document.getElementById('js-sign-error');
    const status  = document.getElementById('js-status');
    const csrf    = document.querySelector('meta[name="csrf-token"]').content;

    btn.addEventListener('click', async function () {
        btn.disabled = true;
        error.classList.remove('active');

        try {
            const res = await fetch('{{ route('contract.public.sign', $token) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
            });

            if (!res.ok) throw new Error();

            const data = await res.json();

            if (data.signed) {
                btn.style.display = 'none';
                success.classList.add('active');
                if (status) {
                    status.className = 'status status--signed';
                    status.innerHTML = '<span class="status__dot"></span> Подписан';
                }
                document.querySelector('.sign-notice')?.remove();
            } else {
                throw new Error();
            }
        } catch {
            btn.disabled = false;
            error.classList.add('active');
        }
    });
}());
</script>
@endif

</body>
</html>
