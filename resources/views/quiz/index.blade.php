@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Danh sách câu hỏi</h1>
    @foreach($questions as $question)
        <div class="bg-white shadow rounded-lg p-4 mb-4">
            <h5 class="text-lg">{{ $question->question_text }}</h5>
            <a href="{{ route('quiz.show', $question->id) }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Trả lời</a>
        </div>
    @endforeach
    {{ $questions->links() }}
@endsection