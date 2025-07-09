<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - Dewi Bootstrap Template</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    {{ $head ?? '' }}
    <!-- =======================================================
  * Template Name: Dewi
  * Template URL: https://bootstrapmade.com/dewi-free-multi-purpose-html-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
    <style>
        /* Chat Container */
#chat-messages {
    max-height: 300px;
    overflow-y: auto; 
    color: white;
}

/* User Message Styles */
#chat-messages .user {
    text-align: right; /* Align user messages to the right */
}

#chat-messages .user .message {
    background-color: #ff4500; /* User message background */
    color: white; /* User message text color */
    border-radius: 15px;
    padding: 10px;
    margin: 5px 0; /* Add margin for separation */
}

/* Bot Message Styles */
#chat-messages .bot {
    text-align: left; /* Align bot messages to the left */
}

#chat-messages .bot .message {
    background-color: #f5f5f5; /* Bot message background */
    color: #333; /* Bot message text color */
    border-radius: 15px;
    padding: 10px;
    margin: 5px 0; /* Add margin for separation */
}

/* Styling for the message bubbles */
#chat-messages .message {
    max-width: 70%; /* Limit the width of the message */
    word-wrap: break-word;
    display: inline-block;
    line-height: 1.5;
}

.input_container{
  padding-bottom: 20px;
}
/* Input field and Send button */
#chat-input {
    border: 1px solid #ff4500; /* Border color for input */
    color: #ff4500; /* Text color */
    background-color: #fff0e0; /* Background color */
    focus:ring: 2px solid #ff4500; /* Focus ring color */
    margin-bottom: 10px; /* Space below the input */
}

button {
    background-color: #ff4500; /* Button background color */
    color: white; /* Button text color */
    border-radius: 5px;
}

/* Loading Dots */
.loading-dots .dot {
    background-color: #ff4500; /* Color of loading dots */
}

/* .input_message{
  background: rgba(0, 136, 255, 0.75);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
  border-radius: 15px;

}

.response_message{
  background: rgba(0, 21, 255, 0.75);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
  border-radius: 15px;
  
} */
.input_message {
    background: rgba(0, 136, 255, 0.75);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    border-radius: 15px;
    display: inline-block; /* Ensures the background is only as wide as the text */
    max-width: 70%; /* Limit the width */
}

/* Response message background */
.response_message {
    background: rgba(0, 21, 255, 0.75);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    border-radius: 15px;
    display: inline-block; /* Ensures the background is only as wide as the text */
    max-width: 70%; /* Limit the width */
}


        /* Chatbot Icon */
        .chatbot-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #ff4500;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        /* Chatbot Modal */
        .chatbot-modal {
            position: fixed;
            bottom: 80px;
            /* Adjusted to be above the icon */
            right: 20px;
            width: 350px;
            height: 400px;
            background-color: #ff44004e;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            z-index: 1001;
            /* Higher than the icon */
            display: none;
            /* Hidden by default */
            overflow: hidden;
        }

        .chatbot-modal.show {
            display: block;
            /* Show when 'show' class is added */
        }

        /* Loading Dots */
        .loading-dots {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 30px;
        }

        .dot {
            width: 8px;
            height: 8px;
            margin: 0 4px;
            background-color: #999;
            border-radius: 50%;
            animation: pulse 1.5s infinite ease-in-out;
        }

        .dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes pulse {
            0% {
                opacity: 0.4;
                transform: scale(0.75);
            }

            20% {
                opacity: 1;
                transform: scale(1);
            }

            40% {
                opacity: 0.4;
                transform: scale(0.75);
            }

            60%,
            100% {
                opacity: 0.4;
                transform: scale(0.75);
            }
        }
    </style>
</head>

<body class="index-page">

    {{ $slot }}
    @auth
    <!-- Chatbot Icon -->
    <div class="chatbot-icon" onclick="toggleChatbot()">
        <i class="fas fa-comment"></i>
    </div>

    <!-- Chatbot Modal -->
    <div class="chatbot-modal" id="chatbotModal">
        <x-chatbot />
    </div>

    @endauth
    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.j') }}s"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        function toggleChatbot() {
            const modal = document.getElementById('chatbotModal');
            modal.classList.toggle('show');
        }
    </script>
</body>

</html>
