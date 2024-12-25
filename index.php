<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prediction Display</title>
    <style>
        /* Body styling */
        body {
            margin: 0;
            font-family: 'Courier New', Courier, monospace;
            background-color: #1a1a1a;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #FF0000;
            overflow: hidden;
        }

        /* Container styling */
        .container {
            width: 330px;
            background: #00FFFF;
            padding: 10px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        /* Header styling */
        h1 {
            font-size: 2em;
            color: #FF0000;
            text-shadow: 0 0 10px #00ffcc;
            margin: 0;
        }

        /* Boxes styling */
        .box {
            background: #1e1e1e;
            padding: 15px;
            border-radius: 15px;
            margin: 15px 0;
            border: 2px solid #FF00FF;
            color: #FF0000;
            font-size: 1.8em;
            box-shadow: 0 0 15px rgba(0, 255, 204, 0.3);
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .box:hover {
            transform: scale(1.05);
            background-color: #262626;
        }

        /* Timer styling */
        #timer {
            font-size: 2em;
            color: #FF0000;
            text-shadow: 0 0 10px #00ffcc;
        }

        /* History box styling */
        .history-box {
            background: #1e1e1e;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            border: 1px solid #FF00FF;
            max-height: 150px;
            overflow-y: auto;
            box-shadow: 0 0 15px rgba(0, 255, 204, 0.3);
        }

        .history-list {
            list-style: none;
            padding: 0;
            margin: 0;
            color: #FF00FF;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            margin-bottom: 5px;
            background: #121212;
            border-radius: 5px;
            color: #FF00FF;
            font-weight: bold;
        }
        
        } /*font*/
              font-size: 1.8em;
        }

        /* Animation */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        .result-update {
            animation: pulse 1s ease infinite;
        }
    </style>
</head>
<body>


<div class="container">
    <h1>TEAM_KBT PREMIUM WEB </h1>

    <div
    <div class="kbt">
        <div> WINGO 30 SEC SELECTED </div>
    <div>


    <div class="box">
        <div>CURRENT PERIOD </div>
        <div id="periodNumber">checking...</div>
    </div>

    
    <div class="box result-update" id="currentResultContainer">
        <div>PRESENT RESULT </div>
        <div id="currentResult">Waiting...</div>
    </div>
    
    
    <div class="history-box">
        <div>LAST RESULT HISTORY</div>
        <ul id="history" class="history-list"></ul>
    </div>

</div>

<script>
    const periodNumberElement = document.getElementById('periodNumber');
    const timerElement = document.getElementById('timer');
    const currentResultElement = document.getElementById('currentResult');
    const currentResultContainer = document.getElementById('currentResultContainer');
    const historyElement = document.getElementById('history');

    const results = [
        'BIG', 'SMALL', 'RED', 'GREEN'
    ];

    let lastDisplayedPeriod = -1;
    let firstPeriodDisplayed = false;

    function getRandomResult() {
        return results[Math.floor(Math.random() * results.length)];
    }

    function updatePeriodAndResult() {
        const now = new Date();
        const utcYear = now.getUTCFullYear();
        const utcMonth = String(now.getUTCMonth() + 1).padStart(2, '0');
        const utcDay = String(now.getUTCDate()).padStart(2, '0');
        const utcHours = now.getUTCHours();
        const utcMinutes = now.getUTCMinutes();
        const seconds = now.getUTCSeconds();
        const remainingSeconds = 30 - (seconds % 30);

        // Calculate period number for each 30-second interval
        const totalMinutes = utcHours * 60 + utcMinutes;
        const periodNumber = 10001 + totalMinutes * 2 + (seconds >= 30 ? 1 : 0);
        const periodString = `${utcYear}${utcMonth}${utcDay}30${periodNumber}`;

        // Update period number display
        periodNumberElement.textContent = periodString;

        // Show a new random result only once per period change
        if (periodNumber !== lastDisplayedPeriod) {
            lastDisplayedPeriod = periodNumber;

            // Avoid showing a result on the very first load
            if (firstPeriodDisplayed) {
                // Display a random result
                const result = getRandomResult();
                currentResultElement.textContent = result;
                currentResultContainer.classList.remove('result-update'); // Reset animation
                void currentResultContainer.offsetWidth; // Trigger reflow for animation reset
                currentResultContainer.classList.add('result-update');

                // Add result to history
                const historyItem = document.createElement('li');
                historyItem.className = 'history-item';

                const periodDiv = document.createElement('span');
                periodDiv.textContent = periodString;

                const resultDiv = document.createElement('span');
                resultDiv.textContent = result;

                historyItem.appendChild(periodDiv);
                historyItem.appendChild(resultDiv);
                historyElement.prepend(historyItem);
            } else {
                // Mark that the first period display is done
                firstPeriodDisplayed = true;
            }
        }

        // Update timer display
        const secondsDisplay = remainingSeconds.toString().padStart(2, '0');
        timerElement.textContent = `00:${secondsDisplay}`;
    }

    setInterval(updatePeriodAndResult, 1000); // Update every second
</script>

</body>
</html>