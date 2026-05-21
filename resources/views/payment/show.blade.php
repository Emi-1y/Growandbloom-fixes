{{-- Author: Emily Cardona Castañeda --}}

@extends('layouts.app')

@section('title', $viewData['title'])
@section('subtitle', $viewData['title'])

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">

        <a href="{{ route('order.show', $viewData['paymentData']['order_id']) }}"
           style="display:inline-block; margin-bottom:1.5rem; font-size:0.85rem; color:var(--c-accent-dk); text-decoration:none;">
            {{ __('payment.back_to_order') }}
        </a>

        <p style="font-size:0.92rem; color:var(--c-muted); margin-bottom:2rem;">
            {{ __('payment.subtitle') }}
        </p>

        @if($viewData['paymentData']['type'] === 'cheque')
        {{-- ── CHEQUE ── --}}
        <div style="
            border: 2px solid #b5c9b0;
            border-radius: 12px;
            background: #fafdf7;
            padding: 2.2rem 2.4rem;
            box-shadow: 0 4px 18px rgba(60,90,50,0.08);
            position: relative;
            overflow: hidden;
        ">
            {{-- watermark --}}
            <div style="
                position:absolute; top:50%; left:50%;
                transform:translate(-50%,-50%) rotate(-30deg);
                font-family:'Cormorant Garamond',serif;
                font-size:5rem; font-weight:600; color:rgba(80,130,70,0.06);
                white-space:nowrap; pointer-events:none; user-select:none;
            ">Grow and Bloom</div>

            {{-- header --}}
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.6rem;">
                <div>
                    <div style="font-family:'Cormorant Garamond',serif; font-size:1.5rem; font-weight:600; color:#1a3a2a; font-style:italic;">
                        Grow and Bloom S.A.S.
                    </div>
                    <div style="font-size:0.72rem; letter-spacing:0.1em; text-transform:uppercase; color:#7a7165; margin-top:2px;">
                        {{ __('payment.cheque_title') }}
                    </div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:0.68rem; text-transform:uppercase; letter-spacing:0.1em; color:#7a7165;">
                        {{ __('payment.cheque_number') }}
                    </div>
                    <div style="font-family:monospace; font-size:1.05rem; font-weight:600; color:#1a3a2a;">
                        {{ $viewData['paymentData']['cheque_number'] }}
                    </div>
                </div>
            </div>

            {{-- pay to --}}
            <div style="margin-bottom:1.2rem;">
                <div style="font-size:0.65rem; letter-spacing:0.12em; text-transform:uppercase; color:#7a7165; margin-bottom:4px;">
                    {{ __('payment.pay_to') }}
                </div>
                <div style="
                    border-bottom: 1.5px solid #b5c9b0;
                    padding-bottom: 6px;
                    font-family:'Cormorant Garamond',serif;
                    font-size:1.15rem; font-weight:600; color:#1a3a2a;
                ">
                    {{ $viewData['paymentData']['payable_to'] }}
                </div>
            </div>

            {{-- amount + date --}}
            <div style="display:flex; gap:2rem; margin-bottom:1.2rem;">
                <div style="flex:1;">
                    <div style="font-size:0.65rem; letter-spacing:0.12em; text-transform:uppercase; color:#7a7165; margin-bottom:4px;">
                        {{ __('payment.amount') }}
                    </div>
                    <div style="
                        border-bottom: 1.5px solid #b5c9b0;
                        padding-bottom: 6px;
                        font-family: monospace; font-size:1.1rem; font-weight:700; color:#2d5a27;
                    ">
                        {{ $viewData['paymentData']['amount_formatted'] }}
                    </div>
                </div>
                <div style="width:160px;">
                    <div style="font-size:0.65rem; letter-spacing:0.12em; text-transform:uppercase; color:#7a7165; margin-bottom:4px;">
                        {{ __('payment.date') }}
                    </div>
                    <div style="
                        border-bottom: 1.5px solid #b5c9b0;
                        padding-bottom: 6px;
                        font-size:0.9rem; color:#1a3a2a;
                    ">
                        {{ $viewData['paymentData']['date'] }}
                    </div>
                </div>
            </div>

            {{-- memo --}}
            <div style="margin-bottom:2rem;">
                <div style="font-size:0.65rem; letter-spacing:0.12em; text-transform:uppercase; color:#7a7165; margin-bottom:4px;">
                    {{ __('payment.memo') }}
                </div>
                <div style="
                    border-bottom: 1.5px solid #b5c9b0;
                    padding-bottom: 6px;
                    font-size:0.88rem; color:#3a3a3a;
                ">
                    {{ $viewData['paymentData']['memo'] }}
                </div>
            </div>

            {{-- signature --}}
            <div style="display:flex; justify-content:flex-end;">
                <div style="text-align:center; width:200px;">
                    <div style="border-top: 1.5px solid #b5c9b0; padding-top:6px; font-size:0.65rem; letter-spacing:0.12em; text-transform:uppercase; color:#7a7165;">
                        {{ __('payment.signature') }}
                    </div>
                </div>
            </div>
        </div>

        <p style="font-size:0.78rem; color:#7a7165; margin-top:1rem; text-align:center;">
            <i class="bi bi-printer me-1"></i>{{ __('payment.print_note') }}
        </p>

        @elseif($viewData['paymentData']['type'] === 'transfer')
        {{-- ── TRANSFERENCIA ── --}}
        <div style="
            border: 2px solid #b5c9b0;
            border-radius: 12px;
            background: #fafdf7;
            padding: 2.2rem 2.4rem;
            box-shadow: 0 4px 18px rgba(60,90,50,0.08);
        ">
            <div style="font-family:'Cormorant Garamond',serif; font-size:1.35rem; font-weight:600; color:#1a3a2a; margin-bottom:1.8rem; border-bottom:1px solid #e0dbd0; padding-bottom:0.8rem;">
                {{ __('payment.transfer_title') }}
            </div>

            @foreach([
                ['label' => __('payment.bank'),           'value' => $viewData['paymentData']['bank']],
                ['label' => __('payment.account_type'),   'value' => $viewData['paymentData']['account_type']],
                ['label' => __('payment.account_number'), 'value' => $viewData['paymentData']['account_number']],
                ['label' => __('payment.nit'),            'value' => $viewData['paymentData']['nit']],
                ['label' => __('payment.beneficiary'),    'value' => $viewData['paymentData']['beneficiary']],
                ['label' => __('payment.amount'),         'value' => $viewData['paymentData']['amount_formatted']],
                ['label' => __('payment.reference'),      'value' => $viewData['paymentData']['reference']],
            ] as $row)
            <div style="display:flex; justify-content:space-between; padding:0.6rem 0; border-bottom:1px solid #ede8df;">
                <span style="font-size:0.78rem; text-transform:uppercase; letter-spacing:0.09em; color:#7a7165;">
                    {{ $row['label'] }}
                </span>
                <span style="font-size:0.9rem; font-weight:600; color:#1a3a2a; font-family:{{ $row['label'] === __('payment.amount') || $row['label'] === __('payment.account_number') || $row['label'] === __('payment.reference') ? 'monospace' : 'inherit' }};">
                    {{ $row['value'] }}
                </span>
            </div>
            @endforeach
        </div>
        @endif

        <div style="margin-top:2rem; text-align:center;">
            <form method="POST" action="{{ route('payment.confirm', $viewData['paymentData']['order_id']) }}">
                @csrf
                <button type="submit" class="btn btn-success px-4" style="border-radius:8px;">
                    {{ $viewData['paymentData']['type'] === 'cheque' ? __('payment.simulate_payment_cheque') : __('payment.simulate_payment_transfer') }}
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
