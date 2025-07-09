<x-layout>
    <x-header />
    <x-hero>
        <div class="container">
            <h1>{{ $survey->title }}</h1>
            <p>{{ $survey->description }}</p>
        
            <form action="{{ route('surveys.submit', $survey) }}" method="POST">
                @csrf
        
                @foreach ($survey->questions as $question)
                    <div class="mb-3">
                        <label class="form-label">{{ $question->question }}</label>
                        @if ($question->type == 'scala')
                            <select name="answers[{{ $question->id }}]" class="form-select" required>
                                <option value="">Select...</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        @else
                            <textarea name="answers[{{ $question->id }}]" class="form-control" required></textarea>
                        @endif
                    </div>
                @endforeach
        
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </x-hero>
</x-layout>