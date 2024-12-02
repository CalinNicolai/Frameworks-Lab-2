# Отчёт по лабораторной работе №5: Компоненты безопасности в Laravel

---

### Цель работы

Целью данной лабораторной работы было освоение работы с компонентами безопасности Laravel, включая аутентификацию,
авторизацию, защиту маршрутов, управление ролями и защиту от CSRF-атак. Дополнительно было реализовано логирование
действий пользователя и настройка сброса пароля.

---

### Условие

В рамках работы я выполнил следующие задачи:

1. Реализовал базовую аутентификацию пользователей, включая регистрацию, вход и выход.
2. Настроил авторизацию для доступа к личным кабинетам пользователей.
3. Создал систему ролей: Администратор и Пользователь.
4. Настроил доступ к маршрутам и страницам в зависимости от роли пользователя.
5. Обеспечил защиту форм от CSRF-атак.
6. Добавил функционал сброса пароля.
7. (Дополнительно) Настроил логирование действий пользователей.

---

### Выполнение работы

#### №1. Подготовка к работе

Продолжил выполнение лабораторной работы на предыдущих лабораторных работах.

---

#### №2. Аутентификация пользователей

1. **Создал `AuthController`** для управления аутентификацией.

2. Реализовал методы:

    - `register()`: Отображает форму регистрации.
    - `storeRegister()`: Обрабатывает регистрацию пользователя.
    - `login()`: Отображает форму входа.
    - `storeLogin()`: Обрабатывает вход пользователя.
    - `logout()`: Выполняет выход пользователя.

3. Пример метода регистрации:

   ```php
   public function storeRegister(Request $request)
   {
       $validated = $request->validate([
           'name' => 'required|string|max:255',
           'email' => 'required|string|email|max:255|unique:users',
           'password' => 'required|string|min:8|confirmed',
       ]);

       $user = User::create([
           'name' => $validated['name'],
           'email' => $validated['email'],
           'password' => bcrypt($validated['password']),
       ]);

       Auth::login($user);

       return redirect()->route('dashboard')->with('success', 'Вы успешно зарегистрировались!');
   }
   ```

4. **Настроил маршруты** для регистрации, входа и выхода:

   ```php
   Route::get('/register', [AuthController::class, 'register'])->name('register');
   Route::post('/register', [AuthController::class, 'storeRegister']);
   Route::get('/login', [AuthController::class, 'login'])->name('login');
   Route::post('/login', [AuthController::class, 'storeLogin']);
   Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
   ```

5. **Обновил представления** для форм регистрации и входа.

6. Проверил корректность работы регистрации, входа и выхода.

---

#### №3. Аутентификация с использованием готовых компонентов

1. Установил Laravel Breeze:

   ```bash
   composer require laravel/breeze --dev
   php artisan breeze:install
   npm install && npm run dev
   php artisan migrate
   ```

2. Проверил маршруты `/register`, `/login`, `/logout`. Убедился, что они работают корректно.

---

#### №4. Авторизация пользователей

1. **Реализовал личный кабинет** с маршрутом `/dashboard`, доступ к которому имеют только авторизованные пользователи.

2. **Настроил middleware `auth`** для защиты маршрута:

   ```php
   Route::get('/dashboard', function () {
       return view('dashboard');
   })->middleware('auth')->name('dashboard');
   ```

3. Обновил представление личного кабинета для отображения имени пользователя:

   ```blade
   <h1>Добро пожаловать, {{ auth()->user()->name }}!</h1>
   ```

---

#### №5. Роли пользователей

1. **Добавил роли в таблицу `users`:**

   ```bash
   php artisan make:migration add_role_to_users_table --table=users
   ```

   В файле миграции:

   ```php
   Schema::table('users', function (Blueprint $table) {
       $table->string('role')->default('user'); // Возможные значения: 'admin', 'user'
   });
   ```

   Выполнил миграцию:

   ```bash
   php artisan migrate
   ```

2. **Настроил проверку ролей с помощью Gate:**

   В файле `AuthServiceProvider` добавил:

   ```php
   use Illuminate\Support\Facades\Gate;

   Gate::define('view-any-dashboard', function ($user) {
       return $user->role === 'admin';
   });
   ```

3. **Использовал проверки в контроллере:**

   ```php
   public function showDashboard()
   {
       if (Gate::allows('view-any-dashboard')) {
           $users = User::all(); // Администратор видит всех пользователей
           return view('admin.dashboard', compact('users'));
       }

       return view('user.dashboard'); // Пользователь видит только свой кабинет
   }
   ```

4. Добавил middleware для проверки ролей.

---

#### №6. Выход и защита от CSRF

1. **Добавил кнопку выхода:**

   ```blade
   <form action="{{ route('logout') }}" method="POST">
       @csrf
       <button type="submit">Выйти</button>
   </form>
   ```

2. Убедился, что все формы используют директиву `@csrf` для защиты от CSRF-атак.

---

#### №7. Сброс пароля

1. Настроил сброс пароля с использованием команды:

   ```bash
   php artisan make:auth
   ```

2. Убедился, что маршруты `/password/reset` работают корректно.

---

#### №8. Логирование действий (дополнительно)

1. **Создал middleware для логирования действий пользователя:**

   ```php
   php artisan make:middleware LogUserActivity
   ```

2. В middleware:

   ```php
   public function handle($request, Closure $next)
   {
       \Log::info('Пользователь выполнил действие', [
           'user_id' => auth()->id(),
           'url' => $request->url(),
           'method' => $request->method(),
           'data' => $request->all(),
       ]);

       return $next($request);
   }
   ```

3. Зарегистрировал middleware в `Kernel.php` и применил к защищённым маршрутам.

---

### Контрольные вопросы

1. **Какие готовые решения для аутентификации предоставляет Laravel?**  
   Laravel Breeze, Fortify, Jetstream, Laravel Passport, Laravel Sanctum.

2. **Какие методы аутентификации пользователей вы знаете?**  
   Email и пароль, OAuth2, токены API, социальные сети (Google, Facebook и др.).

3. **Чем отличается аутентификация от авторизации?**  
   Аутентификация — это подтверждение личности пользователя, авторизация — это проверка прав доступа к ресурсам.

4. **Как обеспечить защиту от CSRF-атак в Laravel?**  
   Использовать директиву `@csrf` в формах и встроенное middleware для проверки токенов CSRF.

---

### Вывод

В ходе данной лабораторной работы я освоил работу с основными компонентами безопасности Laravel. Я реализовал
аутентификацию и авторизацию, защитил формы от CSRF-атак, настроил роли пользователей и маршруты в зависимости от ролей.
Дополнительно я добавил логирование действий пользователей, что расширило мои знания о разработке безопасных приложений.
