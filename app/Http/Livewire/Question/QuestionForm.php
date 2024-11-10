<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class QuestionForm extends Component
{
    public Question $question;
    public array $options = [];
    public bool $editing = false;

    protected function rules()
    {
        return [
            'question.text' => 'required|string',
            'question.code_snippet' => 'nullable|string',
            'question.answer_explanation' => 'nullable|string',
            'question.more_info_link' => 'nullable|url',
            'options' => ['required', 'array'],
            'options.*.text' => 'required|string',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'options.*.text' => 'option text',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount(Question $question): void
    {
        $this->question = $question;
        
        if ($question->exists) {
            $this->editing = true;
            $this->options = $question->options()->get()
                ->map(fn($option) => [
                    'text' => $option->text,
                    'correct' => (bool)$option->correct
                ])
                ->toArray();
        } else {
            // Initialize with empty options
            $this->options = [
                ['text' => '', 'correct' => false],
                ['text' => '', 'correct' => false],
            ];
        }
    }

    public function save()
    {
        $this->validate();
        
        // Additional validation for correct answer
        $hasCorrectAnswer = collect($this->options)->contains('correct', true);
        if (!$hasCorrectAnswer) {
            $this->addError('options', 'At least one option must be marked as correct.');
            return;
        }

        $this->question->save();

        if ($this->editing) {
            $this->question->options()->delete();
        }

        foreach ($this->options as $option) {
            $this->question->options()->create([
                'text' => $option['text'],
                'correct' => $option['correct'] ?? false
            ]);
        }

        return redirect()->route('questions')->with('success', 'Question saved successfully');
    }

    public function addOption()
    {
        $this->options[] = ['text' => '', 'correct' => false];
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function render(): View
    {
        return view('livewire.question.question-form');
    }
}
