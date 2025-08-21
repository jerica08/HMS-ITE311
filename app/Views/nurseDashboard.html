<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
	<meta name="viewport" contentwidth="device-width, initial-scale=1.0">
	<title>Nurse Dashboard</title>
    </head>
    <style>
        body{
            font-family:'Inter', sond-serif;
            margin:0;
            padding:0;
            background-color: #f0f4f8;
			min-height: 100vh;
        }
        .top-header {
            background-color: #1a4484; /* Dark blue background */
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-header-title {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .top-header-circle {
            width: 40px;
            height: 40px;
            background-color: black;
            border-radius: 50%;
        }
        .container {
            display: flex;
            flex-grow: 1;
        }
         .sidebar {
            width: 250px;
            background-color: #ffffff;
            border-right: 1px solid #d1d5db;
            padding: 1rem;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            max-height: calc(100vh - 8rem);
            overflow-y: auto;
        }
        .sidebar-menu-item{
            display: block;
            width:auto;
            text-align: center;
            padding:0px;
            border-radius: 8px;
            background-color:  #e5e7eb;
            color:#000000;
            text-decoration:none;
            font-weight: 600;
            border: 16px solid #d1d5db;
            box-shadow: 0 1px 2px rgba(0.0.0.05);
        }
        .sidebar-menu-item:hover {
            background-color: #d1d5db;
            transform: translateY(-2px);
        }

        .sidebar-menu-item.active {
            background-color: #dbe9f6; /* Light blue color from the image */
            color: #1a4484;
            border-color: #93c5fd;
        }

        /* Main content area */
        .main-content {
            flex-grow: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
         .top-controls {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .top-controls label {
            font-weight: 600;
            color: #4b5563;
        }
        
        .top-controls input, .top-controls select {
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            background-color: #ffffff;
            width: 200px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1.5fr;
            gap: 1.5rem;
        }

        .summary-card {
            background-color: #dbe9f6;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .summary-card-text {
            color: #1a4484;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        .to-do-card {
            background-color: #dbe9f6;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .to-do-card h2 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1a4484;
            text-align: center;
        }

        .to-do-card-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-top: auto;
        }

        .to-do-button {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            background-color: #e5e7eb;
            font-weight: 600;
            cursor: pointer;
        }

        /* Content sections */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            flex-grow: 1;
        }

        .dashboard-section {
            background-color: #ffffff;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .dashboard-section h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }

        /* Calendar Styling */
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .calendar-header h3 {
            margin: 0;
            font-size: 1.1rem;
            color: #1f2937;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
            text-align: center;
        }
        
        .calendar-day {
            background-color: #f0f4f8;
            border-radius: 0.5rem;
            padding: 0.75rem 0.5rem;
            border: 1px solid #d1d5db;
            min-height: 80px;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            position: relative;
        }

        .calendar-day-number {
            font-weight: bold;
            color: #1f2937;
            align-self: flex-start;
        }

        .calendar-event {
            background-color: #93c5fd;
            color: #1a4484;
            padding: 0.25rem;
            font-size: 0.7rem;
            border-radius: 0.25rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        #add-event-btn {
            background-color: #1a4484;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #add-event-btn:hover {
            background-color: #143566;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .top-controls {
                flex-direction: column;
                align-items: flex-start;
            }
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #d1d5db;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.5rem;
                max-height: none;
                overflow-y: visible;
            }
            .sidebar-menu-item {
                flex-grow: 1;
            }
            .summary-grid {
                grid-template-columns: 1fr;
            }
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }


     
    </style>
    <body>
        <header class="top-header">
            <div style="display:flex;align-items:center;gap:16px;">
                <span class="top-header-title"> LOGO</span>
                <span class="top-header-title"> NURSE DASHBOARD</span>
            </div>
            <div class="top-header-circle"></div>
        </header>  
        <div class="container">

            <aside class="sidebar">
                <a href="" class="sidebar-menu-item active">Dashboard</a> 
                <a href="" class="sidebar-menu-item ">Patient</a> 
                <a href="" class="sidebar-menu-item ">Medication</a> 
                <a href="" class="sidebar-menu-item ">Task and Appointments</a> 
                <a href="" class="sidebar-menu-item ">Reports</a> 
                <a href="" class="sidebar-menu-item ">Communication</a> 
                <a href="" class="sidebar-menu-item ">Profile Setting</a> 
            </aside>

            <main class="main-content">
                <div class="top-cotrols">
                    <label>Search:</label>
                    <input type="text" placeholder="Search...">
                    <label>Date:</label>
                    <input type="date">
                    <label>Current Shift:</label>
                    <select id="shift" name="shift">
                        <option value="day"> Day Shift</option>
                        <option value="night"> Night Shift</option>
                    </select>
                </div>

                <div class="summary-grid">
                    <div class="summary-card">
                        <div style="text-align:center;color:#1f2937;font-size:20px; font-weight: 600;">
                            Total: <span style="font-weight: 700;">15</span><br>
                            Critical: <span style="font-weight: 700;">3</span>
                        </div>
                        <a ref="" style="text-decoration: none; color:#4a8fe0; font-weight: 600;font-size: 14.4px;margin-top: 8px;">View List</a>
                        <span class="summary-card-text">Patient Summary</span>     
                    </div>            
                

                    <div class="summary-card">
                        <div style="text-align: center;color:#1f2937;font-size:20px; font-weight: 600;">
                            Word: <span style="font-weight: 700;">2b</span><br>
                            Next Handover: <span style="font-weight: 700;">7 PM</span>
                        </div>
                        <span class="summary-card-text" style="margin-top: 32px;"> Shift Info</span>
                    </div>

                    <div class="to-do-card">
                        <h2>To Do</h2>

                        <div style="flex-grow: 1;"></div>
                        <div class="to-do-card-buttons">
                            <button class="to-do-button">Add</button>                        
                            <button class="to-do-button">Edit</button>                        
                        </div>
                    </div>  
                </div>

                <div class="dashboard-grid">
                    <!--calendar section-->
                    <div class="dashboard-section">
                      <div class="calendar-header">
                            <h2> Calendar Schedule</h2>
                            <button id="add-event-btn">Add Button</button>
                      </div>  
                    
                      <div class="calendar-grid">
                        <span style="font-weight: bold; color:#6b7280;">Sun</span>
                        <span style="font-weight: bold; color:#6b7280;">Mon</span>
                        <span style="font-weight: bold; color:#6b7280;">Tue</span>
                        <span style="font-weight: bold; color:#6b7280;">Wed</span>
                        <span style="font-weight: bold; color:#6b7280;">Thu</span>
                        <span style="font-weight: bold; color:#6b7280;">Fri</span>
                        <span style="font-weight: bold; color:#6b7280;">Sat</span>

                         <!-- Dummy days will be replaced by JavaScript -->
                        <div class="calendar-day" data-day="1">
                            <span class="calendar-day-number">1</span>
                        </div>
                        <div class="calendar-day" data-day="2">
                            <span class="calendar-day-number">2</span>
                        </div>
                        <div class="calendar-day" data-day="3">
                            <span class="calendar-day-number">3</span>
                        </div>
                        <div class="calendar-day" data-day="4">
                            <span class="calendar-day-number">4</span>
                        </div>
                        <div class="calendar-day" data-day="5">
                            <span class="calendar-day-number">5</span>
                        </div>
                        <div class="calendar-day" data-day="6">
                            <span class="calendar-day-number">6</span>
                        </div>
                        <div class="calendar-day" data-day="7">
                            <span class="calendar-day-number">7</span>
                        </div>
                        <div class="calendar-day" data-day="8">
                            <span class="calendar-day-number">8</span>
                        </div>
                        <div class="calendar-day" data-day="9">
                            <span class="calendar-day-number">9</span>
                        </div>
                        <div class="calendar-day" data-day="10">
                            <span class="calendar-day-number">10</span>
                        </div>
                        <div class="calendar-day" data-day="11">
                            <span class="calendar-day-number">11</span>
                        </div>
                        <div class="calendar-day" data-day="12">
                            <span class="calendar-day-number">12</span>
                        </div>
                        <div class="calendar-day" data-day="13">
                            <span class="calendar-day-number">13</span>
                        </div>
                        <div class="calendar-day" data-day="14">
                            <span class="calendar-day-number">14</span>
                        </div>
                        <div class="calendar-day" data-day="15">
                            <span class="calendar-day-number">15</span>
                        </div>
                        <div class="calendar-day" data-day="16">
                            <span class="calendar-day-number">16</span>
                        </div>
                        <div class="calendar-day" data-day="17">
                            <span class="calendar-day-number">17</span>
                        </div>
                        <div class="calendar-day" data-day="18">
                            <span class="calendar-day-number">18</span>
                        </div>
                        <div class="calendar-day" data-day="19">
                            <span class="calendar-day-number">19</span>
                        </div>
                        <div class="calendar-day" data-day="20">
                            <span class="calendar-day-number">20</span>
                        </div>
                        <div class="calendar-day" data-day="21">
                            <span class="calendar-day-number">21</span>
                        </div>
                        <div class="calendar-day" data-day="22">
                            <span class="calendar-day-number">22</span>
                        </div>
                        <div class="calendar-day" data-day="23">
                            <span class="calendar-day-number">23</span>
                        </div>
                        <div class="calendar-day" data-day="24">
                            <span class="calendar-day-number">24</span>
                        </div>
                        <div class="calendar-day" data-day="25">
                            <span class="calendar-day-number">25</span>
                        </div>
                        <div class="calendar-day" data-day="26">
                            <span class="calendar-day-number">26</span>
                        </div>
                        <div class="calendar-day" data-day="27">
                            <span class="calendar-day-number">27</span>
                        </div>
                        <div class="calendar-day" data-day="28">
                            <span class="calendar-day-number">28</span>
                        </div>
                        <div class="calendar-day" data-day="29">
                            <span class="calendar-day-number">29</span>
                        </div>
                        <div class="calendar-day" data-day="30">
                            <span class="calendar-day-number">30</span>
                        </div>
                    </div>
                    
                    <!-- Notifications Section -->
                <div class="dashboard-section">
                    <h2>Alerts and Notifications</h2>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.9rem;">
                        <li style="margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #e5e7eb; background-color: #f8fafc; padding: 0.5rem; border-radius: 0.5rem;">
                            <span style="font-weight: 600; display: block;">New Task Assignment</span>
                            <span style="color: #6b7280;">Check vitals for Room 205.</span>
                        </li>
                        <li style="margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #e5e7eb; background-color: #f8fafc; padding: 0.5rem; border-radius: 0.5rem;">
                            <span style="font-weight: 600; display: block;">Patient Request</span>
                            <span style="color: #6b7280;">Patient in Room 311 needs assistance.</span>
                        </li>
                        <li style="margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #e5e7eb; background-color: #dbe9f6; padding: 0.5rem; border-radius: 0.5rem;">
                            <span style="font-weight: 600; display: block;">Critical Patient Alert</span>
                            <span style="color: #1a4484;">Patient in Room 207 has unstable vitals.</span>
                        </li>
                    </ul>
                </div>
                </div>

            </main>
        </div>             
    </body>
</html>