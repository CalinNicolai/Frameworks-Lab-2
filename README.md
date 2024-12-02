Отчёт по лабораторной работе №3: Основы работы с базами данных в Laravel
------------------------------------------------------------------------

### Цель работы

Целью данной лабораторной работы было знакомство с основными принципами работы с базами данных в Laravel, создание
миграций, моделей и сидов, а также настройка связей между моделями в рамках веб-приложения To-Do App.

### Условие

В этой лабораторной работе я продолжил разработку приложения To-Do App, добавив функциональность работы с базой данных,
а также создал модели, миграции, фабрики и сиды для генерации тестовых данных.

### Выполнение работы

#### №1. Подготовка к работе

Для выполнения задания я выбрал СУБД MySQL. В файле `.env` настроил переменные окружения для подключения к базе данных:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_app
DB_USERNAME=root
DB_PASSWORD=пароль
```

После этого я создал новую базу данных `todo_app` через MySQL.

#### №2. Создание моделей и миграций

1. **Модель Category:** Я создал модель категории и миграцию для неё с помощью команды:

    ```bash
    php artisan make:model Category -m
    ````

   ```php
   Schema::create('categories', function (Blueprint $table) {
   $table->id();
   $table->string('name');
   $table->text('description')->nullable();
   $table->timestamps();
   });
   ```

2. **Модель Task:** Создал модель задачи и миграцию:

   ```bash
   php artisan make:model Task -m
    ```
   В миграции определил поля:

   ```php
   Schema::create('tasks', function (Blueprint $table) {
   $table->id();
   $table->string('title');
   $table->text('description')->nullable();
   $table->timestamps();
   });
   ```

3. **Модель Tag:** Создал модель тегов и миграцию:

   ```bash
   php artisan make:model Tag -m
   ```

   В миграции для тегов:

   ```php
   Schema::create('tags', function (Blueprint $table) {
   $table->id();
   $table->string('name');
   $table->timestamps();
   });
   ```

После этого я запустил миграции:

```bash
php artisan migrate
```
1. В каждую модель (Category, Task, Tag) добавил поле `$fillable` для массового заполнения данных:

   ```php
    protected $fillable = ['name', 'description'];
    ```
#### №3. Связь между таблицами

1. **Связь категорий и задач:** Создал миграцию для добавления поля `category_id` в таблицу `tasks`:

   ```bash
    php artisan make:migration add_category_id_to_tasks_table --table=tasks
   ```

   В миграции:

   ```php
   Schema::table('tasks', function (Blueprint $table) {
   $table->foreignId('category_id')->constrained()->onDelete('cascade');
   });
   ```

2. **Связь задач и тегов:** Для реализации связи многие ко многим создал промежуточную таблицу:

   ```bash
   php artisan make:migration create_task_tag_table
   ```

   В миграции определил структуру:

   ```php
   Schema::create('task_tag', function (Blueprint $table) {
   $table->id();
   $table->foreignId('task_id')->constrained()->onDelete('cascade');
   $table->foreignId('tag_id')->constrained()->onDelete('cascade');
   });
   ```

Запустил миграции для обновления структуры базы данных:

```bash
php artisan migrate
```

#### №4. Связи между моделями

1. В модель **Category** добавил метод `tasks()` для связи один ко многим:

   ```php
   public function tasks() {
   return $this->hasMany(Task::class);
   }
   ```

2. В модель **Task** добавил методы:

    - Связь с категорией:

      ```php
      public function category() {
      return $this->belongsTo(Category::class);
      }
      ```

    - Связь с тегами:

      ```php
      public function tags() {
      return $this->belongsToMany(Tag::class);
      }
      ```

3. В модель **Tag** добавил связь многие ко многим с задачами:

   ```php
   public function tasks() {
   return $this->belongsToMany(Task::class);
   }
   ```

#### №5. Создание фабрик и сидов

1. **Фабрики:** Создал фабрики для генерации данных для моделей:

   ```bash
   php artisan make:factory CategoryFactory --model=Category
   php artisan make:factory TaskFactory --model=Task
   php artisan make:factory TagFactory --model=Tag
   ```

   Пример фабрики для категории:

   ```php
   public function definition() {
   return [
   'name' => $this->faker->word,
   'description' => $this->faker->sentence,
   ];
   }
   ```

2. **Сиды:** Создал сиды для заполнения таблиц начальными данными:

   ```bash
   php artisan make:seeder CategorySeeder
   php artisan make:seeder TaskSeeder
   php artisan make:seeder TagSeeder
   ```

   В `DatabaseSeeder` добавил вызовы сидов:

   ```php
   $this->call([
   CategorySeeder::class,
   TaskSeeder::class,
   TagSeeder::class,
   ]);
   ```

Запустил сиды:

```bash
php artisan db:seed
```
#### №6. Работа с контроллерами и представлениями

1. **Метод index** в `TaskController` для получения всех задач:

   ```php
   public function index() {
   $tasks = Task::with(['category', 'tags'])->get();
   return view('tasks.index', compact('tasks'));
   }
   ```

2. **Метод show** для отображения отдельной задачи:

   ```php
   public function show($id) {
   $task = Task::with(['category', 'tags'])->findOrFail($id);
   return view('tasks.show', compact('task'));
   }
   ```

3. Обновил методы `create`, `store`, `edit`, `update` и `destroy` для работы с задачами в базе данных.

### Дополнительные задания

Я создал модель **Comment**, добавил миграции и связи между моделями Task и Comment. В представлениях добавил
возможность отображения комментариев к задачам, а также реализовал создание комментариев через контроллер.

### Контрольные вопросы

1. **Что такое миграции и для чего они используются?** Миграции --- это способ версионного контроля структуры базы
   данных. Они позволяют создавать, изменять и удалять таблицы в БД через код, что упрощает управление базой данных при
   разработке.

2. **Что такое фабрики и сиды, и как они упрощают процесс разработки и тестирования?** Фабрики используются для
   генерации тестовых данных, а сиды --- для заполнения базы данных начальными данными. Они упрощают создание большого
   объёма данных для тестирования и демонстрации функциональности приложения.

3. **Что такое ORM? В чем различия между паттернами DataMapper и ActiveRecord?** ORM (Object-Relational Mapping) --- это
   способ работы с базой данных через объекты. Паттерн ActiveRecord предполагает, что модель представляет собой одну
   таблицу БД, а DataMapper отделяет логику работы с БД от самих объектов.

4. **В чем преимущества использования ORM по сравнению с прямыми SQL-запросами?** ORM позволяет писать более читаемый и
   поддерживаемый код, облегчает управление связями между таблицами и автоматически защищает от SQL-инъекций.

5. **Что такое транзакции и зачем они нужны при работе с базами данных?** Транзакции --- это механизм, который позволяет
   объединить несколько операций с базой данных в одну атомарную операцию. Если одна из операций не выполнится,
   транзакция будет отменена, и все изменения откатятся, что защищает данные от неконсистентности.

### Вывод

В ходе данной лабораторной работы я освоил основные операции работы с базами данных в Laravel, такие как создание
миграций, моделей, сидов, фабрик, а также настройка связей между таблицами и использование ORM.
