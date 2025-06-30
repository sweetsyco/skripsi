<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
            // Chart permintaan bulanan
            const permintaanCtx = document.getElementById('permintaanChart').getContext('2d');
            const permintaanChart = new Chart(permintaanCtx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode(array_column($grafik_permintaan, 'bulan')) ?>,
                    datasets: [{
                        label: <?= json_encode(array_column($grafik_permintaan, 'total_aktif')) ?>,
                        data: [8, 12, 6, 9, 11, 7],
                        backgroundColor: 'rgba(44, 120, 108, 0.7)',
                        borderColor: 'rgba(44, 120, 108, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Permintaan Selesai',
                        data: <?= json_encode(array_column($grafik_permintaan, 'total_selesai')) ?>,
                        backgroundColor: 'rgba(40, 167, 69, 0.7)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 2
                            }
                        }
                    }
                }
            });
            
            // Chart distribusi komoditas
            const komoditasCtx = document.getElementById('komoditasChart').getContext('2d');
            const komoditasChart = new Chart(komoditasCtx, {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode(array_column($distribusi_komoditas, 'nama_komoditas')) ?>,
                    datasets: [{
                        data: <?= json_encode(array_column($distribusi_komoditas, 'jumlah')) ?>,
                        backgroundColor: [
                            'rgba(44, 120, 108, 0.8)',
                            'rgba(255, 152, 0, 0.8)',
                            'rgba(23, 162, 184, 0.8)',
                            'rgba(220, 53, 69, 0.8)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
            
            // Fungsi untuk animasi stat card
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
                
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.5s, transform 0.5s';
            });
            
            // Animasi untuk commodity items
            const commodityItems = document.querySelectorAll('.commodity-item');
            commodityItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, index * 150 + 600);
                
                item.style.opacity = '0';
                item.style.transform = 'translateX(20px)';
                item.style.transition = 'opacity 0.5s, transform 0.5s';
            });
        });
</script>
</body>
</html>