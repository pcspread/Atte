@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/stamp.css') }}" />
@endsection

@section('content')
<div class="stamp-section">
    <div class="stamp-title">
        <h2>福場凛太郎さんお疲れ様です！</h2>
    </div>

    <div class="stamp-content">
        <div class="stamp-attendance">
            <div class="stamp-item">
                <form>
                    <button class="stamp-item__start">勤務開始</button>
                </form>
            </div>

            <div class="stamp-item">
                <form>
                    <button class="stamp-item__end">勤務終了</button>
                </form>
            </div>
        </div>
        
        <div class="stamp-rest">
            <div class="stamp-item">
                <form>
                    <button class="stamp-item__break">休憩開始</button>
                </form>
            </div>
            
            <div class="stamp-item">
                <form>
                    <button class="stamp-item__restart">休憩終了</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection