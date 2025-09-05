 document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
        });

        function initializeCharts() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Revenue ($)',
                        data: [45000, 42000, 48000, 51000, 47000, 52000],
                        backgroundColor: '#3b82f6'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            // Department Performance Chart
            const deptCtx = document.getElementById('departmentChart').getContext('2d');
            new Chart(deptCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Emergency', 'Cardiology', 'Laboratory', 'Pharmacy', 'Other'],
                    datasets: [{
                        data: [30, 25, 20, 15, 10],
                        backgroundColor: ['#ef4444', '#3b82f6', '#22c55e', '#f59e0b', '#8b5cf6']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            // Bed Occupancy Chart
            const occupancyCtx = document.getElementById('occupancyChart').getContext('2d');
            new Chart(occupancyCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Occupied', 'Available'],
                    datasets: [{
                        data: [87, 13],
                        backgroundColor: ['#3b82f6', '#e5e7eb']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            // Staff Utilization Chart
            const staffCtx = document.getElementById('staffChart').getContext('2d');
            new Chart(staffCtx, {
                type: 'radar',
                data: {
                    labels: ['Doctors', 'Nurses', 'Lab Staff', 'Pharmacists', 'Admin'],
                    datasets: [{
                        label: 'Utilization %',
                        data: [85, 92, 78, 88, 75],
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: '#3b82f6'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        function applyFilters() {
            alert('Applying filters and refreshing reports...');
        }

        function exportReport(format) {
            alert(`Exporting report as ${format.toUpperCase()}...`);
        }

        function scheduleReport() {
            alert('Opening report scheduling dialog...');
        }

        function shareReport() {
            alert('Opening report sharing options...');
        }

        function refreshReports() {
            alert('Refreshing all reports...');
        }

        // Auto-refresh charts every 5 minutes
        setInterval(() => {
            console.log('Auto-refreshing analytics data...');
        }, 300000);
