<html>
    <head>
        <title>Dashboard</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SzlrxWriC3bVc7YomEmP6wO5D5p50bJQ5qk7lX04EC1YQFZCSftd1LZCfmhktq3Ze7C2FjQZ6rq1q6yZ3Yxug==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="<?php echo APP_URL; ?>assets/css/app.css">
    </head>
    <body>
        <div class="layout">
            <?php include APP_PATH . '/app/views/partials/sidebar.php'; ?>
            <main class="main-content">
                <div class="header">
                    <div class="page-title">Dashboard</div>
                    <div class="user-actions">
                        <div class="notification-icon">
                            <i class="fas fa-bell"></i>
                            <div class="notification-badge">3</div>
                        </div>
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>

                <div class="cards-container">
                    <div class="card">
                        <div class="card-title">Total de Equipos</div>
                        <div class="card-value">142</div>
                        <div class="card-footer">
                            <i class="fas fa-box"></i>
                            <span>En inventario</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">Equipos Disponibles</div>
                        <div class="card-value">87</div>
                        <div class="card-footer positive">
                            <i class="fas fa-check-circle"></i>
                            <span>Disponibles para préstamo</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">Préstamos Activos</div>
                        <div class="card-value">32</div>
                        <div class="card-footer">
                            <i class="fas fa-calendar-check"></i>
                            <span>En curso</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">Préstamos Vencidos</div>
                        <div class="card-value">5</div>
                        <div class="card-footer negative">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Requieren atención</span>
                        </div>
                    </div>
                </div>

                <div class="chart-container">
                    <div class="chart-title">Equipos por Categoría</div>
                    <div style="height: 100%; display: flex; align-items: center; justify-content: center; color: #999;">
                        [Gráfico de equipos por categoría]
                    </div>
                </div>

                <div class="recent-loans">
                    <div class="section-title">Préstamos Recientes</div>

                    <div class="loan-item">
                        <div class="loan-info">
                            <div class="loan-icon">
                                <i class="fas fa-laptop"></i>
                            </div>
                            <div class="loan-details">
                                <h4>Laptop HP EliteBook</h4>
                                <p>Prestado a: María González • 15 Oct 2023</p>
                            </div>
                        </div>
                        <div class="loan-status status-active">
                            Activo (hasta 25 Oct)
                        </div>
                    </div>

                    <div class="loan-item">
                        <div class="loan-info">
                            <div class="loan-icon">
                                <i class="fas fa-video"></i>
                            </div>
                            <div class="loan-details">
                                <h4>Videobeam Epson</h4>
                                <p>Prestado a: Carlos Rodríguez • 14 Oct 2023</p>
                            </div>
                        </div>
                        <div class="loan-status status-overdue">
                            Vencido (desde 18 Oct)
                        </div>
                    </div>

                    <div class="loan-item">
                        <div class="loan-info">
                            <div class="loan-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                            <div class="loan-details">
                                <h4>Cámara Canon EOS</h4>
                                <p>Prestado a: Laura Sánchez • 12 Oct 2023</p>
                            </div>
                        </div>
                        <div class="loan-status status-active">
                            Activo (hasta 20 Oct)
                        </div>
                    </div>

                    <div class="view-all">
                        <a href="#">Ver todos los préstamos →</a>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>