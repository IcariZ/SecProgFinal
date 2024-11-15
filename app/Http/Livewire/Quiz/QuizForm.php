<?php

namespace App\Http\Livewire\Quiz;

use App\Models\Quiz;
use App\Models\Question;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;

class QuizForm extends Component
{
    public Quiz $quiz;
    public array $questions = [];
    public bool $editing = false;
    public array $listsForFields = [];
    public $status;

    protected function rules()
    {
        return [
            'quiz.title' => 'required|string',
            'quiz.slug' => 'string',
            'quiz.description' => 'nullable|string',
            'status' => 'required|in:published,public',
            'questions' => 'nullable|array',
        ];
    }

    public function mount(Quiz $quiz)
    {
        $this->quiz = $quiz;
        $this->initListsForFields();

        if ($this->quiz->exists) {
            $this->editing = true;
            $this->questions = $this->quiz->questions()->pluck('id')->toArray();
            $this->status = $this->quiz->published ? 'published' : ($this->quiz->public ? 'public' : null);
        } else {
            $this->quiz->published = false;
            $this->quiz->public = false;
            $this->status = 'published';
        }
    }

    public function updatedQuizTitle(): void
    {
        $this->quiz->slug = Str::slug($this->quiz->title);
    }

    public function save()
    {
        $this->validate();

        $this->quiz->published = $this->status === 'published';
        $this->quiz->public = $this->status === 'public';

        $this->quiz->save();
        $this->quiz->questions()->sync($this->questions);

        return to_route('quizzes');
    }

    protected function initListsForFields()
    {
        $this->listsForFields['questions'] = Question::pluck('text', 'id')->toArray();
    }

    public function render(): View
    {
        return view('livewire.quiz.quiz-form');
    }
}
