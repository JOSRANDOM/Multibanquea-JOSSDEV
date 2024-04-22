<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MockChars extends Component
{
    public $words_min;
    public $words_max;
    public $chars_min;
    public $chars_max;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(int $wordsMin = 1, int $wordsMax = 5, int $charsMin = 4, int $charsMax = 10)
    {
        $this->words_min = $wordsMin;
        $this->words_max = $wordsMax;
        $this->chars_min = $charsMin;
        $this->chars_max = $charsMax;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.mock-chars');
    }
}
