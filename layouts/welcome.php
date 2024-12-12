<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Poliklinik BK</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #2c2c2c, #1b1b1b);
            color: #fff;
        }

        .navbar {
            background: #333;
            padding: 20px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 600;
            color: #ffa500;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease-in-out;
        }

        .navbar-brand:hover {
            transform: scale(1.1);
        }

        .navbar-links .nav-link {
            color: #fff;
            font-weight: 500;
            margin-left: 20px;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        .navbar-links .nav-link:hover {
            color: #ffa500;
        }

        .features {
            padding: 80px 20px;
            background: #1b1b1b;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-item {
            margin-bottom: 50px;
            padding: 20px;
            border: 2px solid #444;
            border-radius: 15px;
            text-align: center;
            background: #2c2c2c;
            animation: fadeIn 1s ease-in-out forwards;
        }

        .feature-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #ffa500;
        }

        .feature-link {
            display: inline-block;
            margin-top: 10px;
            padding: 12px 25px;
            border-radius: 30px;
            background: #ffa500;
            color: #1b1b1b;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(255, 165, 0, 0.3);
        }

        .feature-link:hover {
            background: #e69500;
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(255, 165, 0, 0.5);
        }

        .footer {
            padding: 20px 0;
            background: #333;
            text-align: center;
            font-size: 14px;
            color: #aaa;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .navbar .container {
                flex-direction: column;
                text-align: center;
            }

            .navbar-links {
                margin-top: 10px;
            }

            .features {
                padding: 40px 10px;
            }

            .feature-item {
                margin-bottom: 30px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">Poliklinik Bimbingan Karier</a>
            <?php if ($muncul) : ?>
                <div class="navbar-links">
                    <a class="nav-link" href="http://<?= $_SERVER['HTTP_HOST'] ?>/poliklinik/pages/<?= $arah ?>">Dashboard</a>
                </div>
            <?php endif ?>
        </div>
    </nav>

    <?php if (!$muncul) : ?>
        <section class="features" id="features">
            <div class="container">
                <div class="feature-item">
                    <h2 class="feature-title">Login Sebagai Dokter</h2>
                    <p>Akses login dokter, Silahkan login sebagai dokter</p>
                    <a class="feature-link" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk_poliklinik/pages/auth/login.php">
                        Klik untuk login <i class="icon-arrow-right"></i>
                    </a>
                </div>
                <div class="feature-item">
                    <h2 class="feature-title">Login Sebagai Pasien</h2>
                    <p>Akses login Pasien, Silahkan login sebagai Pasien</p>
                    <a class="feature-link" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk_poliklinik/pages/auth/login-pasien.php">
                        Klik untuk login <i class="icon-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>
    <?php endif ?>

    <footer class="footer">
        <div class="container">
            <p>&copy; Poliklinik by Danang Prasetya</p>
        </div>
    </footer>
</body>

</html>
