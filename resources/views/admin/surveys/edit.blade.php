<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Survey</h1>
            <a href="{{ route('admin.surveys.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left fa-sm"></i> Back to Surveys
            </a>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Survey Information</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.surveys.update', $survey->id) }}" id="surveyForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Survey Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $survey->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $survey->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Questions</h5>
                    
                    <div id="questions-container">
                        @if($survey->questions->isEmpty())
                            <div class="alert alert-info">
                                Click "Add Question" below to start building your survey.
                            </div>
                        @else
                            @foreach($survey->questions as $index => $question)
                                <div class="card mb-3 question-card">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 question-number">Question #{{ $index + 1 }}</h6>
                                        <button type="button" class="btn btn-sm btn-danger remove-question">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Question Text</label>
                                            <input type="text" class="form-control question-text" name="questions[{{ $index }}][question]" value="{{ $question->question }}" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Question Type</label>
                                            <select class="form-select question-type" name="questions[{{ $index }}][type]" required>
                                                <option value="text" {{ $question->type === 'text' ? 'selected' : '' }}>Text Answer</option>
                                                <option value="scala" {{ $question->type === 'scala' ? 'selected' : '' }}>Rating Scale (1-5)</option>
                                                <option value="multiple_choice" {{ $question->type === 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                            </select>
                                        </div>
                                        
                                        <div class="options-container {{ $question->type !== 'multiple_choice' ? 'd-none' : '' }}">
                                            <div class="mb-3">
                                                <label class="form-label">Options</label>
                                                <div class="options-list">
                                                    @if($question->type === 'multiple_choice' && $question->options)
                                                        @php $options = json_decode($question->options, true) ?? []; @endphp
                                                        @foreach($options as $option)
                                                            <div class="input-group mb-2">
                                                                <input type="text" class="form-control" name="questions[{{ $index }}][options][]" value="{{ $option }}" placeholder="Option">
                                                                <button type="button" class="btn btn-outline-danger remove-option">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="input-group mb-2">
                                                            <input type="text" class="form-control" name="questions[{{ $index }}][options][]" placeholder="Option 1">
                                                            <button type="button" class="btn btn-outline-danger remove-option">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary mt-2 add-option">
                                                    <i class="fas fa-plus"></i> Add Option
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-success" id="add-question">
                            <i class="fas fa-plus fa-sm"></i> Add Question
                        </button>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary me-md-2" id="reset-form">Reset</button>
                        <button type="submit" class="btn btn-primary">Update Survey</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Question Template -->
    <template id="question-template">
        <div class="card mb-3 question-card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="m-0 question-number">Question #1</h6>
                <button type="button" class="btn btn-sm btn-danger remove-question">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Question Text</label>
                    <input type="text" class="form-control question-text" name="questions[0][question]" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Question Type</label>
                    <select class="form-select question-type" name="questions[0][type]" required>
                        <option value="text">Text Answer</option>
                        <option value="scala">Rating Scale (1-5)</option>
                        <option value="multiple_choice">Multiple Choice</option>
                    </select>
                </div>
                
                <div class="options-container d-none">
                    <div class="mb-3">
                        <label class="form-label">Options</label>
                        <div class="options-list">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="questions[0][options][]" placeholder="Option 1">
                                <button type="button" class="btn btn-outline-danger remove-option">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2 add-option">
                            <i class="fas fa-plus"></i> Add Option
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionsContainer = document.getElementById('questions-container');
            const addQuestionBtn = document.getElementById('add-question');
            const questionTemplate = document.getElementById('question-template');
            const resetFormBtn = document.getElementById('reset-form');
            const surveyForm = document.getElementById('surveyForm');
            
            let questionCount = {{ $survey->questions->count() }};
            
            // Initialize existing questions
            initializeExistingQuestions();
            
            // Add question
            addQuestionBtn.addEventListener('click', function() {
                // Clear initial info message if it exists
                if (questionsContainer.querySelector('.alert')) {
                    questionsContainer.innerHTML = '';
                }
                
                addQuestion();
            });
            
            // Reset form
            resetFormBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to reset the form? All your changes will be lost.')) {
                    window.location.reload();
                }
            });
            
            // Form submission validation
            surveyForm.addEventListener('submit', function(e) {
                if (questionCount === 0) {
                    e.preventDefault();
                    alert('Please add at least one question to the survey.');
                    return false;
                }
                
                // Validate multiple choice questions have at least 2 options
                const multipleChoiceSelects = document.querySelectorAll('.question-type');
                let valid = true;
                
                multipleChoiceSelects.forEach(select => {
                    if (select.value === 'multiple_choice') {
                        const optionsContainer = select.closest('.card-body').querySelector('.options-container');
                        const options = optionsContainer.querySelectorAll('input[type="text"]');
                        
                        if (options.length < 2) {
                            valid = false;
                            alert('Multiple choice questions must have at least 2 options.');
                        }
                    }
                });
                
                if (!valid) {
                    e.preventDefault();
                    return false;
                }
            });
            
            // Initialize existing questions
            function initializeExistingQuestions() {
                // Set up event listeners for existing questions
                document.querySelectorAll('.question-card').forEach((card, index) => {
                    const questionType = card.querySelector('.question-type');
                    const optionsContainer = card.querySelector('.options-container');
                    const removeQuestionBtn = card.querySelector('.remove-question');
                    const addOptionBtn = card.querySelector('.add-option');
                    
                    // Handle question type change
                    questionType.addEventListener('change', function() {
                        if (this.value === 'multiple_choice') {
                            optionsContainer.classList.remove('d-none');
                            // Ensure there are at least 2 options
                            const optionsList = optionsContainer.querySelector('.options-list');
                            if (optionsList.children.length < 2) {
                                addOption(optionsList, index);
                                addOption(optionsList, index);
                            }
                        } else {
                            optionsContainer.classList.add('d-none');
                        }
                    });
                    
                    // Handle remove question
                    removeQuestionBtn.addEventListener('click', function() {
                        card.remove();
                        questionCount--;
                        
                        // Update question numbers
                        updateQuestionNumbers();
                        
                        // Show info message if no questions
                        if (questionCount === 0) {
                            questionsContainer.innerHTML = '<div class="alert alert-info">Click "Add Question" below to start building your survey.</div>';
                        }
                    });
                    
                    // Handle add option
                    if (addOptionBtn) {
                        addOptionBtn.addEventListener('click', function() {
                            const optionsList = optionsContainer.querySelector('.options-list');
                            addOption(optionsList, index);
                        });
                    }
                    
                    // Handle remove option for existing options
                    const optionsList = optionsContainer.querySelector('.options-list');
                    if (optionsList) {
                        optionsList.querySelectorAll('.remove-option').forEach(btn => {
                            btn.addEventListener('click', function() {
                                const optionItem = this.closest('.input-group');
                                if (optionsList.children.length > 1) {
                                    optionItem.remove();
                                } else {
                                    alert('You must have at least one option.');
                                }
                            });
                        });
                    }
                });
            }
            
            // Function to add a new question
            function addQuestion() {
                const questionNode = document.importNode(questionTemplate.content, true);
                const questionCard = questionNode.querySelector('.question-card');
                const questionNumber = questionNode.querySelector('.question-number');
                const questionType = questionNode.querySelector('.question-type');
                const optionsContainer = questionNode.querySelector('.options-container');
                const removeQuestionBtn = questionNode.querySelector('.remove-question');
                const addOptionBtn = questionNode.querySelector('.add-option');
                
                // Update question number and input names
                questionCount++;
                questionNumber.textContent = `Question #${questionCount}`;
                
                // Update input names with correct index
                const inputs = questionNode.querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace(/questions\[\d+\]/, `questions[${questionCount - 1}]`);
                    }
                });
                
                // Handle question type change
                questionType.addEventListener('change', function() {
                    if (this.value === 'multiple_choice') {
                        optionsContainer.classList.remove('d-none');
                        // Ensure there are at least 2 options
                        const optionsList = optionsContainer.querySelector('.options-list');
                        if (optionsList.children.length < 2) {
                            addOption(optionsList, questionCount - 1);
                            addOption(optionsList, questionCount - 1);
                        }
                    } else {
                        optionsContainer.classList.add('d-none');
                    }
                });
                
                // Handle remove question
                removeQuestionBtn.addEventListener('click', function() {
                    questionCard.remove();
                    questionCount--;
                    
                    // Update question numbers
                    updateQuestionNumbers();
                    
                    // Show info message if no questions
                    if (questionCount === 0) {
                        questionsContainer.innerHTML = '<div class="alert alert-info">Click "Add Question" below to start building your survey.</div>';
                    }
                });
                
                // Handle add option
                addOptionBtn.addEventListener('click', function() {
                    const optionsList = optionsContainer.querySelector('.options-list');
                    addOption(optionsList, questionCount - 1);
                });
                
                // Handle remove option
                const optionsList = optionsContainer.querySelector('.options-list');
                const removeOptionBtn = optionsList.querySelector('.remove-option');
                removeOptionBtn.addEventListener('click', function() {
                    const optionItem = this.closest('.input-group');
                    if (optionsList.children.length > 1) {
                        optionItem.remove();
                    } else {
                        alert('You must have at least one option.');
                    }
                });
                
                questionsContainer.appendChild(questionNode);
            }
            
            // Function to add a new option to a multiple choice question
            function addOption(optionsList, questionIndex) {
                const optionCount = optionsList.children.length + 1;
                
                const optionGroup = document.createElement('div');
                optionGroup.className = 'input-group mb-2';
                
                const optionInput = document.createElement('input');
                optionInput.type = 'text';
                optionInput.className = 'form-control';
                optionInput.name = `questions[${questionIndex}][options][]`;
                optionInput.placeholder = `Option ${optionCount}`;
                
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-outline-danger remove-option';
                removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                
                removeBtn.addEventListener('click', function() {
                    if (optionsList.children.length > 1) {
                        optionGroup.remove();
                    } else {
                        alert('You must have at least one option.');
                    }
                });
                
                optionGroup.appendChild(optionInput);
                optionGroup.appendChild(removeBtn);
                optionsList.appendChild(optionGroup);
            }
            
            // Function to update question numbers and input names
            function updateQuestionNumbers() {
                const questionCards = questionsContainer.querySelectorAll('.question-card');
                questionCards.forEach((card, index) => {
                    card.querySelector('.question-number').textContent = `Question #${index + 1}`;
                    
                    // Update input names with new index
                    const cardInputs = card.querySelectorAll('input, select');
                    cardInputs.forEach(input => {
                        if (input.name) {
                            input.name = input.name.replace(/questions\[\d+\]/, `questions[${index}]`);
                        }
                    });
                });
            }
        });
    </script>
</x-admin-layout>
