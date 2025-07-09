{{-- <x-layout>
    <x-slot name="head">
        <title>Add Course Content</title>
    </x-slot>
    <x-hero>
        <main>
        <div class="container">
                <h1>Add Content to {{ $course->name }}</h1>

                <form method="POST" action="{{ route('course_contents.store', $course->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <label>Title</label>
                    <input type="text" name="title" required><br>

                    <label>Type</label>
                    <select name="type">
                        <option value="pdf">PDF</option>
                        <option value="video">Video</option>
                    </select><br>

                    <label>Upload File</label>
                    <input type="file" name="file" required><br><br>

                    <button type="submit">Upload</button>
                </form>
            </div>
        </main>
    </x-hero>

</x-layout> --}}

<x-layout>
    <x-slot name="head">
        <title>Add Course Content</title>
        <style>
            body {
                margin: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #e0e7ff, #fce7f3);
            }

            .form-container {
                max-width: 600px;
                margin: 3rem auto;
                background-color: #fff;
                padding: 2rem;
                border-radius: 20px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            .form-container h1 {
                text-align: center;
                color: #6d28d9;
                margin-bottom: 2rem;
            }

            label {
                display: block;
                margin-bottom: 0.5rem;
                font-weight: bold;
                color: #374151;
            }

            input[type="text"],
            select,
            input[type="file"] {
                width: 100%;
                padding: 0.75rem;
                margin-bottom: 1.5rem;
                border: 1px solid #d1d5db;
                border-radius: 10px;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }

            input[type="text"]:focus,
            select:focus,
            input[type="file"]:focus {
                border-color: #8b5cf6;
                outline: none;
                box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
            }

            button[type="submit"] {
                background-color: #8b5cf6;
                color: #fff;
                padding: 0.75rem 2rem;
                border: none;
                border-radius: 10px;
                cursor: pointer;
                font-weight: bold;
                display: block;
                width: 100%;
                transition: background-color 0.2s ease, transform 0.2s ease;
            }

            button[type="submit"]:hover {
                background-color: #7c3aed;
                transform: scale(1.02);
            }

            @media (max-width: 640px) {
                .form-container {
                    margin: 1rem;
                    padding: 1.5rem;
                }
            }
        </style>
    </x-slot>
    
    <x-hero>
        <main>
            <div class="form-container container">
                <h1>Add Content to {{ $course->name }}</h1>
                {{-- Show Laravel validation errors --}}
                {{-- Show Laravel validation errors --}}
                @if ($errors->any())
                    <div style="color: red; margin-bottom: 1rem;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="uploadForm" method="POST" action="{{ route('course_contents.store', $course->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <label>Title</label>
                    <input type="text" name="title" required><br>

                    <label>Type</label>
                    <select name="type" required>
                        <option value="pdf">PDF</option>
                        <option value="video">Video</option>
                    </select><br>

                    <label>Upload File (max 20 MB)</label>
                    <input type="file" name="file" id="fileInput" required><br>
                    <p id="error-msg" style="color: red;"></p>

                    <br>
                    <button type="submit">Upload</button>
                </form>

                <script>
                    document.getElementById('uploadForm').addEventListener('submit', function(e) {
                        const fileInput = document.getElementById('fileInput');
                        const errorMsg = document.getElementById('error-msg');
                        const file = fileInput.files[0];

                        // 100 MB limit
                        const maxSize = 20 * 1024 * 1024;

                        if (file && file.size > maxSize) {
                            e.preventDefault();
                            errorMsg.textContent = "File size must be less than 20 MB.";
                        } else {
                            errorMsg.textContent = "";
                        }
                    });
                </script>
            </div>
        </main>
    </x-hero>
</x-layout>
