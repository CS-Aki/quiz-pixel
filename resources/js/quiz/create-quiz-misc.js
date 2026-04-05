let questionCount = 1;

function switchTab(tab) {
    const content = document.getElementById('tabContent');
    const settings = document.getElementById('tabSettings');
    const btnContent = document.getElementById('tabContentBtn');
    const btnSettings = document.getElementById('tabSettingsBtn');

    if (!content || !settings || !btnContent || !btnSettings) return;

    if (tab === 'content') {
        content.classList.remove('hidden');
        settings.classList.add('hidden');

        btnContent.classList.add('bg-[#2979FF]', 'text-white');
        btnContent.classList.remove('text-slate-500', 'hover:bg-gray-100');

        btnSettings.classList.remove('bg-[#2979FF]', 'text-white');
        btnSettings.classList.add('text-slate-500', 'hover:bg-gray-100');
    } else {
        content.classList.add('hidden');
        settings.classList.remove('hidden');

        btnSettings.classList.add('bg-[#2979FF]', 'text-white');
        btnSettings.classList.remove('text-slate-500', 'hover:bg-gray-100');

        btnContent.classList.remove('bg-[#2979FF]', 'text-white');
        btnContent.classList.add('text-slate-500', 'hover:bg-gray-100');
    }
}

function addQuestion() {
    questionCount++;

    const list = document.getElementById('questionsList');
    if (!list) return;

    const card = document.createElement('div');
    card.className = 'question-card bg-white rounded-2xl shadow-sm overflow-hidden';
    card.dataset.index = questionCount;

    card.innerHTML = `
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <span class="text-xs font-bold text-[#2979FF] uppercase tracking-widest">Question ${questionCount}</span>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-slate-400" viewBox="0 0 510 510"><g fill-opacity=".9"><path d="M255 0C114.75 0 0 114.75 0 255s114.75 255 255 255 255-114.75 255-255S395.25 0 255 0zm0 459c-112.2 0-204-91.8-204-204S142.8 51 255 51s204 91.8 204 204-91.8 204-204 204z"/><path d="M267.75 127.5H229.5v153l132.6 81.6 20.4-33.15-114.75-68.85z"/></g></svg>
                    <input
                        type="number"
                        placeholder="30"
                        min="5"
                        max="300"
                        class="w-14 text-xs border border-gray-200 rounded-lg px-2 py-1 outline-none focus:ring-2 focus:ring-[#2979FF] text-center"
                    />
                    <span>sec</span>
                </div>

                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-slate-400" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2zm1 14.93V18h-2v-1.07A4.002 4.002 0 0 1 8 13h2a2 2 0 1 0 2-2c-2.21 0-4-1.79-4-4a4.002 4.002 0 0 1 3-3.87V2h2v1.13A4.002 4.002 0 0 1 16 7h-2a2 2 0 1 0-2 2c2.21 0 4 1.79 4 4a4.002 4.002 0 0 1-3 3.93z"/></svg>
                    <input
                        type="number"
                        placeholder="10"
                        min="0"
                        class="w-14 text-xs border border-gray-200 rounded-lg px-2 py-1 outline-none focus:ring-2 focus:ring-[#2979FF] text-center"
                    />
                    <span>pts</span>
                </div>

                <button type="button" class="delete-question-btn text-slate-300 hover:text-red-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M9 3v1H4v2h1v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1V4h-5V3zm0 2h6v1H9zm-2 2h10v12H7zm2 2v8h2V9zm4 0v8h2V9z"/></svg>
                </button>
            </div>
        </div>

        <div class="px-6 py-5">
            <input
                type="text"
                placeholder="Type your question here..."
                class="w-full text-sm font-medium text-slate-800 placeholder-slate-300 outline-none border-b border-gray-100 focus:border-[#2979FF] pb-2 mb-5 transition"
            />

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 choices-container">
                ${['A', 'B', 'C', 'D'].map((l) => `
                    <div class="choice-item flex items-center gap-3 p-3 border-2 border-gray-100 rounded-xl hover:border-[#2979FF]/30 transition">
                        <button type="button" class="correct-btn w-6 h-6 rounded-full border-2 border-gray-300 flex-shrink-0 flex items-center justify-center transition hover:border-green-400"></button>
                        <input type="text" placeholder="Choice ${l}" class="flex-1 text-sm text-slate-700 placeholder-slate-300 outline-none bg-transparent" />
                    </div>
                `).join('')}
            </div>

            <p class="text-xs text-slate-400 mt-3">
                <span class="text-green-500 font-semibold">●</span>
                Click the circle next to the correct answer
            </p>
        </div>
    `;

    list.appendChild(card);
    renumberQuestions();
}

function deleteQuestion(btn) {
    const cards = document.querySelectorAll('.question-card');
    if (cards.length === 1) return;

    const card = btn.closest('.question-card');
    if (!card) return;

    card.remove();
    renumberQuestions();
}

function renumberQuestions() {
    const cards = document.querySelectorAll('.question-card');

    cards.forEach((card, i) => {
        const label = card.querySelector('span');
        if (label) {
            label.textContent = `Question ${i + 1}`;
        }

        card.dataset.index = i + 1;
    });

    questionCount = cards.length;
}

function setCorrect(btn) {
    const container = btn.closest('.choices-container');
    if (!container) return;

    container.querySelectorAll('.correct-btn').forEach((b) => {
        b.classList.remove('bg-green-500', 'border-green-500');
        b.innerHTML = '';

        const choiceItem = b.closest('.choice-item');
        if (choiceItem) {
            choiceItem.classList.remove('border-green-400', 'bg-green-50');
            choiceItem.classList.add('border-gray-100');
        }
    });

    btn.classList.add('bg-green-500', 'border-green-500');
    btn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 fill-white" viewBox="0 0 24 24">
            <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
        </svg>
    `;

    const choiceItem = btn.closest('.choice-item');
    if (choiceItem) {
        choiceItem.classList.add('border-green-400', 'bg-green-50');
        choiceItem.classList.remove('border-gray-100');
    }
}

function toggleSwitch(btn) {
    const isOn = btn.dataset.state === 'on';
    const dot = btn.querySelector('span');
    if (!dot) return;

    if (isOn) {
        btn.dataset.state = 'off';
        btn.classList.remove('bg-[#2979FF]');
        btn.classList.add('bg-gray-200');
        dot.classList.remove('left-5');
        dot.classList.add('left-1');
    } else {
        btn.dataset.state = 'on';
        btn.classList.add('bg-[#2979FF]');
        btn.classList.remove('bg-gray-200');
        dot.classList.add('left-5');
        dot.classList.remove('left-1');
    }
}

$(document).ready(function () {
    $(document).on('click', '.correct-btn', function () {
        setCorrect(this);
    });

    $(document).on('click', '.delete-question-btn', function () {
        deleteQuestion(this);
    });

    $(document).on('click', '#addQuestionBtn', function () {
        addQuestion();
    });

    $(document).on('click', '#tabContentBtn', function () {
        switchTab('content');
    });

    $(document).on('click', '#tabSettingsBtn', function () {
        switchTab('settings');
    });

    $(document).on('click', '.toggle-switch', function () {
        toggleSwitch(this);
    });
});