document.addEventListener('DOMContentLoaded', () => {
    let currentNum = '';  // Inisialisasi variabel di sini
    let currentMode = null;

    const buttons = document.querySelectorAll('.num');
    const clear = document.querySelector('#clear');
    const equals = document.querySelector('#equals');
    const del = document.querySelector('#delete');

    const showOperators = document.getElementById('showOperators');
    const operatorMenu = document.getElementById('operatorMenu');
    const display = document.getElementById('display');
    const operators = document.querySelectorAll('#operatorMenu .operator, .operator[value=";"]');

    loadState();

    operators.forEach(operator => {
        operator.addEventListener('click', function() {
            display.value = this.textContent;
            operatorMenu.style.display = 'none';
        });
    });

    showOperators.addEventListener('click', () => {
        operatorMenu.style.display = operatorMenu.style.display === 'block' ? 'none' : 'block';
        playSound(sound2);
    });

    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            handleNumberClick(e);
            playSound(sound1);
        });
    });

    operators.forEach(operator => {
        operator.addEventListener('click', (e) => {
            handleOperatorClick(e);
            playSound(sound2);
        });
    });

    equals.addEventListener('click', (e) => {
        handleEqualsClick();
        playSound(sound2);
    });

    clear.addEventListener('click', (e) => {
        handleClearClick();
        playSound(sound2);
    });

    del.addEventListener('click', (e) => {
        handleDeleteClick();
        playSound(sound2);
    });

    function playSound(sound) {
        sound.currentTime = 0;
        sound.play();
    }

    function handleNumberClick(e) {
        currentNum += e.target.value;
        updateDisplay();
        saveState();
    }

    function handleOperatorClick(e) {
        const operator = e.target.value;
        if (operator === 'shift1') {
            currentMode = 'bep-unit';
            display.value = 'Mode: BEP Unit';
            currentNum = '';
        } else if (operator === 'shift2') {
            currentMode = 'bep-nominal';
            display.value = 'Mode: BEP Nominal';
            currentNum = '';
        } else if (operator === 'shift3') {
            currentMode = 'gross-profit-margin';
            display.value = 'Mode: Margin laba kotor';
            currentNum = '';
        } else if (operator === 'shift4') {
            currentMode = 'net-profit-margin';
            display.value = 'Mode: Margin laba bersih';
            currentNum = '';
        } else if (operator === 'shift5') {
            currentMode = 'current-ratio';
            display.value = 'Mode: Current Ratio';
            currentNum = '';
        } else if (operator === 'shift6') {
            currentMode = 'quick-ratio';
            display.value = 'Mode: Quick Ratio';
            currentNum = '';
        } else if (operator === 'shift7') {
            currentMode = 'cash-ratio';
            display.value = 'Mode: Cash Ratio';
            currentNum = '';
        } else if (operator === 'shift8') {
            currentMode = 'd-aset-ratio';
            display.value = 'Mode: Debt to Asset Ratio';
            currentNum = '';
        } else if (operator === 'shift9') {
            currentMode = 'd-equity-ratio';
            display.value = 'Mode: Debt to Equity Ratio';
            currentNum = '';
        } else if (operator === 'shift10') {
            currentMode = 'd-capital-ratio';
            display.value = 'Mode: Debt to Capital Ratio';
            currentNum = '';
        } else if (operator === ';') {
            currentNum += ';';
            updateDisplay();
        }
        saveState();
    }

    function handleEqualsClick() {
        if (!currentMode) {
            display.value = "Please select a mode!";
            return;
        }
        calculateSpecial();
        saveState();
    }

    function handleClearClick() {
        currentNum = '';
        currentMode = null;
        display.value = '';
        saveState();
    }

    function handleDeleteClick() {
        if (currentNum !== '') {
            currentNum = currentNum.slice(0, -1);
            updateDisplay();
            saveState();
        }
        if (currentMode !== null && currentNum === '') {
            currentMode = null;
            display.value = '';
            saveState();
        }
    }

    function calculateSpecial() {
        const values = currentNum.split(';');
    
        let no1, no2, no3;

        if (values.length > 3) {
            display.value = "Error: Format number";
            setTimeout(handleClearClick, 2000);
            return;
        }

        if (currentMode === 'bep-unit' || currentMode === 'bep-nominal') {
            no1 = parseFloat(values[0].replace(/\./g, '').replace(/,/g, '.'));
            no2 = parseFloat(values[1].replace(/\./g, '').replace(/,/g, '.'));
            no3 = parseFloat(values[2].replace(/\./g, '').replace(/,/g, '.'));
        } else if (currentMode === 'gross-profit-margin') {
            no1 = parseFloat(values[0].replace(/\./g, '').replace(/,/g, '.'));
            no2 = parseFloat(values[1].replace(/\./g, '').replace(/,/g, '.'));
            no3 = 0;
        } else if (currentMode === 'net-profit-margin') {
            no1 = parseFloat(values[0].replace(/\./g, '').replace(/,/g, '.'));
            no2 = parseFloat(values[1].replace(/\./g, '').replace(/,/g, '.'));
            no3 = 0;
        } else if (currentMode === 'current-ratio') {
            no1 = parseFloat(values[0].replace(/\./g, '').replace(/,/g, '.'));
            no2 = parseFloat(values[1].replace(/\./g, '').replace(/,/g, '.'));
            no3 = 0;
        } else if (currentMode === 'quick-ratio') {
            no1 = parseFloat(values[0].replace(/\./g, '').replace(/,/g, '.'));
            no2 = parseFloat(values[1].replace(/\./g, '').replace(/,/g, '.'));
            no3 = parseFloat(values[2].replace(/\./g, '').replace(/,/g, '.'));
        } else if (currentMode === 'cash-ratio') {
            no1 = parseFloat(values[0].replace(/\./g, '').replace(/,/g, '.'));
            no2 = parseFloat(values[1].replace(/\./g, '').replace(/,/g, '.'));
            no3 = parseFloat(values[2].replace(/\./g, '').replace(/,/g, '.'));
        } else if (currentMode === 'd-aset-ratio') {
            no1 = parseFloat(values[0].replace(/\./g, '').replace(/,/g, '.'));
            no2 = parseFloat(values[1].replace(/\./g, '').replace(/,/g, '.'));
        } else if (currentMode === 'd-equity-ratio') {
            no1 = parseFloat(values[0].replace(/\./g, '').replace(/,/g, '.'));
            no2 = parseFloat(values[1].replace(/\./g, '').replace(/,/g, '.'));
        } else if (currentMode === 'd-capital-ratio') {
            no1 = parseFloat(values[0].replace(/\./g, '').replace(/,/g, '.'));
            no2 = parseFloat(values[1].replace(/\./g, '').replace(/,/g, '.'));
        }
        
        if ((currentMode === 'bep-unit' || currentMode === 'bep-nominal' || currentMode === 'quick-ratio' || currentMode === 'cash-ratio') && (isNaN(no1) || isNaN(no2) || isNaN(no3))) {
            display.value = "Error: Format number";
            setTimeout(handleClearClick, 2000);
            return;
        } else if ((currentMode === 'gross-profit-margin' || currentMode === 'net-profit-margin' || currentMode === 'current-ratio' || currentMode === 'd-aset-ratio' || currentMode === 'd-equity-ratio'|| currentMode === 'd-capital-ratio') && (isNaN(no1) || isNaN(no2))) {
            display.value = "Error: Format number";
            setTimeout(handleClearClick, 2000);
            return;
        }

        let result;

        if (currentMode === 'bep-unit') {
            result = no1 / (no3 - no2);
        } else if (currentMode === 'bep-nominal') {
            result = no1 / ((no3 - no2) / no3);
        } else if (currentMode === 'gross-profit-margin') {
            result = (no1 / no2) * 100;
        } else if (currentMode === 'net-profit-margin') {
            result = (no1 / no2) * 100;
        } else if (currentMode === 'current-ratio') {
            result = (no1 / no2) ;
        } else if (currentMode === 'quick-ratio') {
            result = (no1 - no2) / no3 ;
        } else if (currentMode === 'cash-ratio') {
            result = (no1 + no2) / no3 ;
        } else if (currentMode === 'd-aset-ratio') {
            result = no1 / no2
        } else if (currentMode === 'd-equity-ratio') {
            result = no1 / no2
        } else if (currentMode === 'd-capital-ratio') {
            result = no1 / (no1 + no2)
        }

        if (currentMode === 'bep-unit' || currentMode === 'bep-nominal' || currentMode === 'current-ratio' || currentMode === 'quick-ratio' || currentMode === 'cash-ratio' || currentMode === 'd-aset-ratio' || currentMode === 'd-equity-ratio' || currentMode === 'd-capital-ratio'){
            display.value = formatNumber(result.toString());
            currentNum = result.toString();
            currentMode = null;
        } else if (currentMode === 'gross-profit-margin' || currentMode === 'net-profit-margin'){
            display.value = formatNumber(result.toString()) + "%";
            currentNum = result.toString();
            currentMode = null;
        }
        saveState();
    }

    function updateDisplay() {
        display.value = formatNumber(currentNum);
        saveState();
    }

    function formatNumber(numStr) {
        const [integerPart, decimalPart] = numStr.split('.');
        const formattedIntegerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        return decimalPart ? `${formattedIntegerPart},${decimalPart}` : formattedIntegerPart;
    }

    function saveState() {
        const state = {
            currentNum,
            currentMode,
            displayValue: display.value,
        };
        localStorage.setItem('calculatorState2', JSON.stringify(state));
    }

    function loadState() {
        const state = JSON.parse(localStorage.getItem('calculatorState2'));
        if (state) {
            currentNum = state.currentNum;
            currentMode = state.currentMode;
            display.value = state.displayValue;
        }
    }
});



