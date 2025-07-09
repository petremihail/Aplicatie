<x-layout>
    <x-slot name="head">
        <style>
        .btn-custom{
            background-color: #ff4500;
        }
        </style>
    </x-slot>
    
    <x-header />

    <x-hero>
        <main class="main">


            <div class="container ">
                <h2 data-aos="fade-up" data-aos-delay="100" style="text-align: center; margin-bottom: 30px;">Attendance</h2>

                <div class="text-center">
                            <button type="submit" class="btn btn-custom" data-aos="fade-up" data-aos-delay="100">Clock In</button>
                            <button type="submit" class="btn btn-danger" data-aos="fade-up" data-aos-delay="100">Clock Out</button>
                        <p data-aos="fade-up" data-aos-delay="100">You have already clocked in and out today.</p>
                </div>
            </div>
        </main>
    </x-hero>

</x-layout>
