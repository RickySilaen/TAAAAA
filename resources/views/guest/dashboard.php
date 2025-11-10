<?php
$totalCrops    = $totalCrops ?? 25;
$farmingGuides = $farmingGuides ?? 12;
$weatherUpdates= $weatherUpdates ?? 'Daily';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Guest Dashboard - Sistem Pertanian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        :root {
            --primary-green: #4CAF50;
            --light-green: #81C784;
            --dark-green: #2E7D32;
            --gradient: linear-gradient(135deg, #4CAF50, #45a049);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .dashboard-container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .welcome-section {
            background: var(--gradient);
            color: #fff;
            padding: 3rem 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(76, 175, 80, 0.3);
            position: relative;
            overflow: hidden;
            animation: slideInFromTop 1s ease-out;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.1;
            animation: float 20s ease-in-out infinite;
        }

        .welcome-content {
            position: relative;
            z-index: 1;
            animation: fadeInUp 1.2s ease-out 0.3s both;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            padding: 2rem 1.5rem;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(76, 175, 80, 0.1);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out both;
            animation-delay: calc(var(--i) * 0.1s);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(76, 175, 80, 0.1), transparent);
            transition: left 0.6s;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(76, 175, 80, 0.2);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .stat-card:nth-child(1) .stat-icon {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
        }

        .stat-card:nth-child(2) .stat-icon {
            background: linear-gradient(135deg, #2196F3, #1976D2);
            color: white;
        }

        .stat-card:nth-child(3) .stat-icon {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            color: white;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .stat-title {
            color: #666;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-green);
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-value {
            transform: scale(1.05);
        }

        .stat-description {
            color: #888;
            font-size: 0.85rem;
            margin: 0;
        }

        .recent-activity {
            background: #fff;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            animation: fadeInUp 1s ease-out 0.5s both;
        }

        .activity-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .activity-header i {
            font-size: 1.5rem;
            color: var(--primary-green);
            margin-right: 1rem;
        }

        .activity-header h2 {
            margin: 0;
            color: #333;
            font-weight: 600;
        }

        .feature-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid rgba(0,0,0,0.05);
            overflow: hidden;
            position: relative;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--gradient);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .feature-card:hover::before {
            transform: scaleY(1);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .feature-card:nth-child(1) .feature-icon {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
        }

        .feature-card:nth-child(2) .feature-icon {
            background: linear-gradient(135deg, #2196F3, #1976D2);
            color: white;
        }

        .feature-card:nth-child(3) .feature-icon {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            color: white;
        }

        .feature-card .btn {
            background: var(--gradient);
            border: none;
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transition: width 0.6s, height 0.6s;
            transform: translate(-50%, -50%);
        }

        .feature-card .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .feature-card .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
        }

        /* Animations */
        @keyframes slideInFromTop {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem;
            }

            .welcome-section {
                padding: 2rem 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stat-card {
                padding: 1.5rem 1rem;
            }

            .stat-value {
                font-size: 2rem;
            }

            .recent-activity {
                padding: 2rem 1.5rem;
            }

            .activity-header {
                flex-direction: column;
                text-align: center;
            }

            .activity-header i {
                margin-right: 0;
                margin-bottom: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .welcome-section {
                padding: 1.5rem 1rem;
            }

            .welcome-section h1 {
                font-size: 1.5rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .feature-card .card-body {
                padding: 1.5rem;
            }
        }

        /* Loading animation */
        .loading {
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { opacity: 0; }
            50% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="welcome-section">
            <div class="welcome-content">
                <h1 class="h2 mb-3">
                    <i class="fas fa-leaf me-3"></i>
                    Welcome to Agricultural Information System
                </h1>
                <p class="mb-0 fs-5 opacity-90">
                    Explore our comprehensive resources and agricultural data to support your farming journey
                </p>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card" style="--i: 1;">
                <div class="stat-icon">
                    <i class="fas fa-seedling"></i>
                </div>
                <div class="stat-title">Available Crops</div>
                <div class="stat-value" data-target="<?= htmlspecialchars($totalCrops) ?>">0</div>
                <p class="stat-description">Various crop varieties available</p>
            </div>
            <div class="stat-card" style="--i: 2;">
                <div class="stat-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-title">Farming Guides</div>
                <div class="stat-value" data-target="<?= htmlspecialchars($farmingGuides) ?>">0</div>
                <p class="stat-description">Comprehensive farming guides</p>
            </div>
            <div class="stat-card" style="--i: 3;">
                <div class="stat-icon">
                    <i class="fas fa-cloud-sun"></i>
                </div>
                <div class="stat-title">Weather Updates</div>
                <div class="stat-value"><?= htmlspecialchars($weatherUpdates) ?></div>
                <p class="stat-description">Real-time weather information</p>
            </div>
        </div>

        <div class="recent-activity">
            <div class="activity-header">
                <i class="fas fa-star"></i>
                <h2>Featured Information</h2>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mx-auto">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Crop Planning</h5>
                            <p class="card-text text-muted mb-4">
                                Learn about seasonal crop planning and rotation strategies for optimal yield.
                            </p>
                            <a href="#" class="btn btn-success">
                                <i class="fas fa-arrow-right me-2"></i>Read More
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mx-auto">
                                <i class="fas fa-cloud-sun"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Weather Forecast</h5>
                            <p class="card-text text-muted mb-4">
                                Check today's weather conditions and agricultural advisories for your area.
                            </p>
                            <a href="#" class="btn btn-success">
                                <i class="fas fa-eye me-2"></i>View Forecast
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mx-auto">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Market Prices</h5>
                            <p class="card-text text-muted mb-4">
                                Current market rates and price trends for agricultural products.
                            </p>
                            <a href="#" class="btn btn-success">
                                <i class="fas fa-chart-bar me-2"></i>Check Prices
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add Animate.css library if not already included
        if (!document.querySelector('link[href*="animate"]')) {
            const animateCSS = document.createElement('link');
            animateCSS.rel = 'stylesheet';
            animateCSS.href = 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css';
            document.head.appendChild(animateCSS);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Animated counters for statistics
            const statValues = document.querySelectorAll('.stat-value[data-target]');

            const observerOptions = {
                threshold: 0.5,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = entry.target;
                        const targetValue = parseInt(target.getAttribute('data-target'));
                        animateCounter(target, 0, targetValue, 2000);
                        observer.unobserve(target);
                    }
                });
            }, observerOptions);

            statValues.forEach(stat => observer.observe(stat));

            function animateCounter(element, start, end, duration) {
                const startTime = performance.now();
                const updateCounter = (currentTime) => {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);

                    // Easing function for smooth animation
                    const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                    const current = Math.floor(start + (end - start) * easeOutQuart);

                    element.textContent = current;

                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    }
                };
                requestAnimationFrame(updateCounter);
            }

            // Add hover effects to feature cards
            const featureCards = document.querySelectorAll('.feature-card');
            featureCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('animate__animated', 'animate__fadeInUp');
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading animation to images if any
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                if (!img.complete) {
                    img.classList.add('loading');
                    img.addEventListener('load', () => {
                        img.classList.remove('loading');
                    });
                }
            });
        });
    </script>
</body>
</html>
