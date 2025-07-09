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
                @if (session('success'))
                    <div class="alert alert-success" data-aos="fade-up" data-aos-delay="100">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" data-aos="fade-up" data-aos-delay="100">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="text-center">
                    @if (!$todayAttendance)
                        <form action="{{ route('attendance.clock-in') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-custom" data-aos="fade-up" data-aos-delay="100">Clock In</button>
                        </form>
                    @elseif($todayAttendance && !$todayAttendance->clock_out)
                        <form action="{{ route('attendance.clock-out') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger" data-aos="fade-up" data-aos-delay="100">Clock Out</button>
                        </form>
                    @else
                        <p data-aos="fade-up" data-aos-delay="100">You have already clocked in and out today.</p>
                    @endif
                </div>
            </div>
        </main>
    </x-hero>

</x-layout>
