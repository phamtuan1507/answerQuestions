@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">{{ $question->question_text }}</h1>

    @if(session('status'))
        <div class="p-4 mb-4 {{ session('status') == 'Đúng!' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 mb-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('quiz.submit', $question->id) }}">
        @csrf
        @if($question->type == 'multiple_choice')
            @foreach($question->answers as $answer)
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="answer" value="{{ $answer->id }}" class="form-radio" required>
                        <span class="ml-2">{{ $answer->answer_text }}</span>
                    </label>
                </div>
            @endforeach
        @elseif($question->type == 'true_false')
            <div class="mb-2">
                <label class="inline-flex items-center">
                    <input type="radio" name="answer" value="true" class="form-radio" required>
                    <span class="ml-2">Đúng</span>
                </label>
            </div>
            <div class="mb-2">
                <label class="inline-flex items-center">
                    <input type="radio" name="answer" value="false" class="form-radio" required>
                    <span class="ml-2">Sai</span>
                </label>
            </div>
        @endif
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-4">Submit</button>
    </form>
@endsection