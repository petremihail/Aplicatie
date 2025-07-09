
<x-layout>
    <x-slot name="head">
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>Hero Image Only</title>

        <!-- Only the essential CSS files -->
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/vendor/aos/aos.css" rel="stylesheet">
        <link href="assets/css/main.css" rel="stylesheet">

        <style>
            /* Override styles to ensure only hero is shown */
            body {
                overflow: hidden;
                margin: 0;
                padding: 0;
            }

            .hero {
                height: 100vh;
                width: 100vw;
                position: relative;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            .hero img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                position: absolute;
                top: 0;
                left: 0;
            }

            #preloader {
                display: none;
                /* Hide preloader */
            }

            .scroll-top {
                display: none;
                /* Hide scroll top button */
            }
        </style>
        <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        
        :root {
            --primary-color: #5D5CDE;
            --primary-hover: #4A49B8;
        }

        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(93, 92, 222, 0.25);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(93, 92, 222, 0.25);
        }

        .input-group-text {
            background-color: #fff;
            border-right: none;
        }

        .form-control.is-invalid,
        .was-validated .form-control:invalid {
            background-image: none;
            padding-right: 0.75rem;
        }

        .form-control.is-valid,
        .was-validated .form-control:valid {
            background-image: none;
            padding-right: 0.75rem;
        }

        .password-toggle {
            cursor: pointer;
        }

        /* Dark mode styles */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #212529;
                color: #f8f9fa;
            }

            .card {
                background-color: #2c3034;
                color: #f8f9fa;
            }

            .input-group-text {
                background-color: #2c3034;
                color: #f8f9fa;
                border-color: #495057;
            }

            .form-control,
            .form-select {
                background-color: #2c3034;
                color: #f8f9fa;
                border-color: #495057;
            }

            .form-control::placeholder {
                color: #6c757d;
            }

            .form-control:focus,
            .form-select:focus {
                background-color: #2c3034;
                color: #f8f9fa;
            }

            .form-text {
                color: #adb5bd;
            }

            .text-muted {
                color: #adb5bd !important;
            }
        }
    </style>
    </x-slot>

    <main class="main">
        <x-hero >
            <x-login/>
        </x-hero>
    </main>


    <!-- Only the essential JS files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script>
    // Initialize AOS animation library when document is ready
    document.addEventListener('DOMContentLoaded', function() {
      AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        mirror: false
      });
    });
  </script>

</x-layout>
