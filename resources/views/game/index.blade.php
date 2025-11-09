@extends('layouts.game')

@section('content')
    
    <div class="game-container">
        <div id="letter-container">
            </div>
        <canvas id="canvas" width="400" height="400"></canvas>
        <div class="controls">
            <button id="clear-btn">Clear</button>
            <button id="retry-btn">Retry</button>
        </div>
    </div>

@endsection