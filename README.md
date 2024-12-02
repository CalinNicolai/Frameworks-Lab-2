# Отчёт по лабораторной работе №4: Работа с формами и валидацией в Laravel

---

### Цель работы

Целью данной лабораторной работы было освоение работы с формами в Laravel, создание и обработка данных с использованием валидации, настройка безопасности форм, а также добавление функционала для редактирования задач в веб-приложении To-Do App.

---

### Условие

В рамках работы я реализовал следующие задачи:

1. Создание формы для добавления новой задачи с использованием Blade-шаблонов.
2. Реализация серверной валидации данных и отображение ошибок.
3. Настройка маршрутов и методов контроллера для обработки форм.
4. Создание и использование собственных классов запросов (Request).
5. Добавление флеш-сообщений для подтверждения успешного выполнения операций.
6. Обеспечение безопасности форм от CSRF-атак.
7. Добавление функционала редактирования задач.

---

### Выполнение работы

#### №1. Подготовка к работе

Я продолжил разработку приложения To-Do App. Убедился, что проект настроен, а подключение к базе данных указано в файле `.env`. Пример настроек:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_app
DB_USERNAME=root
DB_PASSWORD=пароль
```

---

#### №2. Создание формы

1. **Создал форму для добавления новой задачи:**

    - Форма содержит поля: Название, Описание, Дата выполнения, Категория.
    - Поле "Категория" реализовано как выпадающий список, данные для которого загружаются из таблицы `categories`.

   Пример формы в Blade-шаблоне (`resources/views/tasks/create.blade.php`):

   ```html
   <form action="{{ route('tasks.store') }}" method="POST">
       @csrf
       <div>
           <label for="title">Название</label>
           <input type="text" name="title" id="title" value="{{ old('title') }}" required>
           @error('title')
               <div>{{ $message }}</div>
           @enderror
       </div>
       <div>
           <label for="description">Описание</label>
           <textarea name="description" id="description">{{ old('description') }}</textarea>
           @error('description')
               <div>{{ $message }}</div>
           @enderror
       </div>
       <div>
           <label for="due_date">Дата выполнения</label>
           <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required>
           @error('due_date')
               <div>{{ $message }}</div>
           @enderror
       </div>
       <div>
           <label for="category_id">Категория</label>
           <select name="category_id" id="category_id">
               @foreach($categories as $category)
                   <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                       {{ $category->name }}
                   </option>
               @endforeach
           </select>
           @error('category_id')
               <div>{{ $message }}</div>
           @enderror
       </div>
       <button type="submit">Сохранить</button>
   </form>
   ```

---

#### №3. Валидация данных на стороне сервера

1. **Реализовал валидацию данных в методе `store` контроллера `TaskController`:**

   Пример правил валидации:

   ```php
   public function store(Request $request)
   {
       $validated = $request->validate([
           'title' => 'required|string|min:3',
           'description' => 'nullable|string|max:500',
           'due_date' => 'required|date|after_or_equal:today',
           'category_id' => 'required|exists:categories,id',
       ]);

       Task::create($validated);

       return redirect()->route('tasks.index')->with('success', 'Задача успешно добавлена!');
   }
   ```

2. Обработал ошибки валидации в представлении. Ошибки выводятся рядом с соответствующими полями.

---

#### №4. Создание собственного класса запроса (Request)

1. **Создал класс запроса `CreateTaskRequest`:**

   ```bash
   php artisan make:request CreateTaskRequest
   ```

2. **В классе `CreateTaskRequest` реализовал правила валидации:**

   ```php
   public function rules(): array
   {
       return [
           'title' => 'required|string|min:3',
           'description' => 'nullable|string|max:500',
           'due_date' => 'required|date|after_or_equal:today',
           'category_id' => 'required|exists:categories,id',
       ];
   }
   ```

3. Обновил метод `store` для использования `CreateTaskRequest`:

   ```php
   public function store(CreateTaskRequest $request)
   {
       Task::create($request->validated());
       return redirect()->route('tasks.index')->with('success', 'Задача успешно добавлена!');
   }
   ```

---

#### №5. Добавление флеш-сообщений

1. **Добавил флеш-сообщение в метод `store`:**

   ```php
   return redirect()->route('tasks.index')->with('success', 'Задача успешно добавлена!');
   ```

2. **Отобразил сообщение в представлении:**

   ```blade
   @if(session('success'))
       <div class="alert alert-success">
           {{ session('success') }}
       </div>
   @endif
   ```

---

#### №6. Защита от CSRF

1. Добавил директиву `@csrf` в форму для защиты от CSRF-атак.

2. Убедился, что форма отправляет данные методом POST.

---

#### №7. Обновление задачи

1. **Добавил возможность редактирования задачи:**

    - Создал форму редактирования (`resources/views/tasks/edit.blade.php`).
    - Создал маршрут `GET /tasks/{task}/edit` и метод `edit` в `TaskController`:

      ```php
      public function edit(Task $task)
      {
          $categories = Category::all();
          return view('tasks.edit', compact('task', 'categories'));
      }
      ```

    - Создал маршрут `PUT /tasks/{task}` и метод `update`:

      ```php
      public function update(UpdateTaskRequest $request, Task $task)
      {
          $task->update($request->validated());
          return redirect()->route('tasks.index')->with('success', 'Задача успешно обновлена!');
      }
      ```

2. **Создал класс запроса `UpdateTaskRequest`:**

   ```php
   php artisan make:request UpdateTaskRequest
   ```

   Правила валидации аналогичны правилам в `CreateTaskRequest`.

---

### Дополнительное задание

1. **Создал кастомное правило валидации `NoRestrictedWords`:**

   ```bash
   php artisan make:rule NoRestrictedWords
   ```

2. **Пример реализации правила:**

   ```php
   public function validate(string $attribute, mixed $value, Closure $fail): void
   {
       $restrictedWords = ['запретное', 'недопустимое'];
       foreach ($restrictedWords as $word) {
           if (stripos($value, $word) !== false) {
               $fail("Поле :attribute содержит запрещенное слово: {$word}.");
           }
       }
   }
   ```

3. Применил правило в `CreateTaskRequest` и `UpdateTaskRequest`.

---

### Контрольные вопросы

1. **Что такое валидация данных и зачем она нужна?**  
   Это процесс проверки данных на соответствие заданным критериям для защиты от некорректного ввода и предотвращения ошибок.

2. **Как обеспечить защиту формы от CSRF-атак в Laravel?**  
   Использовать директиву `@csrf` в форме.

3. **Как создать и использовать собственные классы запросов (Request) в Laravel?**  
   Класс создается командой `php artisan make:request`. Используется в контроллере для обработки и валидации входящих данных.

4. **Как защитить данные от XSS-атак при выводе в представлении?**  
   Использовать функцию `{{ }}`, которая экранирует HTML-теги.

---

### Вывод

В ходе данной лабораторной работы я научился создавать формы, реализовывать валидацию данных, обрабатывать ошибки и защищать формы от атак. Реализация дополнительного задания с кастомным правилом валидации улучшила мои знания о работе с правилами в Laravel.
