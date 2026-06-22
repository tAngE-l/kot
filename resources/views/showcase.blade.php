<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>A/B Service - Классическая версия</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f3f4f6; color: #111827; }
        .wrap { max-width: 1100px; margin: 0 auto; padding: 20px; }
        .top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
        .logo { font-size: 24px; font-weight: 700; }
        .nav { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn { border: 1px solid #2563eb; background: #2563eb; color: white; text-decoration: none; padding: 8px 12px; border-radius: 8px; font-size: 14px; cursor: pointer; display: inline-block; }
        .btn.secondary { background: white; color: #2563eb; }
        .btn.active-tab { background: #2563eb; color: white; }
        .grid { display: grid; gap: 12px; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); }
        .card { background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px; }
        .card h3 { margin: 0 0 8px 0; font-size: 18px; }
        .muted { color: #6b7280; font-size: 13px; }
        .field { margin-bottom: 8px; }
        .field label { display: block; font-size: 13px; margin-bottom: 4px; }
        .field input, .field textarea, .field select { width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; }
        
       
        .chart-container { background: #fff; padding: 14px; border-radius: 10px; border: 1px solid #e5e7eb; }
        .bar-row { display: flex; align-items: center; margin-bottom: 10px; font-size: 13px; }
        .bar-label { width: 100px; font-weight: bold; }
        .bar-track { flex-grow: 1; background: #e5e7eb; height: 24px; border-radius: 6px; overflow: hidden; margin: 0 10px; }
        .bar-fill { background: #2563eb; height: 100%; text-align: right; padding-right: 8px; color: white; font-weight: bold; line-height: 24px; font-size: 11px; }
        .bar-fill.b-variant { background: #60a5fa; }
        
        .heat { display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; }
        .heat div { text-align: center; border-radius: 8px; padding: 8px; color: white; font-size: 13px; font-weight: bold; }
        .matrix-table { width: 100%; border-collapse: collapse; margin-top: 8px; font-size: 13px; }
        .matrix-table th, .matrix-table td { border: 1px solid #e5e7eb; padding: 6px; text-align: center; }
        .matrix-table th { background: #f9fafb; }
    </style>
</head>
<body>
<div class="wrap">
    
    
    <div class="top">
        <div class="logo">A/B Service</div>
        <div class="nav">
            <a href="?tab=home" class="btn secondary {{ $currentTab === 'home' ? 'active-tab' : '' }}">Главная</a>
            <a href="?tab=builder&variant_id={{ $selectedVariantId }}" class="btn secondary {{ $currentTab === 'builder' ? 'active-tab' : '' }}">Конструктор</a>
            <a href="?tab=respond" class="btn secondary {{ $currentTab === 'respond' ? 'active-tab' : '' }}">Прохождение</a>
            <a href="?tab=analytics" class="btn secondary {{ $currentTab === 'analytics' ? 'active-tab' : '' }}">Аналитика</a>
            <a href="?tab=exports" class="btn secondary {{ $currentTab === 'exports' ? 'active-tab' : '' }}">Экспорт</a>
        </div>
    </div>

    
    @if($currentTab === 'home')
    <div class="grid">
        <div class="card">
            <h3>Опрос #{{ $survey->id }}: {{ $survey->title }}</h3>
            <p class="muted">Статус: опубликован | Варианты: A/B | Ответов: {{ $totalAnswers }}</p>
            <div style="margin-top:10px;">
                <a class="btn" href="?tab=builder">Открыть конструктор</a>
                <a class="btn secondary" href="?tab=analytics">Открыть аналитику</a>
            </div>
        </div>

    </div>
    @endif

  
    @if($currentTab === 'builder')
    <div class="grid">
        <div class="card">
            <h3>Конструктор опроса</h3>
            <form action="{{ route('survey.update_title') }}" method="POST">
                @csrf
                <div class="field">
                    <label>Название опроса</label>
                    <input type="text" name="title" value="{{ $survey->title }}">
                </div>
                <button type="submit" class="btn secondary" style="padding: 4px 8px; font-size: 12px;">Обновить название</button>
            </form>
            
            <div class="field" style="margin-top: 15px;">
                <label>Выберите редактируемый A/B Вариант</label>
                <select onchange="window.location.href='?tab=builder&variant_id=' + this.value">
                    @foreach($variants as $v)
                        <option value="{{ $v->id }}" {{ $selectedVariantId == $v->id ? 'selected' : '' }}>{{ $v->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @foreach($questions as $idx => $q)
        <div class="card" style="position: relative;">
            <h3>Вопрос {{ $idx + 1 }} ({{ $q->type }})</h3>
            <div class="field"><label>Текст</label><input value="{{ $q->question_text }}" readonly style="background:#f3f4f6;"></div>
            @if($q->options)
                <div class="field"><label>Варианты (из БД)</label><input value="{{ $q->options }}" readonly style="background:#f3f4f6;"></div>
            @endif
            <form action="{{ route('survey.delete_question', $q->id) }}" method="POST">
                @csrf
                <input type="hidden" name="variant_id" value="{{ $selectedVariantId }}">
                <button type="submit" style="position:absolute; top:14px; right:14px; border:none; background:none; color:#ef4444; cursor:pointer; font-size:12px;">Удалить</button>
            </form>
        </div>
        @endforeach

        <div class="card" style="border: 2px dashed #2563eb;">
            <h3>+ Добавить вопрос</h3>
            <form action="{{ route('survey.add_question') }}" method="POST">
                @csrf
                <input type="hidden" name="variant_id" value="{{ $selectedVariantId }}">
                <div class="field"><label>Текст вопроса</label><input type="text" name="question_text" required></div>
                <div class="field">
                    <label>Тип вопроса</label>
                    <select name="type">
                        <option value="radio">Одиночный выбор </option>
                        <option value="checkbox">Множественный выбор </option>
                        <option value="text">Текстовый ответ </option>
                        <option value="scale">Шкала </option>
                        <option value="matrix">Матрица</option>
                    </select>
                </div>
                <div class="field"><label>Опции (через запятую)</label><input type="text" name="options" placeholder="Опция 1, Опция 2"></div>
                <button type="submit" class="btn" style="width:100%; margin-top:4px;">Сохранить</button>
            </form>
        </div>
    </div>
    @endif
  
    @if($currentTab === 'respond')
    <div class="grid">
        <div class="card">
            <h3>Прохождение опроса</h3>
            @if($session)
                <p class="muted">Ваша текущая А/Б когорта: <b>{{ $currentVariantName }}</b></p>
                <form action="{{ route('survey.save_answers') }}" method="POST">
                    @csrf
                    <input type="hidden" name="session_id" value="{{ $session->id }}">
                    
                    @foreach($respondQuestions as $q)
                        <div class="field" style="margin-top:14px; border-bottom:1px solid #e5e7eb; padding-bottom:8px;">
                            <label style="font-weight:bold;">{{ $q->question_text }}</label>
                            
                            @if($q->type === 'radio')
                                @foreach(explode(',', $q->options) as $o)
                                    <label style="display:block; margin-top:4px;"><input type="radio" name="answers[{{ $q->id }}]" value="{{ trim($o) }}" required> {{ trim($o) }}</label>
                                @endforeach
                            
                            @elseif($q->type === 'checkbox')
                                @foreach(explode(',', $q->options) as $o)
                                    <label style="display:block; margin-top:4px;"><input type="checkbox" name="answers[{{ $q->id }}][]" value="{{ trim($o) }}"> {{ trim($o) }}</label>
                                @endforeach
                            
                            @elseif($q->type === 'text')
                                <textarea rows="2" name="answers[{{ $q->id }}]" placeholder="Введите ответ..." required style="margin-top:4px;"></textarea>
                            
                            @elseif($q->type === 'scale')
                                <select name="answers[{{ $q->id }}]" required style="margin-top:4px;">
                                    <option value="">Выберите оценку...</option>
                                    @for($i=1; $i<=10; $i++) <option value="{{ $i }}">{{ $i }}</option> @endfor
                                </select>
                            
                            @elseif($q->type === 'matrix')
                                <table class="matrix-table">
                                    <thead>
                                        <tr>
                                            <th>Ответ</th>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(explode(',', $q->options) as $row)
                                            <tr>
                                                <td style="text-align:left; font-weight:bold;">{{ trim($row) }}</td>
                                                <td><input type="radio" name="answers[{{ $q->id }}][{{ trim($row) }}]" value="1" required></td>
                                                <td><input type="radio" name="answers[{{ $q->id }}][{{ trim($row) }}]" value="2"></td>
                                                <td><input type="radio" name="answers[{{ $q->id }}][{{ trim($row) }}]" value="3"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    @endforeach
                    <button type="submit" class="btn" style="margin-top:12px; width:100%;">Завершить опрос</button>
                </form>
            @else
                <p class="muted" style="margin-bottom:12px;">У вас нет запущенных тестов.</p>
                <form action="{{ route('survey.start_session') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn">Начать опрос (Случайный A/B выбор)</button>
                </form>
            @endif
        </div>
    </div>
    @endif

 
    @if($currentTab === 'analytics')
    <div class="grid">
        <div class="chart-container">
            <h3>Аналитика опроса </h3>
            <p class="muted">Всего ответов: {{ $totalAnswers }} | Распределение по А/Б группам:</p>
            
            <div class="bar-row" style="margin-top:15px;">
                <div class="bar-label">Вариант А</div>
                <div class="bar-track"><div class="bar-fill" style="width: 55%;">{{ $countA }} чел.</div></div>
            </div>
            <div class="bar-row">
                <div class="bar-label">Вариант Б</div>
                <div class="bar-track"><div class="bar-fill b-variant" style="width: 45%;">{{ $countB }} чел.</div></div>
            </div>
        </div>
        <div class="card">
            <h3>Тепловая карта матрицы</h3>
            <p class="muted">Сводные данные по выборам респондентов</p>
            <div class="heat" style="margin-top:15px;">
                <div style="background:#1d4ed8">A1: 42</div>
                <div style="background:#2563eb">A2: 35</div>
                <div style="background:#3b82f6">B1: 28</div>
                <div style="background:#60a5fa">B2: 19</div>
            </div>
        </div>
    </div>
    @endif

    
    @if($currentTab === 'exports')
    <div class="grid">
        <div class="card">
            <h3>Экспорт результатов</h3>
            <p class="muted">Выгрузка сырых данных из таблиц phpMyAdmin</p>
            <div style="display:flex; gap:8px; margin-top:12px;">
                <a class="btn secondary" href="#">Экспорт CSV</a>
                <a class="btn secondary" href="#">Экспорт Excel</a>
                <a class="btn secondary" href="#">Экспорт PDF</a>
            </div>
        </div>
    </div>
    @endif

</div>
</body>
</html>
