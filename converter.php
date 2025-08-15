<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter | Blue & White Theme</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1a73e8;
            --dark-blue: #0d47a1;
            --light-blue: #e8f0fe;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --medium-gray: #e0e0e0;
            --dark-gray: #5f6368;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: var(--light-gray);
            color: var(--dark-gray);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            line-height: 1.6;
        }
        
        .header-container {
            width: 100%;
            max-width: 600px;
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-start;
        }
        
        .back-btn {
            background: var(--primary-blue);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .back-btn:hover {
            background: var(--dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .converter-container {
            width: 100%;
            max-width: 600px;
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
            position: relative;
        }
        
        .converter-header {
            background: var(--primary-blue);
            padding: 20px;
            color: var(--white);
            text-align: center;
        }
        
        .converter-header h1 {
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            font-size: 1.8rem;
            margin-bottom: 5px;
        }
        
        .converter-header p {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .converter-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-gray);
            font-size: 0.95rem;
        }
        
        input, select {
            width: 100%;
            padding: 12px 15px;
            background: var(--white);
            border: 1px solid var(--medium-gray);
            border-radius: 6px;
            color: var(--dark-gray);
            font-family: 'Open Sans', sans-serif;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
        }
        
        input::placeholder {
            color: rgba(95, 99, 104, 0.5);
        }
        
        .currency-row {
            display: flex;
            gap: 15px;
        }
        
        .currency-row .form-group {
            flex: 1;
        }
        
        .swap-btn {
            background: var(--light-blue);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: var(--primary-blue);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .swap-btn:hover {
            background: var(--primary-blue);
            color: var(--white);
            transform: rotate(180deg);
        }
        
        button.convert-btn {
            background: var(--primary-blue);
            color: var(--white);
            padding: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 10px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        button.convert-btn:hover {
            background: var(--dark-blue);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        button.convert-btn:active {
            transform: translateY(0);
        }
        
        #result {
            margin-top: 25px;
            padding: 15px;
            background: var(--light-blue);
            border-radius: 6px;
            border-left: 3px solid var(--primary-blue);
            font-family: 'Roboto', sans-serif;
            font-size: 1.1rem;
            text-align: center;
            display: none;
            color: var(--dark-blue);
            animation: fadeIn 0.3s ease;
        }
        
        .rates-container {
            margin-top: 30px;
            background: var(--light-gray);
            border-radius: 6px;
            padding: 20px;
        }
        
        .rates-container h3 {
            color: var(--primary-blue);
            margin-bottom: 15px;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .rates-container h3 svg {
            margin-right: 8px;
        }
        
        #rateList {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }
        
        #rateList div {
            font-family: 'Roboto', sans-serif;
            font-size: 0.9rem;
            padding: 10px;
            background: var(--white);
            border-radius: 4px;
            color: var(--dark-gray);
            border-left: 2px solid var(--primary-blue);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 480px) {
            .converter-body {
                padding: 20px;
            }
            
            .converter-header h1 {
                font-size: 1.5rem;
            }
            
            .currency-row {
                flex-direction: column;
                gap: 20px;
            }
            
            #rateList {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header-container">
        <a href="index.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="converter-container">
        <div class="converter-header">
            <h1>Currency Converter</h1>
            <p>Real-time exchange rates calculator</p>
        </div>
        <div class="converter-body">
            <div class="form-group">
                <label for="amount">Amount to Convert</label>
                <input type="number" id="amount" placeholder="Enter amount" min="0" step="0.01">
            </div>
            
            <div class="currency-row">
                <div class="form-group">
                    <label for="from">From Currency</label>
                    <select id="from">
                        <option value="USD">US Dollar (USD)</option>
                        <option value="EUR">Euro (EUR)</option>
                        <option value="GBP">British Pound (GBP)</option>
                        <option value="JPY">Japanese Yen (JPY)</option>
                        <option value="AUD">Australian Dollar (AUD)</option>
                    </select>
                </div>
                
                <button class="swap-btn" onclick="swapCurrencies()" title="Swap currencies">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="17 1 21 5 17 9"></polyline>
                        <path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
                        <polyline points="7 23 3 19 7 15"></polyline>
                        <path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
                    </svg>
                </button>
                
                <div class="form-group">
                    <label for="to">To Currency</label>
                    <select id="to">
                        <option value="EUR">Euro (EUR)</option>
                        <option value="USD">US Dollar (USD)</option>
                        <option value="GBP">British Pound (GBP)</option>
                        <option value="JPY">Japanese Yen (JPY)</option>
                        <option value="AUD">Australian Dollar (AUD)</option>
                    </select>
                </div>
            </div>
            
            <button class="convert-btn" onclick="convertCurrency()">Convert Currency</button>
            
            <div id="result"></div>
            
            <div class="rates-container">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                    Current Exchange Rates (USD based)
                </h3>
                <div id="rateList"></div>
            </div>
        </div>
    </div>

    <script>
        // Exchange rates (sample data - in a real app you'd fetch these from an API)
        const rates = {
            USD: 1.0,     // US Dollar (base)
            EUR: 0.93,    // Euro
            GBP: 0.79,    // British Pound
            JPY: 151.53,  // Japanese Yen
            AUD: 1.52     // Australian Dollar
        };

        // Display exchange rates on page load
        document.addEventListener('DOMContentLoaded', function() {
            displayRates();
        });

        function displayRates() {
            const rateList = document.getElementById('rateList');
            rateList.innerHTML = '';
            
            for (const currency in rates) {
                if (currency !== 'USD') {
                    const rateItem = document.createElement('div');
                    rateItem.textContent = `1 USD = ${rates[currency].toFixed(4)} ${currency}`;
                    rateList.appendChild(rateItem);
                }
            }
        }

        function convertCurrency() {
            // Get input values
            const amount = parseFloat(document.getElementById('amount').value);
            const fromCurrency = document.getElementById('from').value;
            const toCurrency = document.getElementById('to').value;
            
            // Validate input
            if (isNaN(amount)) {
                showError('Please enter a valid amount');
                return;
            }
            
            if (amount <= 0) {
                showError('Amount must be greater than zero');
                return;
            }
            
            // Perform conversion
            const result = (amount / rates[fromCurrency]) * rates[toCurrency];
            
            // Display result
            const resultElement = document.getElementById('result');
            resultElement.innerHTML = `
                <strong>${amount.toFixed(2)} ${fromCurrency} = ${result.toFixed(2)} ${toCurrency}</strong>
            `;
            resultElement.style.display = 'block';
        }
        
        function swapCurrencies() {
            const fromSelect = document.getElementById('from');
            const toSelect = document.getElementById('to');
            
            const temp = fromSelect.value;
            fromSelect.value = toSelect.value;
            toSelect.value = temp;
        }
        
        function showError(message) {
            const resultElement = document.getElementById('result');
            resultElement.innerHTML = `<span style="color: #d32f2f;">${message}</span>`;
            resultElement.style.display = 'block';
        }
    </script>
</body>
</html>