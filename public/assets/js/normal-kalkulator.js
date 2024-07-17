// 

document.addEventListener('DOMContentLoaded', () => {
    const display = document.querySelector('#display');
    const buttons = document.querySelectorAll('.num');
    const operators = document.querySelectorAll('.operator');
    const clear = document.querySelector('#clear');
    const equals = document.querySelector('#equals');
    const del = document.querySelector('#delete');
    var modal = document.querySelector(".modal");
    const sound1 = document.getElementById('sound1'); 
    const sound2 = document.getElementById('sound2');

    let currentNum = '';
    let prevNum = '';
    let result = null;
    let currentOperator = null;

    loadState();

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
        handleEqualsClick(e);
        playSound(sound2);
    });
    clear.addEventListener('click', (e) => {
        handleClearClick(e);
        playSound(sound2); 
    });
    del.addEventListener('click', (e) => {
        handleDeleteClick(e);
        playSound(sound2); 
    });

    function playSound(sound) {
        sound.currentTime = 0; 
        sound.play();
    }

    equals.addEventListener('click', handleEqualsClick);
    clear.addEventListener('click', handleClearClick);
    del.addEventListener('click', handleDeleteClick);

    function handleNumberClick(e) {
        if (result !== null) {
            currentNum = '';
            result = null;
        }
        currentNum += e.target.value;
        updateDisplay();
        saveState();
    }

    function handleOperatorClick(e) {
        if (currentNum === '') return;

        if (currentOperator !== null) {
            calculate();
        }

        currentOperator = e.target.value;
        prevNum = currentNum;
        currentNum = '';
        updateDisplay();
        saveState();
    }

    function handleEqualsClick() {
        if (currentOperator === null || currentNum === '') return;
        calculate();
        saveState();
    }

    function handleClearClick() {
        currentNum = '';
        prevNum = '';
        result = null;
        currentOperator = null;
        display.value = '';
        saveState();
    }

    function handleDeleteClick() {
        if (currentNum !== '') {
            currentNum = currentNum.slice(0, -1);
            updateDisplay();
            saveState();
        }
    }

    function calculate() {
        const prev = parseFloat(prevNum.replace(/,/g, '.'));
        const current = parseFloat(currentNum.replace(/,/g, '.'));
        if (isNaN(prev) || isNaN(current)) return;

        switch (currentOperator) {
            case '+':
                result = prev + current;
                break;
            case '-':
                result = prev - current;
                break;
            case '*':
                result = prev * current;
                break;
            case '/':
                if (current === 0) {
                    alert("Cannot divide by zero");
                    return;
                }
                result = prev / current;
                break;
        }

        currentNum = result.toString().replace('.', ',');
        currentOperator = null;
        prevNum = '';
        updateDisplay();
    }

    function updateDisplay() {
        if (currentOperator !== null && currentNum === '') {
            display.value = `${formatNumber(prevNum)} ${currentOperator}`;
        } else if (currentOperator !== null) {
            display.value = `${formatNumber(prevNum)} ${currentOperator} ${formatNumber(currentNum)}`;
        } else {
            display.value = formatNumber(currentNum);
        }
    }

    function formatNumber(numStr) {
        const parts = numStr.split(',');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        return parts.join(',');
    }

    function saveState() {
        const state = {
            currentNum,
            prevNum,
            currentOperator,
            displayValue: display.value,
        };
        localStorage.setItem('calculatorState', JSON.stringify(state));
    }

    function loadState() {
        const state = JSON.parse(localStorage.getItem('calculatorState'));
        if (state) {
            currentNum = state.currentNum;
            prevNum = state.prevNum;
            currentOperator = state.currentOperator;
            display.value = state.displayValue;
        }
    }
});
