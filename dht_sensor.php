<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DHT Sensor Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <style>
        :root {
            --primary: #4a6bff;
            --secondary: #ff6b6b;
            --background: #f7f9fc;
            --card-bg: #ffffff;
            --text: #333333;
            --border: #e0e6ed;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--background);
            color: var(--text);
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
            background: linear-gradient(135deg, var(--primary), #7a4efd);
            border-radius: 12px;
            padding: 20px;
            color: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h2 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card h2 span {
            height: 20px;
            width: 20px;
            border-radius: 50%;
            display: inline-block;
        }

        .card h2 span.temp {
            background: linear-gradient(45deg, #ff7e5f, #feb47b);
        }

        .card h2 span.humidity {
            background: linear-gradient(45deg, #4facfe, #00f2fe);
        }

        .value {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 10px 0;
            text-align: center;
        }

        .value-temp {
            color: #ff7e5f;
        }

        .value-humidity {
            color: #4facfe;
        }

        .timestamp {
            text-align: right;
            font-size: 0.85rem;
            color: #888;
            margin-top: 10px;
        }

        .charts {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .chart-container {
            height: 300px;
            position: relative;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            background: linear-gradient(135deg, #7a4efd, var(--primary));
            border-radius: 12px;
            color: white;
        }

        footer h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .subscribe-btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #ff0000;
            color: white;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 15px;
            box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .subscribe-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(255, 0, 0, 0.4);
        }

        .sensor-status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 10px;
        }

        .status-online {
            background-color: rgba(46, 213, 115, 0.15);
            color: #2ed573;
        }

        .status-offline {
            background-color: rgba(255, 71, 87, 0.15);
            color: #ff4757;
        }

        .sparkle {
            display: inline-block;
            animation: sparkle 1.5s infinite alternate;
        }

        @keyframes sparkle {
            0% { opacity: 0.7; transform: scale(0.95); }
            100% { opacity: 1; transform: scale(1.05); }
        }

        .last-updated {
            text-align: center;
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: #777;
        }

        @media (max-width: 768px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>DHT Sensor Dashboard <span class="sparkle">✨</span></h1>
            <p>Real-time temperature and humidity monitoring</p>
        </header>

        <div class="last-updated">Last updated: <span id="update-time">Loading...</span></div>

        <div class="dashboard">
            <div class="card">
                <h2><span class="temp"></span>Temperature</h2>
                <div class="value value-temp" id="current-temp">--°C</div>
                <div class="timestamp" id="temp-time">--</div>
                <div class="sensor-status status-online">Sensor Online</div>
            </div>
            <div class="card">
                <h2><span class="humidity"></span>Humidity</h2>
                <div class="value value-humidity" id="current-humidity">--%</div>
                <div class="timestamp" id="humidity-time">--</div>
                <div class="sensor-status status-online">Sensor Online</div>
            </div>
        </div>

        <div class="charts">
            <div class="chart-card">
                <h2>Temperature & Humidity History</h2>
                <div class="chart-container">
                    <canvas id="sensor-chart"></canvas>
                </div>
            </div>
        </div>

        <footer>
            <h3>Yarana IoT Guru</h3>
            <p>Smart Sensor Solutions for Modern IoT Applications</p>
            <a href="https://www.youtube.com/channel/YaranaIoTGuru" target="_blank" class="subscribe-btn">
                Subscribe to Our YouTube Channel
            </a>
        </footer>
    </div>

    <script>
        // Configuration
        const updateInterval = 5000; // Update interval in milliseconds (5 seconds)
        let sensorData = [];
        const maxDataPoints = 20; // Maximum number of data points to show on chart
        
        // Initialize chart
        const ctx = document.getElementById('sensor-chart').getContext('2d');
        const sensorChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Temperature (°C)',
                        data: [],
                        borderColor: '#ff7e5f',
                        backgroundColor: 'rgba(255, 126, 95, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        pointHoverRadius: 5
                    },
                    {
                        label: 'Humidity (%)',
                        data: [],
                        borderColor: '#4facfe',
                        backgroundColor: 'rgba(79, 172, 254, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        pointHoverRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#333',
                        bodyColor: '#333',
                        borderColor: '#e0e6ed',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y;
                                    if (context.datasetIndex === 0) {
                                        label += '°C';
                                    } else {
                                        label += '%';
                                    }
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 0,
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        beginAtZero: false,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });

        // Function to fetch sensor data from server
        function fetchSensorData() {
            $.ajax({
                url: 'fetch_data.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        updateDashboard(data);
                        updateChart(data);
                        document.getElementById('update-time').textContent = moment().format('MMMM D, YYYY HH:mm:ss');
                        
                        // Update sensor status
                        const lastReading = new Date(data[0].created_at);
                        const now = new Date();
                        const diffMinutes = (now - lastReading) / (1000 * 60);
                        
                        const statusElements = document.querySelectorAll('.sensor-status');
                        if (diffMinutes > 2) {
                            statusElements.forEach(el => {
                                el.textContent = 'Sensor Offline';
                                el.classList.remove('status-online');
                                el.classList.add('status-offline');
                            });
                        } else {
                            statusElements.forEach(el => {
                                el.textContent = 'Sensor Online';
                                el.classList.remove('status-offline');
                                el.classList.add('status-online');
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching sensor data:', error);
                }
            });
        }

        // Update dashboard with latest values
        function updateDashboard(data) {
            const latestReading = data[0];
            
            document.getElementById('current-temp').textContent = latestReading.temperature + '°C';
            document.getElementById('current-humidity').textContent = latestReading.humidity + '%';
            
            document.getElementById('temp-time').textContent = moment(latestReading.created_at).format('HH:mm:ss');
            document.getElementById('humidity-time').textContent = moment(latestReading.created_at).format('HH:mm:ss');
        }

        // Update chart with new data
        function updateChart(data) {
            // Reverse data to show oldest first
            const chartData = [...data].reverse();
            
            // Limit to max data points
            const limitedData = chartData.slice(-maxDataPoints);
            
            // Extract labels and values
            const labels = limitedData.map(item => moment(item.created_at).format('HH:mm:ss'));
            const tempData = limitedData.map(item => item.temperature);
            const humidityData = limitedData.map(item => item.humidity);
            
            // Update chart
            sensorChart.data.labels = labels;
            sensorChart.data.datasets[0].data = tempData;
            sensorChart.data.datasets[1].data = humidityData;
            sensorChart.update();
        }

        // Create PHP file to fetch data from database
        $.ajax({
            url: 'create_fetch_script.php',
            type: 'POST',
            data: {
                action: 'create_file',
                content: `<?php
                    // Database connection
                    require_once 'config.php';
                    
                    // Get the latest records
                    $query = "SELECT id, temperature, humidity, created_at FROM sensor_data ORDER BY created_at DESC LIMIT 50";
                    $result = mysqli_query($conn, $query);
                    
                    $data = array();
                    
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $data[] = array(
                                'id' => $row['id'],
                                'temperature' => floatval($row['temperature']),
                                'humidity' => floatval($row['humidity']),
                                'created_at' => $row['created_at']
                            );
                        }
                    }
                    
                    // Close connection
                    mysqli_close($conn);
                    
                    // Return data as JSON
                    header('Content-Type: application/json');
                    echo json_encode($data);
                ?>`
            },
            success: function(response) {
                console.log('Fetch script created successfully');
            },
            error: function(xhr, status, error) {
                console.error('Error creating fetch script:', error);
            }
        });

        // Initial data fetch
        fetchSensorData();
        
        // Set up interval for regular updates
        setInterval(fetchSensorData, updateInterval);
    </script>
</body>
</html>