<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Normal Kalkulator</title>
    <link rel="stylesheet" href="{{ asset('assets/css/normal-kalkulator.css') }}">
</head>
<body>
    <div class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-contents">
                <div id="calculator">
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                    <div class="modal-header-edit">
                        <img src="{{ asset('assets/images/logo-kalkulator.png') }}" alt="Logo" id="logo">
                    </div>
                    <div class="calculator-body">
                        <input type="text" id="display" readonly>
                        <div id="buttons">
                            <button class="num" value="7">7</button>
                            <button class="num" value="8">8</button>
                            <button class="num" value="9">9</button>
                            <button class="operator" value="/">÷</button>
                            <button class="num" value="4">4</button>
                            <button class="num" value="5">5</button>
                            <button class="num" value="6">6</button>
                            <button class="operator" value="*">×</button>
                            <button class="num" value="1">1</button>
                            <button class="num" value="2">2</button>
                            <button class="num" value="3">3</button>
                            <button class="operator" value="-">-</button>
                            <button class="num" value="0">0</button>
                            <button class="num" value="00">.00</button>
                            <button class="num" value="000">.000</button>
                            <button class="operator" value="+">+</button>
                            <button id="clear">C</button>
                            <button id="delete">Del</button>
                            <button class="num" value=",">,</button>
                            <button id="equals">=</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <audio id="sound1" src="{{ asset('assets/sound/sound1.mp3') }}"></audio>
    <audio id="sound2" src="{{ asset('assets/sound/sound2.mp3') }}"></audio>
    <script src="{{ asset('assets/js/normal-kalkulator.js') }}"></script>

    <script>
        document.querySelector('.btn-close').addEventListener('click', function() {
            parent.postMessage('close-modal', '*');
        });
    </script>
</body>
</html>