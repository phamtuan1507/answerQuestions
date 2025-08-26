<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $questions = Question::paginate(10);
        return view('quiz.index', compact('questions'));
    }

    public function show($id)
    {
        $question = Question::with('answers')->findOrFail($id);
        return view('quiz.show', compact('question'));
    }

    public function submit(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $rules = ['answer' => 'required'];
        if ($question->type === 'multiple_choice') {
            $rules['answer'] = ['required', 'exists:answers,id,question_id,' . $id];
        } elseif ($question->type === 'true_false') {
            $rules['answer'] = ['required', 'in:true,false'];
        }

        $messages = [
            'answer.required' => 'Vui lòng chọn một đáp án.',
            'answer.exists' => 'Đáp án không hợp lệ.',
            'answer.in' => 'Đáp án phải là Đúng hoặc Sai.',
        ];

        $request->validate($rules, $messages);

        $selected = $request->input('answer');
        $isCorrect = false;

        if ($question->type === 'multiple_choice') {
            $isCorrect = $question->answers()->where('id', $selected)->first()->is_correct;
        } elseif ($question->type === 'true_false') {
            $isCorrect = $selected === $question->correct_answer;
        }

        if (Auth::check()) {
            UserAnswer::create([
                'user_id' => Auth::id(),
                'question_id' => $id,
                'selected_answer' => $selected,
                'is_correct' => $isCorrect,
            ]);
        }

        return redirect()->route('quiz.show', $id)->with('status', $isCorrect ? 'Đúng!' : 'Sai! Giải thích: ' . $question->explanation);
    }
}
